<?php

namespace App\Http\Livewire\Base;

use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseLive extends Component
{
	use WithPagination;

	public $deleteId;
    public $reset = false;
    public $searchTerm;
    public $checkEdit;

    public $perPage = 25;
    protected static function paginationView()
    {
        return 'livewire.common.pagination._pagination';
    }
    public function deleteId($id){

        $this->deleteId=$id;
    }
    public function resetSearch(){
        $this->reset = true;

    }
    public function updatingSearchTerm() {
        $this->resetPage();
    }
    public function updatingStore(){
        dd($this->checkEditPermission);
    }
    public function updatingSetDate() {
        $this->resetPage();
    }
    public function updatingPerPage() {
        $this->resetPage();
    }

    public function resetInputFields() {
        $this->resetPage();
        $this->resetValidation();
    }
}
