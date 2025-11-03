<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalIssue;
use App\Models\ExternalIssue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class IssueReportController extends Controller
{
    /**
     * Display a combined list of recent issues from all sources.
     */
    public function recentIssuesIndex()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $internalIssues = DB::table('internal_issues')
            ->where('Issue_Start_Time', '>=', $threeMonthsAgo)
            ->select(
                'Issue_Start_Time',
                'Internal_APP_ID as system_name', 
                'Description'
            );

        $recentIssuesQuery = DB::table('external_issues')
            ->join('external_platforms', 'external_issues.Platform_ID', '=', 'external_platforms.platform_id')
            ->where('external_issues.Issue_Start_Time', '>=', $threeMonthsAgo)
            ->select(
                'external_issues.Issue_Start_Time',
                'external_platforms.platform_name as system_name', 
                'external_issues.Description'
            )
            ->unionAll($internalIssues)
            ->orderBy('Issue_Start_Time', 'desc');

        $recentIssues = $recentIssuesQuery->get();

        return view('report-incidents.other.index', compact('recentIssues'));
    }
}