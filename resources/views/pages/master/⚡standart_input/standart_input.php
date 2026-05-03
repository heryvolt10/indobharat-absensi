<?php

use Livewire\Component;
use App\Models\M_mt_table;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndexExport;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Url(history: true, keep: true)]
    public $refTable;

    public $id_header, $nama, $ket, $f_status, $f_status_tag, $f_org, $f_org_tag, $logtable, $urlModel;

    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = 'nama', $sortDir = 'asc';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;

    public function mount()
    {
        help_update_sess_submenu(10);

        if ($this->refTable == "mt_unit") {
            $this->urlModel = '\App\Models\M_mt_unit';
        } elseif ($this->refTable == "mt_gender") {
            $this->urlModel = '\App\Models\M_mt_gender';
        } elseif ($this->refTable == "mt_status") {
            $this->urlModel = '\App\Models\M_mt_status';
        } else {
            abort('404');
        }

        $this->js("changeStyleFilterStatus(" . $this->filterStatus . "); button_table_add_back_render(); setSubMenuMasterData();");
    }

    public function render()
    {
        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage(); //

        $query = $this->urlModel::detail('', 1, $this->filterSearch, $this->filterStatus);
        $query .= " ORDER BY " . $this->sortField . " " . $this->sortDir;
        $allRecords = DB::select($query);
        $totalRecords = count($allRecords);
        $this->listCount = $totalRecords;

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
            'lognama' => M_mt_table::where('set_table', $this->refTable)->first()->nama,
        ]);
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

    public function store($id = "")
    {
        $this->resetValidation();
        $this->resetExcept([
            'refTable',
            'urlModel',
            'filterSearch',
            'filterStatus'
        ]);

        $this->id_header = $id;

        if ($this->id_header != "") {
            $data_render = $this->urlModel::detail($this->id_header, null, null, null);
            $this->id_header = $data_render->id;
            $this->nama = $data_render->nama;
            $this->ket = $data_render->ket;
            $this->f_status = $data_render->f_status;
            $this->f_status_tag = $data_render->status;
            $this->f_org = $data_render->f_org;
            $this->f_org_tag = $data_render->org;
        }

        $this->showForm = true;
        $this->showTable = false;
    }
    public function save()
    {
        // ==================== Setting untuk variable angka ========================
        // ==================== Setting untuk variable angka END ========================

        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'nama' => 'required|max:250|unique:' . $this->refTable . ',nama,' . $this->id_header,
            'ket' => 'max:500',
            'f_status' => 'required',
            'f_org' => 'required',
        ];

        $this->valid_mesage = [
            'required' => 'Harus di isi',
            'max' => 'Maksimum karakter :max',
            'unique' => 'Sudah ada dalam database',
        ];

        $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);

        // ==================================== VALID INPUT =======================================
        if ($validator->errors()->count() > 0) {
            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
            return;
        } else {
            try {
                $data_store = [
                    'nama' => $this->nama,
                    'ket' => $this->ket == '' ? NULL : $this->ket,
                    'f_status' => $this->f_status,
                    'f_org' => $this->f_org,
                ];

                if ($this->id_header == "") {
                    $data_store_add = [
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = $this->urlModel::create($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = $this->urlModel::withTrashed()->findOrFail($this->id_header)->update($data_output);



                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
                    $this->resetValidation();
                }
            } catch (\Exception $th) {
                activity()->log($th->getMessage());
                $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
            }
        }
    }

    public function buttonBack()
    {

        $this->showForm = false;
        $this->showTable = true;
        $this->js("changeStyleFilterStatus(" . $this->filterStatus . "); button_table_add_back_render()");
    }

    public function updatedfilterSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {

        $postDelete = $this->urlModel::withTrashed()->findOrFail($id);
        $postDelete->delete();

        $postDelete->f_status = 1;
        $postDelete->update();

        $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
    }

    public function export($filetype)
    {
        $titleExport = 'Master' . ' ' . M_mt_table::where('set_table', $this->refTable)->first()->nama;
        $papersize = 9;
        $submenu_id = $this->refTable;
        $orientation = "potrait";
        $headStandar = 1; //0 Header Not Standar, 1 Head Standar

        if ($this->listCount > 0) {
            if ($filetype == "excel") {
                return Excel::download(new IndexExport($this->filterSearch, $this->filterStatus, $submenu_id, $titleExport, $papersize, $orientation, $headStandar), $titleExport . '.xlsx');
            } else {
                return Excel::download(new IndexExport($this->filterSearch, $this->filterStatus, $submenu_id, $titleExport, $papersize, $orientation, $headStandar), $titleExport . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
            }
        } else {
            $this->dispatch('sweet-alert', icon: 'info', title: 'Tidak Ada Data', text: '');
        }
    }
};
