<?php

use Livewire\Component;

use App\Models\M_mt_karyawan;
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

    public $id_header, $nama, $NIK, $no_npwp, $no_bpjs, $nama_bank, $no_rek, $nama_rek, $alamat, $tgl_bekerja,
        $f_divisi, $f_divisi_tag,  $f_jabatan, $f_jabatan_tag,  $f_role, $f_role_tag,  $f_gender, $f_gender_tag,
        $f_agama, $f_agama_tag,  $f_ptkp, $f_ptkp_tag,
        $f_status, $f_status_tag, $f_org, $f_org_tag;

    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = 'org', $sortDir = 'ASC';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;


    public function mount()
    {
        help_update_sess_submenu(13);
    }

    public function render()
    {
        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage();

        $query = M_mt_karyawan::detail('', 1, $this->filterSearch, $this->filterStatus);
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
            $data_render =  M_mt_karyawan::detail($this->id_header);
            $this->id_header = $data_render->id;
            $this->nama = $data_render->nama;
            $this->NIK = $data_render->NIK;
            $this->no_npwp = $data_render->no_npwp;
            $this->no_bpjs = $data_render->no_bpjs;
            $this->nama_bank = $data_render->nama_bank;
            $this->no_rek = $data_render->no_rek;
            $this->nama_rek = $data_render->nama_rek;
            $this->alamat = $data_render->alamat;
            $this->tgl_bekerja = $data_render->tgl_bekerja;
            $this->f_divisi = $data_render->f_divisi;
            $this->f_divisi_tag = $data_render->divisi;
            $this->f_jabatan = $data_render->f_jabatan;
            $this->f_jabatan_tag = $data_render->jabatan;
            $this->f_role = $data_render->f_role;
            $this->f_role_tag = $data_render->role;
            $this->f_gender = $data_render->f_gender;
            $this->f_gender_tag = $data_render->gender;
            $this->f_agama = $data_render->f_agama;
            $this->f_agama_tag = $data_render->agama;
            $this->f_ptkp = $data_render->f_ptkp;
            $this->f_ptkp_tag = $data_render->ptkp;
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
            'nama' => 'required|max:250|unique:mt_karyawan,nama,' . $this->id_header,
            'NIK' => 'required|max:250|unique:mt_karyawan,NIK,' . $this->id_header,
            'no_npwp' => 'required|max:250',
            'no_bpjs' => 'required|max:250',
            'nama_bank' => 'required|max:250',
            'no_rek' => 'required|max:250',
            'nama_rek' => 'required|max:250',
            'alamat' => 'required|max:250',
            'tgl_bekerja' => 'required',
            'f_divisi' => 'required',
            'f_jabatan' => 'required',
            'f_role' => 'required',
            'f_gender' => 'required',
            'f_agama' => 'required',
            'f_ptkp' => 'required',
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
                    'NIK' => $this->NIK,
                    'no_npwp' => $this->no_npwp,
                    'no_bpjs' => $this->no_bpjs,
                    'nama_bank' => $this->nama_bank,
                    'no_rek' => $this->no_rek,
                    'nama_rek' => $this->nama_rek,
                    'alamat' => $this->alamat,
                    'tgl_bekerja' => $this->tgl_bekerja,
                    'f_divisi' => $this->f_divisi,
                    'f_jabatan' => $this->f_jabatan,
                    'f_role' => $this->f_role,
                    'f_gender' => $this->f_gender,
                    'f_agama' => $this->f_agama,
                    'f_ptkp' => $this->f_ptkp,
                    'f_status' => $this->f_status,
                    'f_org' => $this->f_org,
                ];

                if ($this->id_header == "") {
                    $data_store_add = [
                        'password' => Hash::make(ENV('DEFAULT_PASSWORD_USER')),
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_karyawan::create($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_karyawan::withTrashed()->findOrFail($this->id_header)->update($data_output);

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
            $postDelete = M_mt_karyawan::withTrashed()->findOrFail($id);
            $postDelete->delete();

            $postDelete->f_status = 1;
            $postDelete->update();

            $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
        } catch (\Exception $th) {
            $this->dispatch('sweet-alert', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
        }
    }

    public function export($filetype)
    {
        $titleExport = 'Master' . ' ' . session('submenu_nama');
        $papersize = 3;
        $submenu_id = session('submenu_id');
        $orientation = "landscape";
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
