<?php

namespace App\Livewire;

use App\Models\PpdbRegistration;
use Livewire\Component;
use Livewire\WithPagination;

class PpdbRegistrationsList extends Component
{
    use WithPagination;

    public int $perPage = 15;
    public string $search = '';
    public string $statusFilter = 'all';

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        // Initialize component
    }

    public function updateSearch()
    {
        $this->resetPage();
    }

    public function updateStatusFilter()
    {
        $this->resetPage();
    }

    public function getRegistrations()
    {
        $query = PpdbRegistration::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('student_name', 'like', "%{$this->search}%")
                    ->orWhere('parent_name', 'like', "%{$this->search}%")
                    ->orWhere('registration_number', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->latest('created_at')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.ppdb-registrations-list', [
            'registrations' => $this->getRegistrations(),
        ]);
    }
}
