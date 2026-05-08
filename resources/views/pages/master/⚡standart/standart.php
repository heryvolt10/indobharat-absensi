<?php

use Livewire\Component;
use App\Models\M_mt_table;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $filterSearch = '', $filterStatus = '2';
    public $sortField = 'nama', $sortDir = 'asc';

    public function mount()
    {
        help_update_sess_submenu(10);
    }

    public function render()
    {
        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage(); //

        $query = M_mt_table::detail('', 1, $this->filterSearch);
        if ($this->sortField !== '') {
            $query .= " ORDER BY " . $this->sortField . " " . $this->sortDir;
        }
        $allRecords = DB::select($query);
        $totalRecords = count($allRecords);

        // 2. Manually slice the array
        $offset = $currentPage * $perPage - $perPage;
        $itemsForCurrentPage = array_slice($allRecords, $offset, $perPage);

        // 3. Instantiate LengthAwarePaginator
        $paginator = new LengthAwarePaginator($itemsForCurrentPage, $totalRecords, $perPage, $currentPage, [
            'path' => request()->path(),
            'query' => request()->query(),
        ]);
        return $this->view([
            'tb_list_status' => help_get_status(1),
            'data_rows' => $paginator,
            'accessSubMenu' => help_user_access_submenu(session('submenu_id')),
        ]);
    }

    public function updatedfilterSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDir = 'asc';
            $this->sortField = $field;
        }
    }
};
