<?php

namespace App\Http\Controllers\MyWork;

use App\Http\Controllers\Controller;
use App\Models\{WeeklyPlan, ExternalPlatform, InternalPlatform, Employee};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyPlansExport;
use App\Exports\WeeklyPlansByWeekExport;
use App\Exports\BackupMatrixExport;

class WeeklyPlanController extends Controller
{
    /**
     * Resolve the Employee ID for the current user:
     * 1) use User->employee_id if present
     * 2) else find-or-create by email
     * 3) else create by name only
     */
    protected function resolveEmployeeId(Request $request): int
    {
        $user = $request->user();

       if ($user && $user->employee_id) {
            return (int) $user->employee_id;
        }

        $email = $user?->email;
        $name  = $user?->name ?? 'Unknown User';

        if ($email) {
            // Use YOUR column names: Emp_Email and Emp_Name
            $emp = Employee::firstOrCreate(
                ['Emp_Email' => $email],
                ['Emp_Name'  => $name]
            );
            return (int) $emp->Emp_ID; 
        }

        
        $emp = Employee::firstOrCreate(
            ['Emp_Name'  => $name],
            ['Emp_Email' => null]
        );
        return (int) $emp->Emp_ID; 
    }


    

    /** Convenience: role check */
    protected function isAdmin(Request $request): bool
    {
        return ($request->user()->role ?? null) === 'Administrator';
    }

    /**
     * List (search + per-page) with "last updated" meta
     * Route: mywork.weekly.update
     */
    public function updateIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $perPage = (int) $request->query('per_page', 10);

        $allowed = [10, 20, 30, 40, 50];
        if (! in_array($perPage, $allowed, true)) {
            $perPage = 10;
        }

        $plans = WeeklyPlan::with(['employee','externalPlatforms','internalPlatforms'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->whereHas('externalPlatforms', function ($q2) use ($q) {
                          $q2->where('platform_name', 'like', "%{$q}%");
                      })
                      ->orWhereHas('internalPlatforms', function ($q3) use ($q) {
                          $q3->where('app_name', 'like', "%{$q}%");
                      })
                      ->orWhereHas('employee', function ($q4) use ($q) {
                          $q4->where('emp_name', 'like', "%{$q}%")
                             ->orWhere('emp_email', 'like', "%{$q}%");
                      })
                      ->orWhere('workplan_desc', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('start_date')
            ->paginate($perPage)
            ->appends($request->query());

        $lastUpdatedPlan = WeeklyPlan::orderByDesc('updated_at')->first();

        // NOTE: weekly views live under resources/views/mywork/...
        return view('mywork.weekly.update', [
            'plans'           => $plans,
            'q'               => $q,
            'perPage'         => $perPage,
            'lastUpdatedPlan' => $lastUpdatedPlan,
        ]);
    }

    /**
     * Show create form (dropdowns from DB)
     */
    public function create()
    {
        // next Monday → Friday defaults
        $monday = Carbon::now()->next(Carbon::MONDAY);
        $friday = (clone $monday)->addDays(4);

        $externalOptions = ExternalPlatform::orderBy('platform_name')
            ->get(['platform_id','platform_name']);
        $internalOptions = \App\Models\InternalPlatform::orderBy('App_Name')
            ->get(['ID', 'App_Name']);

        return view('mywork.weekly.create', [
            'week_start'      => $monday->toDateString(),
            'week_end'        => $friday->toDateString(),
            'externalOptions' => $externalOptions,
            'internalOptions' => $internalOptions,
        ]);
    }

    /**
     * Store new weekly plan (multi-select external/internal)
     * Require at least one of the two arrays to have values.
     */
    public function store(Request $request)
    {
        $employeeId = $this->resolveEmployeeId($request);

        $data = $request->validate([
            'week_start'              => ['required','date'],                                // → start_date
            'week_end'                => ['required','date','after_or_equal:week_start'],   // → end_date
            'external_platform_id'    => ['nullable','array'],
            'external_platform_id.*'  => ['integer','exists:external_platforms,platform_id'],
            'internal_platform_id'    => ['nullable','array'],
            'internal_platform_id.*'  => ['integer','exists:Internal_Platforms,ID'],
            'week'                    => ['nullable','integer','between:1,53'],
            'details'                 => ['nullable','string','max:4000'],                  // → workplan_desc
            'updated_on'              => ['nullable','date'],
        ]);

        $extIds = array_values(array_unique($data['external_platform_id'] ?? []));
        $intIds = array_values(array_unique($data['internal_platform_id'] ?? []));

        if (empty($extIds) && empty($intIds)) {
            return back()
                ->withErrors([
                    'external_platform_id' => 'Pick at least one External or Internal platform.',
                    'internal_platform_id' => 'Pick at least one External or Internal platform.',
                ])->withInput();
        }

        try {
            $plan = WeeklyPlan::create([
                'start_date'    => $data['week_start'],
                'end_date'      => $data['week_end'],
                'workplan_desc' => $data['details'] ?? null,
                // NOTE: in this app, updated_by stores employee_id
                'updated_by'    => $employeeId,
                'updated_on'    => $data['updated_on'] ?? now()->toDateString(),
                'week'          => $data['week'] ?? null,
            ]);

            // attach many-to-many selections
            $plan->externalPlatforms()->sync($extIds);
            $plan->internalPlatforms()->sync($intIds);
        } catch (QueryException $e) {
            throw $e;
        }

        return redirect()
            ->route('my-work.weekly.update')
            ->with('ok', 'Weekly plan created.');
    }

    /**
     * Edit form
     */
    public function edit(WeeklyPlan $plan)
    {
        $externalOptions = ExternalPlatform::orderBy('platform_name')
            ->get(['platform_id','platform_name']);
        $internalOptions = \App\Models\InternalPlatform::orderBy('App_Name')
            ->get(['ID', 'App_Name']);

        // Preselected IDs for multi-selects
        $selectedExternalIds = $plan->externalPlatforms()->pluck('external_platforms.platform_id')->toArray();
        $selectedInternalIds = $plan->internalPlatforms()->pluck('Internal_Platforms.ID')->toArray();
        return view('mywork.weekly.edit', [
            'plan'                => $plan,
            'externalOptions'     => $externalOptions,
            'internalOptions'     => $internalOptions,
            'selectedExternalIds' => $selectedExternalIds,
            'selectedInternalIds' => $selectedInternalIds,
        ]);
    }

    /**
     * Update a plan (multi-select external/internal)
     */
    public function update(Request $request, WeeklyPlan $plan)
    {
        $employeeId = $this->resolveEmployeeId($request);

        $data = $request->validate([
            'week_start'              => ['required','date'],
            'week_end'                => ['required','date','after_or_equal:week_start'],
            'external_platform_id'    => ['nullable','array'],
            'external_platform_id.*'  => ['integer','exists:external_platforms,platform_id'],
            'internal_platform_id'    => ['nullable','array'],
            'internal_platform_id.*'  => ['integer','exists:Internal_Platforms,ID'],
            'week'                    => ['nullable','integer','between:1,53'],
            'details'                 => ['nullable','string','max:4000'],
            'updated_on'              => ['nullable','date'],
        ]);

        $extIds = array_values(array_unique($data['external_platform_id'] ?? []));
        $intIds = array_values(array_unique($data['internal_platform_id'] ?? []));

        if (empty($extIds) && empty($intIds)) {
            return back()
                ->withErrors([
                    'external_platform_id' => 'Pick at least one External or Internal platform.',
                    'internal_platform_id' => 'Pick at least one External or Internal platform.',
                ])->withInput();
        }

        try {
            $plan->update([
                'start_date'    => $data['week_start'],
                'end_date'      => $data['week_end'],
                'workplan_desc' => $data['details'] ?? null,
                // keep tracking who updated (employee_id)
                'updated_by'    => $employeeId,
                'updated_on'    => $data['updated_on'] ?? now()->toDateString(),
                'week'          => $data['week'] ?? null,
            ]);

            $plan->externalPlatforms()->sync($extIds);
            $plan->internalPlatforms()->sync($intIds);
        } catch (QueryException $e) {
            throw $e;
        }

        return redirect()
            ->route('my-work.weekly.update')
            ->with('ok', 'Weekly plan updated.');
    }

    /**
     * Delete a plan
     */
    public function destroy(WeeklyPlan $plan)
    {
        try { $plan->externalPlatforms()->detach(); } catch (\Throwable $e) {}
        try { $plan->internalPlatforms()->detach(); } catch (\Throwable $e) {}

        $plan->delete();
        return back()->with('ok','Weekly plan deleted.');
    }

    /**
     * Weekly Plan Report (select by start_date|end_date)
     * Now also passes $exportScope to Blade for role-aware export button.
     */
    public function report(Request $request)
    {
        $weeks = WeeklyPlan::select('start_date','end_date')
            ->distinct()
            ->orderByDesc('start_date')
            ->get();

        $selected = $request->query('range'); // "YYYY-MM-DD|YYYY-MM-DD"
        $plans = collect();

        if ($selected && Str::contains($selected, '|')) {
            [$start,$end] = explode('|', $selected, 2);
            $plans = WeeklyPlan::with(['employee','externalPlatforms','internalPlatforms'])
                ->whereDate('start_date', $start)
                ->whereDate('end_date',   $end)
                ->orderBy('updated_by')
                ->get();
        }

        // Role-aware export scope for the UI (server still enforces this!)
        $exportScope = $this->isAdmin($request) ? 'all' : 'mine';

        return view('mywork.weekly.report', compact('weeks','plans','selected','exportScope'));
    }

    /**
     * Export selected week’s report (role-aware).
     * Accepts ?range=YYYY-MM-DD|YYYY-MM-DD and optional ?scope=all|mine
     * - Admins: may export 'all'
     * - Others: forced to 'mine'
     */
    public function exportWeek(Request $request)
    {
        $data = $request->validate([
            'range' => ['required','regex:/^\d{4}-\d{2}-\d{2}\|\d{4}-\d{2}-\d{2}$/'],
            'scope' => ['nullable','in:all,mine'],
        ]);

        [$start, $end] = explode('|', $data['range'], 2);

        $startDate = Carbon::parse($start)->startOfDay();
        $endDate   = Carbon::parse($end)->endOfDay();

        $isAdmin = $this->isAdmin($request);
        $requestedScope = $data['scope'] ?? 'mine';
        $scope = $isAdmin && $requestedScope === 'all' ? 'all' : 'mine';

        // Base query for the selected week
        $q = WeeklyPlan::query()
            ->with(['employee','externalPlatforms','internalPlatforms'])
            ->whereDate('start_date', '>=', $startDate)
            ->whereDate('end_date',   '<=', $endDate);

        if ($scope === 'mine') {
            $employeeId = $this->resolveEmployeeId($request);
            $uEmail     = $request->user()->email ?? null;

            // Ownership: prefer updated_by (employee_id), allow email match via relation
            $q->where(function ($sub) use ($employeeId, $uEmail) {
                $sub->where('updated_by', $employeeId);

                if ($uEmail) {
                    $sub->orWhereHas('employee', function ($qq) use ($uEmail) {
                        $qq->where('emp_email', $uEmail);
                    });
                }
            });
        }

        // Filename reflects the enforced scope
        $file = sprintf(
            'weekly-plans_%s_to_%s_%s.xlsx',
            $startDate->format('Ymd'),
            $endDate->format('Ymd'),
            $scope
        );

        // Use a query-driven export (streams rows)
        return Excel::download(new WeeklyPlansByWeekExport($q, $startDate, $endDate, $scope), $file);
    }

    /**
     * Export all weekly plans (admin-only recommended).
     */
    public function exportAll()
    {
        return Excel::download(new WeeklyPlansExport, 'weekly-plans_all.xlsx');
    }

    /* -----------------------------------------------------------------
     |  Backup Matrix (READ-ONLY): index + download
     |------------------------------------------------------------------ */

    /** Filter InternalPlatform rows “owned by me” using user->name */
    protected function ownedInternalPlatformsQuery(Request $request)
    {
        $userName = trim((string) $request->user()->name);

        if ($userName === '') {
            return InternalPlatform::query()->whereRaw('1=0');
        }

        return InternalPlatform::query()
            ->where(function ($q) use ($userName) {
                $q->where('developed_by', $userName)
                  ->orWhere('app_op_owner', $userName)
                  ->orWhere('app_business_owner', $userName);
            });
    }

    /**
     * Backup Matrix index — role-aware list
     * - Admins: ALL apps
     * - Others: only "owned by me"
     */
    public function backupMatrixIndex(Request $request)
    {
        $isAdmin = $this->isAdmin($request);

        $apps = ($isAdmin ? InternalPlatform::query() : $this->ownedInternalPlatformsQuery($request))
            ->orderBy('app_name')
            ->get();

        // IMPORTANT: your file is resources/views/mywork/backup-matrix.blade.php
        return view('mywork.backup-matrix', compact('apps'));
    }

    /**
     * Download Backup Matrix Excel — role-aware & server-enforced.
     * Accepts ?scope=all|mine but forces non-admins to 'mine'.
     */
    public function backupMatrixDownload(Request $request)
    {
        $data = $request->validate([
            'scope' => ['nullable', 'in:all,mine'],
        ]);

        $isAdmin = $this->isAdmin($request);
        $requestedScope = $data['scope'] ?? 'mine';
        $scope = $isAdmin && $requestedScope === 'all' ? 'all' : 'mine';

        // Build query according to enforced scope
        $query = $scope === 'all'
            ? InternalPlatform::query()
            : $this->ownedInternalPlatformsQuery($request);

        $userName = (string) ($request->user()->name ?? '');
        $filename = "backup-matrix_{$scope}.xlsx";

        return Excel::download(
            new BackupMatrixExport($query, $scope, $userName),
            $filename
        );
    }
}
