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
    protected $paginationTheme = 'bootstrap'; // Use bootstrap for pagination styling

    // Filtering properties
    public $filterAppName = '';
    public $filterSdlcPhase = '';
    public $filterDevelopedBy = '';

    // Sorting properties
    public $sortBy = 'App_Name';
    public $sortDirection = 'asc';
    
    // This property will hold the data for the platform selected for the modal
    public $selectedPlatform;

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

  
    /**
     * This method is called when the "Details" button is clicked.
     * It finds the platform by its ID and loads it into our public property.
     */
    public function showDetails($platformId)
    {
        $this->selectedPlatform = InternalPlatform::find($platformId);
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

        // Paginate the results
        $platforms = $query->paginate(10);
     
        $sdlcPhasesList = SDLCphase::orderBy('OrderSeq')->pluck('Phase');
        
        // Assuming 'Developed_By' stores vendor names as strings
        $developers = InternalPlatform::where('EndUserType', '!=', 'SLT Employees')
                        ->whereNotNull('Developed_By')
                        ->where('Developed_By', '!=', '')
                        ->pluck('Developed_By')
                        ->unique()
                        ->sort();

        return view('livewire.consumer-platforms-table', [
            'platforms' => $platforms,
            'sdlcPhasesList' => $sdlcPhasesList,
            'developers' => $developers,
        ]);
    }
}