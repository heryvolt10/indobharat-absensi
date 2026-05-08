<?php

use Livewire\Component;
use App\Exports\IndexExport;
use App\Models\M_mt_org;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use Livewire\Attributes\Layout;
use Maatwebsite\Excel\Facades\Excel;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id_header, $nama, $alamat, $email, $no_tlp, $kontak_person, $i_pusat, $tele_grup_id, $f_status, $f_status_tag;

    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = 'nama', $sortDir = 'ASC';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;

    public function mount()
    {
        help_update_sess_submenu(11);
    }

    public function render()
    {
        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage(); //

        $query = M_mt_org::detail('', 1, $this->filterSearch, $this->filterStatus);
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
            $data_render = M_mt_org::detail($this->id_header);
            $this->id_header = $data_render->id;
            $this->nama = $data_render->nama;
            $this->email = $data_render->email;
            $this->alamat = $data_render->alamat;
            $this->no_tlp = $data_render->no_tlp;
            $this->kontak_person = $data_render->kontak_person;
            $this->i_pusat = $data_render->i_pusat;
            $this->f_status = $data_render->f_status;
            $this->f_status_tag = $data_render->status;
        }

        $this->showForm = true;
        $this->showTable = false;
    }
    public function save()
    {
        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'nama' => 'required|max:250|unique:mt_org,nama,' . $this->id_header,
            'alamat' => 'required|max:250',
            'email' => 'required|max:250|email',
            'no_tlp' => 'required|max:250',
            'kontak_person' => 'required|max:250',
            'f_status' => 'required',
        ];

        $this->valid_mesage = [
            'required' => 'Harus di isi',
            'max' => 'Maksimum karakter :max',
            'email' => 'Masukkan email sesuai format example@mail.com',
            'unique' => 'Sudah ada dalam database',
        ];

        $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);

        if ($this->i_pusat == true) {
            if ($this->id_header) {
                $query = "SELECT A.i_pusat FROM mt_org A WHERE A.i_pusat = 1 AND A.id <> " . $this->id_header . " LIMIT 1 ";
            } else {
                $query = "SELECT A.i_pusat FROM mt_org A WHERE A.i_pusat = 1 LIMIT 1 ";
            }


            $data_cek = DB::select($query);

            if ($data_cek) {
                $validator->errors()->add('i_pusat', 'Sudah Ada Organisasi Sebagai Pusat');
            }
        }

        // ==================================== VALID INPUT =======================================
        if ($validator->errors()->count() > 0) {
            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
            return;
        } else {
            try {
                $data_store = [
                    'nama' => $this->nama,
                    'alamat' => $this->alamat,
                    'email' => $this->email,
                    'no_tlp' => $this->no_tlp,
                    'kontak_person' => $this->kontak_person,
                    'i_pusat' => $this->i_pusat == true ? 1 : 0,
                    'f_status' => $this->f_status,
                ];

                if ($this->id_header == "") {
                    $data_store_add = [
                        'image' => ENV('DEFAULT_IMG_ORG'),
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_org::create($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_org::withTrashed()->findOrFail($this->id_header)->update($data_store);

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
        $postDelete = M_mt_org::withTrashed()->findOrFail($id);
        $postDelete->delete();

        $postDelete->f_status = 1;
        $postDelete->update();

        $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
    }

    public function export($filetype)
    {

        $titleExport = 'Master' . ' ' . session('submenu_nama');
        $papersize = 9;
        $submenu_id = session('submenu_id');
        $orientation = "POTRAIT";
        $headStandar = 0; //0 Header Not Standar, 1 Head Standar

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
