<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExternalPlatform as ExternalSolution;
use Livewire\WithPagination;

class ExternalSolutionsTable extends Component
{
    use WithPagination;

    public $status;
    public $subStatus = 'prospective';

    // --- NEW: Properties for Search and Filters ---
    public $search = '';
    public $filterDevelopedBy = '';
    public $developers;

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($status)
    {
        $this->status = $status;
        if ($this->status === 'prospective') {
            $this->subStatus = 'prospective';
        }
        // Populate the developers dropdown for filtering
        $this->developers = ExternalSolution::select('developed_by')->distinct()->whereNotNull('developed_by')->orderBy('developed_by')->pluck('developed_by');
    }

    public function setSubStatus($subStatus)
    {
        $this->subStatus = $subStatus;
        $this->resetPage();
    }

    public function delete($id)
    {
        $solution = ExternalSolution::find($id);
        if ($solution) {
            $solution->delete();
            session()->flash('success', 'External solution deleted successfully.');
        } else {
            session()->flash('error', 'Could not find the solution to delete.');
        }
    }

    public function render()
    {
        $query = ExternalSolution::query();

        // Handle main status
        if ($this->status === 'operational') {
            $query->where('status', 'operational');
        } elseif ($this->status === 'prospective') {
            $query->where('status', $this->subStatus); // 'prospective' or 'in-progress'
        } elseif (in_array($this->status, ['retired', 'abandoned'])) {
            $query->where('status', $this->status);
        }

        // --- NEW: Apply Search Filter ---
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('platform_name', 'like', '%' . $this->search . '%')
                  ->orWhere('platform_owner', 'like', '%' . $this->search . '%')
                  ->orWhere('developed_by', 'like', '%' . $this->search . '%');
            });
        }

        // --- NEW: Apply 'Developed By' Filter ---
        if (!empty($this->filterDevelopedBy)) {
            $query->where('developed_by', $this->filterDevelopedBy);
        }

        $solutions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.external-solutions-table', [
            'solutions' => $solutions
        ]);
    }
}