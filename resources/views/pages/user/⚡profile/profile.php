<?php

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Pest\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

new class extends Component {
    use WithFileUploads;


    public $id, $name, $email, $image, $imageNew, $password, $password_current, $password_confirmation;

    // untuk update tab
    public $activeTab;

    public $valid_role = [
        'email' => 'required|email|max:250',
        'name' => 'required|max:250',
    ];

    public $valid_mesage = [
        'required' => 'Harus di isi',
        'email' => 'Masukkan email sesuai format',
        'max' => 'Maksimum karakter :max',
    ];

    public $valid_image = [
        'image' => 'image|mimes:jpeg,jpg,png|max:5120',
    ];

    public $valid_message_image = [
        'image' => 'File harus berupa gambar jpg|jpeg|png',
        'mimes' => 'File harus berupa gambar jpg|jpeg|png',
        'max' => 'Maksimum upload 5MB',
    ];


    public $valid_password = [
        'password_current' => 'required|current_password|min:6',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required',
    ];

    public $valid_message_password = [
        'required' => 'Harus di isi',
        'min' => 'Minimal karakter :min',
        'confirmed' => 'Password tidak sama',
        'current_password' => 'Password lama tidak sesuai',

    ];

    public function mount()
    {

        help_update_sess_submenu(1);

        $this->id = help_data_auth_user()->id;
        $this->name = help_data_auth_user()->name;
        $this->email = help_data_auth_user()->email;
        $this->activeTab = 'tab1';
    }



    public function updatedImage()
    {
        $this->resetValidation();
        $validator = Validator::make($this->all(), $this->valid_image, $this->valid_message_image);

        if ($validator->errors()->count() > 0) {
            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');


            $this->reset([
                'image',
            ]);

            return;
        }
    }


    public function update()
    {

        $this->resetValidation();

        $validate =  Validator::make($this->all(), $this->valid_role, $this->valid_mesage);


        if ($validate->errors()->count() > 0) {
            $this->setErrorBag($validate->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
            return;
        } else {

            $data_store = [
                'name' => $this->name,
                'update' => session('user_id'),
            ];

            User::findOrFail($this->id)->update($data_store);

            if ($this->image != '') {

                $validateImage = Validator::make($this->all(), $this->valid_image, $this->valid_message_image);

                if ($validateImage->errors()->count() > 0) {
                    $this->setErrorBag($validateImage->errors());
                    $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
                    return;
                } else {
                    $this->uploadPhoto();


                    $this->dispatch('sweet-alert', icon: 'success', title: 'Update Data dan Upload Gambar Berhasil', text: '');
                }
            } else {
                $this->dispatch('sweet-alert', icon: 'success', title: 'Update Data Berhasil', text: '');
            }

            $this->dispatch('dp-update-user-name');
        }
    }


    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }


    public function uploadPhoto()
    {
        if ($this->image) {
            $filePath = 'assets/images/user/profile/';
            $imageName = session('user_id') . '_' . Str::random(5) . '.' . $this->image->extension();
            Image::decode($this->image)->resize(300, 300)->save(storage_path('app/public/' . $filePath .  $imageName));

            $sfileOld = help_data_auth_user()->image;

            if ($sfileOld != "" && $sfileOld != ENV('DEFAULT_IMG_USER')) {
                if (Storage::disk('public')->exists($sfileOld)) {
                    Storage::disk('public')->delete($sfileOld);
                }
            }

            $model_data =  User::find(help_data_auth_user()->id);
            $updateData = [
                'image' => $filePath .   $imageName,
            ];
            $model_data->update($updateData);
            $this->reset('image');
        }
    }

    public function resetImage()
    {
        $this->reset('image');
    }



    public function updatePassword()
    {
        try {
            $this->validate($this->valid_password, $this->valid_message_password);
            try {
                $model_data =  User::find(help_data_auth_user()->id);
                $updateData = [
                    'password' => Hash::make($this->password),
                ];
                $model_data->update($updateData);

                $this->reset('password_current', 'password', 'password_confirmation');

                $this->dispatch('sweet-alert', icon: 'success', title: 'Update Password Berhasil', text: '');
            } catch (\Exception $th) {
                activity()->log($th->getMessage());
                $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
            }
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Update Gagal', text: 'Periksa kembali input data anda!');
        }
    }
};
