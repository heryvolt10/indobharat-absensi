<?php

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;

new class extends Component
{
    use WithFileUploads, WithPagination, WithoutUrlPagination;

    public $m_index;

    public $id_header;

    public $app_name, $app_org, $app_website, $app_year, $app_address_org, $app_logo, $app_logo_upload, $app_logo_dark, $app_logo_dark_upload;
    public $vwimage_app_logo;

    public $dbfile;


    public $filterSearch = '', $filterStatus = '2', $listCount = '0';
    public $sortField = '', $sortDir = '';

    public $valid_role, $valid_mesage;

    public $showForm = false, $showTable = true;
    public $activeTab = 'tab1';


    public function mount()
    {
        help_update_sess_submenu(6);
    }

    public function render()
    {

        $perPage = 10; // Number of items per page
        $currentPage = Paginator::resolveCurrentPage();
        $data_rows = "";
        if ($this->activeTab === 'tab1') {

            $this->m_index = new \App\Models\M_setting_app;
            $data_row = $this->m_index::all()->toArray();
            $this->app_name = $data_row[0]['value'];
            $this->app_logo = $data_row[1]['value'];
            $this->app_logo_dark = $data_row[2]['value'];
            $this->app_website = $data_row[3]['value'];
            $this->app_year = $data_row[4]['value'];
            $this->app_org = $data_row[5]['value'];
            $this->vwimage_app_logo = $data_row[1]['value'];
        } else if ($this->activeTab === 'tab2') {
            $allFiles = Storage::files('BackupDB');
            $filesWithTime = array_map(function ($file) {
                return [
                    'path' => $file,
                    'timestamp' => date('Y-m-d H:i:s', Storage::lastModified($file))
                ];
            }, $allFiles);

            usort($filesWithTime, function ($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });


            $currentItems = array_slice($filesWithTime, ($currentPage - 1) * $perPage, $perPage);


            $paginatedFiles = new LengthAwarePaginator(
                $currentItems,
                count($filesWithTime),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );

            $data_rows = $paginatedFiles;
        }

        return $this->view([
            'tb_list_status' => help_get_status(1),
            'accessSubMenu' => help_user_access_submenu(session('submenu_id')),
            'data_rows' => $data_rows,

        ])->title(session('menu_nama') . '-' . session('submenu_nama'));
    }

    // public function store($id = "")
    // {
    //     $this->resetValidation();
    //     $this->resetExcept([
    //         'filterSearch',
    //         'filterStatus',
    //         'activeTab',
    //     ]);

    //     $this->id_header = $id;

    //     if ($this->id_header !== "") {

    //         if ($this->activeTab === 'tab1') {
    //             $this->m_index = new \App\Models\M_setting_app;
    //             $data_row = $this->m_index::all()->toArray();
    //             $this->app_name = $data_row[0]['value'];
    //             $this->app_logo = $data_row[1]['value'];
    //             $this->app_logo_dark = $data_row[2]['value'];
    //             $this->app_website = $data_row[3]['value'];
    //             $this->app_year = $data_row[4]['value'];
    //             $this->app_org = $data_row[5]['value'];
    //             $this->vwimage_app_logo = $data_row[1]['value'];
    //         } else if ($this->activeTab === 'tab2') {
    //         }
    //     }

    //     $this->showForm = true;
    //     $this->showTable = false;
    // }

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

        // $this->js("changeStyleFilterStatus(" . $this->filterStatus . ", '" . help_get_status_by_id($this->filterStatus)->nama . "'); ");
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




    public function download_db($path)
    {

        try {

            return Storage::download($path);
        } catch (\Exception $th) {
            activity()->log($th->getMessage());
            $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
        }
    }

    public function backup_db()
    {
        try {
            Artisan::call('backup:run --only-db --disable-notifications');
            $this->dispatch('sweet-alert', icon: 'success', title: 'Database berhasil di backup', text: '');
        } catch (\Exception $th) {
            activity()->log($th->getMessage());
            $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
        }
    }


    public function save()
    {

        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'app_name' => 'required|max:250',
            'app_org' => 'required|max:250',
            'app_website' => 'required|max:250',
            'app_year' => 'required|max:250',
            'app_logo_upload' => 'nullable|image|mimes:jpeg,jpg,png',
            'app_logo_dark_upload' => 'nullable|image|mimes:jpeg,jpg,png',
        ];

        $this->valid_mesage = [
            'required' => 'Harus di isi',
            'max' => 'Maksimum karakter :max',
            'image' => 'File harus berupa gambar jpg|jpeg|png',
            'mimes' => 'File harus berupa gambar jpg|jpeg|png',
        ];

        // ==================================== VALID INPUT =======================================

        $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);

        if ($this->app_logo_upload) {
            $imgUpload = $this->app_logo_upload;
            $fileSize = $imgUpload->getSize() / 1024;
            if ($fileSize > 5120) {
                $validator->errors()->add('app_logo_upload', 'Maksimum File 5 MB');
            }
        }

        if ($this->app_logo_dark_upload) {
            $imgUpload = $this->app_logo_dark_upload;
            $fileSize = $imgUpload->getSize() / 1024;
            if ($fileSize > 5120) {
                $validator->errors()->add('app_logo_dark_upload', 'Maksimum File 5 MB');
            }
        }

        // ==================================== VALID INPUT =======================================
        if ($validator->errors()->count() > 0) {
            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
            return;
        } else {

            try {

                $this->m_index::where('name', 'app_name')->update(['value' =>  $this->app_name]);
                $this->m_index::where('name', 'app_org')->update(['value' =>  $this->app_org]);
                $this->m_index::where('name', 'app_website')->update(['value' =>  $this->app_website]);
                $this->m_index::where('name', 'app_year')->update(['value' =>  $this->app_year]);
                $this->m_index::where('name', 'app_address_org')->update(['value' =>  $this->app_address_org]);

                $filePath = 'assets/images/org/setting_app/';
                $imageNameLight = 'favicon-light' . '.png';
                $imageNameDark = 'favicon-dark' . '.png';
                $imageNameIco = 'favicon' . '.ico';
                $imageName1 = 'favicon-16x16' . '.png';
                $imageName2 = 'favicon-32x32' . '.png';
                $imageName3 = 'favicon-180x180' . '.png';
                $imageName4 = 'favicon-192x192' . '.png';


                if ($this->app_logo_upload) {

                    // dd($this->app_logo_upload);

                    $image1 = $this->app_logo_upload;

                    // $img = Image::decode($image1);
                    // Image::decode($this->app_logo_upload)->resize(48, 48)->encode('ico')->save(storage_path('app/public/' . $filePath .  $imageNameIco));


                    if (Storage::disk('public')->exists($filePath . '/' .  $imageNameIco)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageNameIco);

                        Image::decode($this->app_logo_upload)->resize(48, 48)->save(storage_path('app/public/' . $filePath .  $imageNameIco));


                        // $img->resize(48,  48, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageNameIco));
                    }


                    if (Storage::disk('public')->exists($filePath . '/' .  $imageNameLight)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageNameLight);

                        // $img->resize(512,  512, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageNameLight));
                        Image::decode($this->app_logo_upload)->resize(512, 512)->save(storage_path('app/public/' . $filePath .  $imageNameLight));
                    }



                    if (Storage::disk('public')->exists($filePath . '/' .  $imageName1)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageName1);

                        // $img->resize(16,  16, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageName1));

                        Image::decode($this->app_logo_upload)->resize(16, 16)->save(storage_path('app/public/' . $filePath .  $imageName1));
                    }

                    if (Storage::disk('public')->exists($filePath . '/' .  $imageName2)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageName2);

                        // $img->resize(32,  32, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageName2));
                        Image::decode($this->app_logo_upload)->resize(32, 32)->save(storage_path('app/public/' . $filePath .  $imageName2));
                    }

                    if (Storage::disk('public')->exists($filePath . '/' .  $imageName3)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageName3);

                        // $img->resize(180,  180, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageName3));

                        Image::decode($this->app_logo_upload)->resize(180, 180)->save(storage_path('app/public/' . $filePath .  $imageName3));
                    }

                    if (Storage::disk('public')->exists($filePath . '/' .  $imageName4)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageName4);

                        // $img->resize(192,  192, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->toPng()->save(Storage::disk('public')->path($filePath . '/' . $imageName4));
                        Image::decode($this->app_logo_upload)->resize(192, 192)->save(storage_path('app/public/' . $filePath .  $imageName4));
                    }

                    $this->m_index::where('name', 'app_logo')->update(['value' => $filePath . $imageNameLight]);

                    $this->reset([
                        'app_logo_upload',
                    ]);
                }

                if ($this->app_logo_dark_upload) {
                    $image2 = $this->app_logo_dark_upload;

                    // $img = Image::read($image2->path());

                    if (Storage::disk('public')->exists($filePath . '/' .  $imageNameDark)) {
                        Storage::disk('public')->delete($filePath . '/' .  $imageNameDark);

                        // $img->resize(512,  512, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->save(Storage::disk('public')->path($filePath . '/' . $imageNameDark));

                        Image::decode($this->app_logo_dark_upload)->resize(512, 512)->save(storage_path('app/public/' . $filePath .  $imageNameDark));
                    }


                    $this->m_index::where('name', 'app_logo_dark')->update(['value' => $filePath .  $imageNameDark]);

                    $this->reset([
                        'app_logo_dark_upload',
                    ]);
                }

                $this->dispatch('dp-update-logo-sidebar');
                $this->dispatch('dp-update-logo-topbar');

                $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
                $this->resetValidation();
            } catch (\Exception $th) {
                activity()->log($th->getMessage());
                $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
            }
        }
    }
    public function cancel_upload($inputImage)
    {
        $this->reset($inputImage);
        if ($inputImage == 'app_logo') {
            $this->app_logo_upload = "";
        }

        if ($inputImage == 'app_logo_dark') {
            $this->app_logo_dark_upload = "";
        }
    }
};
