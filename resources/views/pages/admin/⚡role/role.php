<?php

use Livewire\Component;

use App\Exports\IndexExport;
use App\Models\M_users_role;
use App\Models\M_users_access_menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id_header, $nama, $ket, $f_status, $f_status_tag, $f_org, $f_org_tag;

    public $ishow = [], $iadd = [], $isave = [], $iedit = [], $idelete = [];


    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = 'nama', $sortDir = 'ASC';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;

    public $showAccessRole = false;

    public $data_access_user = [];

    public function mount()
    {
        help_update_sess_submenu(3);
        $this->update_list_role();
    }

    public function render()
    {

        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage(); //

        $query = M_users_role::detail('', 1, $this->filterSearch, $this->filterStatus);
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
        ]);
    }


    public function store($id = "")
    {
        $this->resetValidation();
        $this->resetExcept([
            'filterSearch',
            'filterStatus',
        ]);

        $this->id_header = $id;
        if ($this->id_header != "") {
            $data_render = M_users_role::detail($this->id_header);
            $this->id_header = $data_render->id;
            $this->nama = $data_render->nama;
            $this->ket = $data_render->ket == NULL ? '' : $data_render->ket;
            $this->f_status = $data_render->f_status;
            $this->f_status_tag = $data_render->status;
            $this->f_org = $data_render->f_org;
            $this->f_org_tag = $data_render->org;


            if ($this->id_header) {
                $this->data_access_user = help_user_access_submenu_list($this->id_header);
            }

            $this->showAccessRole = true;
        }

        $this->showForm = true;
        $this->showTable = false;
    }

    public function save()
    {

        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'nama' => 'required|max:250|unique:users_role,nama,' . $this->id_header,
            'f_status' => 'required',
            'ket' =>  'max:500',
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

                    $execDB = M_users_role::create($data_output);
                    $this->update_list_role();
                    sleep(2);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_users_role::withTrashed()->findOrFail($this->id_header)->update($data_output);

                    foreach ($this->data_access_user as $data_acess) {
                        $dataAcess = M_users_access_menu::findOrFail($data_acess->id);

                        $dataAcess->update([
                            'ishow' => $data_acess->ishow == true ? 1 : 0,
                            'iadd' => $data_acess->iadd == true ? 1 : 0,
                            'isave' => $data_acess->isave == true ? 1 : 0,
                            'iedit' => $data_acess->iedit == true ? 1 : 0,
                            'idelete' => $data_acess->idelete == true ? 1 : 0,
                        ]);
                    }

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
                    $this->resetValidation();
                }

                $this->update_list_role();
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
        $this->showAccessRole = false;
    }
    public function updatedfilterSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDir = $this->sortDir === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortDir = 'ASC';
            $this->sortField = $field;
        }
    }

    public function delete($id)
    {
        $postDelete = M_users_role::withTrashed()->findOrFail($id);
        $postDelete->delete();

        $postDelete->f_status = 1;
        $postDelete->update();

        $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
    }


    public function update_list_role()
    {
        $pending_access_menu = M_users_access_menu::pending_access_menu();
        if ($pending_access_menu) {
            foreach ($pending_access_menu as $list_pending) {
                $data_store = [
                    'f_role' => $list_pending->f_role,
                    'f_submenu' =>  $list_pending->f_submenu,
                    'ishow' => $list_pending->ishow,
                    'isave' => $list_pending->isave,
                    'iadd' => $list_pending->iadd,
                    'iedit' => $list_pending->iedit,
                    'idelete' => $list_pending->idelete,
                    'create' => '#import',
                ];

                M_users_access_menu::create($data_store);
            }
        }
    }

    public function export($filetype)
    {

        $titleExport = 'Master' . ' ' . session('submenu_nama');
        $papersize = 9;
        $submenu_id = session('submenu_id');
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
