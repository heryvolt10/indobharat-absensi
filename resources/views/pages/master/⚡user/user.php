<?php

use Livewire\Component;

use App\Models\M_users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndexExport;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id_header, $email, $name, $f_role, $f_role_tag, $f_status, $f_status_tag, $f_org, $f_org_tag;

    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = 'nama', $sortDir = 'ASC';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;


    public function mount()
    {
        help_update_sess_submenu(12);
    }

    public function render()
    {
        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage();

        $query = M_users::detail('', 1, $this->filterSearch, $this->filterStatus);
        if ($this->sortField !== '') {
            $query .= " ORDER BY " . $this->sortField . " " . $this->sortDir;
        }

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
            'list_table' => M_users::table_list(),
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
            $data_render =  M_users::detail($this->id_header);
            $this->id_header = $data_render->id;
            $this->name = $data_render->name;
            $this->email = $data_render->email;
            $this->f_role = $data_render->f_role;
            $this->f_role_tag = $data_render->role;
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

        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'email' => 'required|max:250|email|unique:users,email,' . $this->id_header,
            'name' => 'required|max:250|unique:users,name,' . $this->id_header,
            'f_role' => 'required',
            'f_status' => 'required',
            'f_org' => 'required',
        ];

        $this->valid_mesage = [
            'required' => 'Harus di isi',
            'max' => 'Maksimum karakter :max',
            'email' => 'Masukkan email sesuai format example@mail.com',
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
                    'email' => $this->email,
                    'name' => $this->name,
                    'f_role' => $this->f_role,
                    'f_status' => $this->f_status,
                    'f_org' => $this->f_org,
                ];

                if ($this->id_header == "") {
                    $data_store_add = [
                        'password' => Hash::make(ENV('DEFAULT_PASSWORD_USER')),
                        'image' => ENV('DEFAULT_IMG_user'),
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_users::create($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_users::withTrashed()->findOrFail($this->id_header)->update($data_output);

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
        try {
            $postDelete = M_users::withTrashed()->findOrFail($id);
            $postDelete->delete();

            $postDelete->f_status = 1;
            $postDelete->update();

            $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
        } catch (\Exception $th) {
            activity()->log($th->getMessage());
            $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
        }
    }

    public function export($filetype)
    {
        $titleExport = 'Master' . ' ' . session('submenu_nama');
        $papersize = 3;
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
