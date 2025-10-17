<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternalPlatform;
use App\Models\ParentProject;
use App\Models\Employee;
use App\Models\SDLCphase;
use Livewire\Attributes\On; // <-- IMPORT THIS ATTRIBUTE

class InternalSolutionsTable extends Component
{
    use WithPagination;

    // Route parameter
    public $status;

    // Filtering properties
    public $filterAppName = '';
    public $filterSdlcPhase = '';
    public $filterDevelopedBy = '';
    public $filterAppGroup = '';
    public $filterWithoutCr = false;

    // Sorting properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Mount lifecycle hook to get the status from the URL
    public function mount($status)
    {
        $this->status = $status;
    }

    // Reset page on any filter update
    public function updated()
    {
        $this->resetPage();
    }

    // =================================================================
    // CORRECTED: Added a listener attribute to the sortBy function
    // =================================================================
    #[On('callSortBy')]
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Function to reset all filters
    public function resetFilters()
    {
        $this->reset(['filterAppName', 'filterSdlcPhase', 'filterDevelopedBy', 'filterAppGroup', 'filterWithoutCr']);
        $this->resetPage();
    }

    // Delete a solution
    public function delete($id)
    {
        $solution = InternalPlatform::find($id);

        if (!$solution) {
            session()->flash('error', 'Solution not found.');
            return;
        }
        
        if ($solution->App_Category == 'Main Application' && $solution->changeRequests()->exists()) {
            session()->flash('error', 'Cannot delete this Main Application because it has associated Change Requests. Please delete them first.');
            return;
        }

        $solution->delete();
        session()->flash('success', 'Solution deleted successfully!');
    }
    
    // Toggle the "Operational without CR" filter
    public function toggleWithoutCrFilter($value)
    {
        $this->filterWithoutCr = $value;
    }

    // Render method to fetch data and return the view
    public function render()
    {
        $query = InternalPlatform::with(['parentProject', 'mainApplicationParent'])
            ->when($this->filterAppName, fn ($q) => $q->where('App_Name', 'like', '%' . $this->filterAppName . '%'))
            ->when($this->filterSdlcPhase, fn ($q) => $q->where('SDLCPhase', $this->filterSdlcPhase))
            ->when($this->filterDevelopedBy, fn ($q) => $q->where('Developed_By', $this->filterDevelopedBy))
            ->when($this->filterAppGroup, fn ($q) => $q->whereHas('parentProject', fn ($subQuery) => $subQuery->where('ParentProjectID', $this->filterAppGroup)));

        switch ($this->status) {
            case 'operational':
                $query->where('SDLCPhase', 'Maintenance');
                if ($this->filterWithoutCr) {
                    $query->where('App_Category', 'Main Application');
                }
                break;
            case 'in-progress':
            case 'recently-launched':
                $inProgressPhases = ['Proposal Preparation', 'Proposal Submitted', 'Requirement Gathering and Analysis', 'Design', 'Coding or Implementation', 'Testing', 'Deployment'];
                $query->whereIn('SDLCPhase', $inProgressPhases);
                break;
            case 'retired':
                $query->where('SDLCPhase', 'Retired');
                break;
            case 'abandoned':
                $query->where('SDLCPhase', 'Abandoned');
                break;
            default:
                $query->whereRaw('1 = 0');
                break;
        }

        $solutions = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        
        $developers = Employee::orderBy('Emp_Name')->pluck('Emp_Name')->unique();
        $sdlcPhasesList = SDLCphase::orderBy('OrderSeq')->pluck('Phase')->unique();
        $applicationGroups = ParentProject::orderBy('ParentProjectGroup')->get();

        return view('livewire.internal-solutions-table', [
            'solutions' => $solutions,
            'developers' => $developers,
            'sdlcPhasesList' => $sdlcPhasesList,
            'applicationGroups' => $applicationGroups,
        ]);
    }
}