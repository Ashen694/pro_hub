<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternalPlatform;  

use App\Models\SDLCphase;
use App\Models\Employee;
use Livewire\Attributes\On;

class ConsumerPlatformsTable extends Component
{
    use WithPagination;

    // Filtering properties
    public $filterAppName = '';
    public $filterSdlcPhase = '';
    public $filterDevelopedBy = '';

    public $sortBy = 'App_Name';
    public $sortDirection = 'asc';
    

    // Reset page on any filter update
    public function updated()
    {
        $this->resetPage();
    }

   #[On('callSortByConsumer')]
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
        $this->reset(['filterAppName', 'filterSdlcPhase', 'filterDevelopedBy']);
        $this->resetPage();
    }


    public function render()
    {
        $query = InternalPlatform::query();

        $query->where('EndUserType', '!=', 'SLT Employees');

        $query->when($this->filterAppName, function ($q) {
            $q->where('App_Name', 'like', '%' . $this->filterAppName . '%');
        });

        $query->when($this->filterSdlcPhase, function ($q) {
            $q->where('SDLCPhase', $this->filterSdlcPhase);
        });

        $query->when($this->filterDevelopedBy, function ($q) {
            $q->where('Developed_By', $this->filterDevelopedBy);
        });

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Paginate the results using Livewire's standard method
        $platforms = $query->paginate(10);
     

        $sdlcPhasesList = \App\Models\SDLCphase::orderBy('OrderSeq')->pluck('Phase');
        $developers = \App\Models\Employee::orderBy('Emp_Name')->pluck('Emp_Name');

        return view('livewire.consumer-platforms-table', [
            'platforms' => $platforms,
            'sdlcPhasesList' => $sdlcPhasesList,
            'developers' => $developers,
        ]);
    }
}