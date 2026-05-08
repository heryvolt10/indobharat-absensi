<?php

use Livewire\Component;

use App\Models\M_mt_ptkp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndexExport;
use App\Models\M_mt_periode;
use App\Models\M_mt_ter_ptkp;

new class extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id_header, $nama, $ket, $grup, $nilai, $persen, $tanggal, $tanggal_mulai, $f_status, $f_status_tag, $f_org, $f_org_tag;

    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = '', $sortDir = '';

    public $valid_role, $valid_mesage;


    public $showForm = false, $showTable = true;


    public $activeTab = 'tab1';


    public function mount()
    {
        help_update_sess_submenu(17);
    }

    public function render()
    {

        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage();

        if ($this->activeTab === 'tab1') {
            $query = "";
            $allRecords = "";
            $totalRecords = 0;
            $this->listCount = $totalRecords;
            $paginator = "";
        } else if ($this->activeTab === 'tab2') {
            $query = M_mt_ptkp::detail('', 1, $this->filterSearch, $this->filterStatus);
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
        } else if ($this->activeTab === 'tab3') {
            $query = M_mt_ter_ptkp::detail('', 1, $this->filterSearch, $this->filterStatus);
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
        } else {

            $query = M_mt_periode::detail('', 1, $this->filterSearch, $this->filterStatus);
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
        }

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
            'activeTab',
        ]);

        $this->id_header = $id;

        if ($this->id_header !== "") {


            if ($this->activeTab === 'tab1') {
            } else if ($this->activeTab === 'tab2') {
                $data_render = M_mt_ptkp::detail($this->id_header);
                $this->id_header = $data_render->id;
                $this->nama = $data_render->nama;
                $this->ket = $data_render->ket;
                $this->f_status = $data_render->f_status;
                $this->f_status_tag = $data_render->status;
                $this->f_org = $data_render->f_org;
                $this->f_org_tag = $data_render->org;
            } else if ($this->activeTab === 'tab3') {
                $data_render =  M_mt_ter_ptkp::detail($this->id_header);
                $this->id_header = $data_render->id;
                $this->grup = $data_render->grup;
                $this->nilai = $data_render->nilai;
                $this->persen = $data_render->persen;
                $this->f_status = $data_render->f_status;
                $this->f_status_tag = $data_render->status;
                $this->f_org = $data_render->f_org;
                $this->f_org_tag = $data_render->org;
            } else {
                $data_render =  M_mt_periode::detail($this->id_header);
                $this->id_header = $data_render->id;
                $this->tanggal = $data_render->tanggal;
                $this->tanggal_mulai = $data_render->tanggal_mulai;
                $this->f_status = $data_render->f_status;
                $this->f_status_tag = $data_render->status;
                $this->f_org = $data_render->f_org;
                $this->f_org_tag = $data_render->org;
            }
        }

        $this->showForm = true;
        $this->showTable = false;
    }

    public function save()
    {

        // ==================================== VALID INPUT =======================================

        if ($this->activeTab === 'tab1') {
        } else if ($this->activeTab === 'tab2') {
            $this->valid_role = [
                'nama' => 'required|max:250|unique:mt_ptkp,nama,' . $this->id_header,
                'ket' => 'max:500',
                'f_status' => 'required',
                'f_org' => 'required',
            ];
        } else if ($this->activeTab === 'tab3') {
            $this->valid_role = [
                'grup' => 'required',
                'nilai' => 'required',
                'persen' => 'required',
                'f_status' => 'required',
                'f_org' => 'required',
            ];
        } else {
            $this->valid_role = [
                'tanggal' => 'required',
                'tanggal_mulai' => 'required',
                'f_status' => 'required',
                'f_org' => 'required',
            ];
        }


        $this->valid_mesage = [
            'required' => 'Harus di isi',
            'max' => 'Maksimum karakter :max',
            'unique' => 'Sudah ada dalam database',
        ];

        $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);

        if ($this->activeTab == 'tab4') {
            if ($this->tanggal_mulai > 28) {
                $validator->errors()->add('tanggal_mulai', 'Harus diantara 1 - 28');
            }
        }

        // ==================================== VALID INPUT =======================================
        if ($validator->errors()->count() > 0) {

            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
            return;
        } else {
            try {

                if ($this->activeTab === 'tab1') {
                    $data_store = "";
                } else if ($this->activeTab === 'tab2') {
                    $data_store = [
                        'nama' => $this->nama,
                        'ket' => $this->ket == '' ? NULL : $this->ket,
                        'f_status' => $this->f_status,
                        'f_org' => $this->f_org,
                    ];
                } else if ($this->activeTab === 'tab3') {
                    $data_store = [
                        'grup' => $this->grup,
                        'nilai' => $this->nilai,
                        'persen' => $this->persen,
                        'f_status' => $this->f_status,
                        'f_org' => $this->f_org,
                    ];
                } else {
                    $data_store = [
                        'tanggal' => $this->tanggal,
                        'tanggal_mulai' => $this->tanggal_mulai,
                        'f_status' => $this->f_status,
                        'f_org' => $this->f_org,
                    ];
                }


                if ($this->id_header == "") {
                    $data_store_add = [
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    if ($this->activeTab === 'tab1') {
                        $execDB = "";
                    } else if ($this->activeTab === 'tab2') {
                        $execDB = M_mt_ptkp::create($data_output);
                    } else if ($this->activeTab === 'tab3') {
                        $execDB = M_mt_ter_ptkp::create($data_output);
                    } else {
                        $execDB = M_mt_periode::create($data_output);
                    }


                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    if ($this->activeTab === 'tab1') {
                        $execDB = "";
                    } else if ($this->activeTab === 'tab2') {
                        $execDB = M_mt_ptkp::withTrashed()->findOrFail($this->id_header)->update($data_output);
                    } else if ($this->activeTab === 'tab3') {
                        $execDB = M_mt_ter_ptkp::withTrashed()->findOrFail($this->id_header)->update($data_output);
                    } else {
                        $execDB = M_mt_periode::withTrashed()->findOrFail($this->id_header)->update($data_output);
                    }


                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
                    $this->resetValidation();
                }
            } catch (\Exception $th) {
                activity()->log($th->getMessage());
                $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
            }
        }
    }

    public function updatedfilterSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->activeTab !== 'tab1') {
            if ($this->sortField === $field) {
                $this->sortDir = $this->sortDir === 'ASC' ? 'DESC' : 'ASC';
            } else {
                $this->sortDir = 'ASC';
                $this->sortField = $field;
            }
        }
    }

    public function setTab($tab)
    {
        $this->showForm = false;
        $this->showTable = true;
        $this->reset([
            'filterSearch',
            'filterStatus',
            'activeTab',
            'sortField',
            'sortDir',
        ]);
        $this->activeTab = $tab;

        $this->js("changeStyleFilterStatus(" . $this->filterStatus . ", '" . help_get_status_by_id($this->filterStatus)->nama . "'); ");
    }

    public function buttonBack()
    {
        $this->showForm = false;
        $this->showTable = true;
    }


    public function delete($id)
    {
        try {
            if ($this->activeTab === 'tab2') {
                $postDelete = M_mt_ptkp::withTrashed()->findOrFail($id);
                $postDelete->delete();

                $postDelete->f_status = 1;
                $postDelete->update();
            }

            if ($this->activeTab === 'tab3') {
                $postDelete = M_mt_ter_ptkp::withTrashed()->findOrFail($id);
                $postDelete->delete();

                $postDelete->f_status = 1;
                $postDelete->update();
            }


            if ($this->activeTab === 'tab4') {
                $postDelete = M_mt_periode::withTrashed()->findOrFail($id);
                $postDelete->delete();

                $postDelete->f_status = 1;
                $postDelete->update();
            }

            $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
        } catch (\Exception $th) {
            $this->dispatch('sweet-alert', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
        }
    }

    public function export($filetype)
    {
        if ($this->activeTab === 'tab1') {
            $titleExport = 'Master' . ' ' . session('submenu_nama');
            $headStandar = 1; //0 Header Not Standar, 1 Head Standar
            $submenu_id = 'mt_komponen';
        } else if ($this->activeTab === 'tab2') {
            $titleExport = 'Master' . ' ' . ' PTKP';
            $headStandar = 0; //0 Header Not Standar, 1 Head Standar
            $submenu_id = 'mt_ptkp';
        } else if ($this->activeTab === 'tab3') {
            $titleExport = 'Master' . ' ' . ' Ter PTKP';
            $headStandar = 0; //0 Header Not Standar, 1 Head Standar
            $submenu_id = 'mt_ter_ptkp';
        } else {
            $titleExport = 'Master' . ' ' . ' Periode';
            $headStandar = 0; //0 Header Not Standar, 1 Head Standar
            $submenu_id = 'mt_periode';
        }

        $papersize = 3;
        $orientation = "potrait";

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

    // public function click_komponen()
    // {
    //     $this->show_table_ptkp = false;
    //     $this->show_table_komponen = true;
    //     $this->show_table_ter_ptkp = false;
    //     $this->show_table_periode = false;
    // }

    // public function click_ptkp()
    // {
    //     $this->show_table_ptkp = true;
    //     $this->show_table_komponen = false;
    //     $this->show_table_ter_ptkp = false;
    //     $this->show_table_periode = false;
    // }

    // public function click_ter_ptkp()
    // {
    //     $this->show_table_ptkp = false;
    //     $this->show_table_komponen = false;
    //     $this->show_table_ter_ptkp = true;
    //     $this->show_table_periode = false;
    // }

    // public function click_periode()
    // {
    //     $this->show_table_ptkp = false;
    //     $this->show_table_komponen = false;
    //     $this->show_table_ter_ptkp = false;
    //     $this->show_table_periode = true;
    // }


    // public $id_header, $tot_hari_kerja, $d_Pph21, $d_PK_BPJS_TK, $d_PK_BPJS_KES, $d_PK_BPJS_JHT, $d_BP_BPJS_TK, $d_BP_BPJS_KES, $d_BP_BPJS_JHT, $d_BJ,
    //     $d_Bruto_JKM, $d_Bruto_KES;

    // public $valid_role, $valid_mesage;

    // public function mount()
    // {
    //     help_update_sess_submenu(17);
    // }

    // public function save()
    // {

    //     // ==================================== VALID INPUT =======================================
    //     $this->valid_role = [
    //         'tot_hari_kerja' => 'required',
    //         'd_Pph21' => 'required',
    //         'd_PK_BPJS_TK' => 'required',
    //         'd_PK_BPJS_KES' => 'required',
    //         'd_PK_BPJS_JHT' => 'required',
    //         'd_BP_BPJS_TK' => 'required',
    //         'd_BP_BPJS_KES' => 'required',
    //         'd_BP_BPJS_JHT' => 'required',
    //         'd_BJ' => 'required',
    //         'd_Bruto_JKM' => 'required',
    //         'd_Bruto_KES' => 'required',
    //     ];

    //     $this->valid_mesage = [
    //         'required' => 'Harus di isi',
    //     ];

    //     $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);

    //     // ==================================== VALID INPUT =======================================
    //     if ($validator->errors()->count() > 0) {
    //         $this->setErrorBag($validator->errors());
    //         $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
    //         return;
    //     } else {
    //         try {
    //             $data_store = [
    //                 'tot_hari_kerja' => $this->tot_hari_kerja,
    //                 'd_Pph21' => $this->d_Pph21,
    //                 'd_PK_BPJS_TK' => $this->d_PK_BPJS_TK,
    //                 'd_PK_BPJS_KES' => $this->d_PK_BPJS_KES,
    //                 'd_PK_BPJS_JHT' => $this->d_PK_BPJS_JHT,
    //                 'd_BP_BPJS_TK' => $this->d_BP_BPJS_TK,
    //                 'd_BP_BPJS_KES' => $this->d_BP_BPJS_KES,
    //                 'd_BP_BPJS_JHT' => $this->d_BP_BPJS_JHT,
    //                 'd_BJ' => $this->d_BJ,
    //                 'd_Bruto_JKM' => $this->d_Bruto_JKM,
    //                 'd_Bruto_KES' => $this->d_Bruto_KES,
    //             ];

    //             if ($this->id_header == "") {
    //                 $data_store_add = [
    //                     'create' => session('user_id'),
    //                 ];
    //                 $data_output = array_merge($data_store, $data_store_add);

    //                 $execDB = M_mt_pay_setting::create($data_output);

    //                 $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
    //                 $this->store($execDB->id);
    //             } else {
    //                 $data_store_add = [
    //                     'update' => session('user_id'),
    //                 ];
    //                 $data_output = array_merge($data_store, $data_store_add);

    //                 $execDB = M_mt_pay_setting::withTrashed()->findOrFail($this->id_header)->update($data_output);

    //                 $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
    //                 $this->resetValidation();
    //             }
    //         } catch (\Exception $th) {
    //             activity()->log($th->getMessage());
    //             $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
    //         }
    //     }
    // }

    // public function delete($id)
    // {
    //     try {
    //         $postDelete = M_mt_karyawan::withTrashed()->findOrFail($id);
    //         $postDelete->delete();

    //         $postDelete->f_status = 1;
    //         $postDelete->update();

    //         $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Hapus', text: '');
    //     } catch (\Exception $th) {
    //         $this->dispatch('sweet-alert', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
    //     }
    // }
};
