<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Validator;

class Login extends Component
{
    #[Title('Login')]
    #[Layout('layouts.guest')]


    public $email = '';
    public $password = '';

    public $valid_role = [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ];

    public $valid_mesage = [
        'required' => 'Harus di isi',
        'email' => 'Masukkan email sesuai format',
        'min' => 'Minimal :min karakter',
    ];

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function authenticate(Request $request)
    {
        // =========================== VALIDATION RULES ====================================
        $this->resetValidation();

        $validator = Validator::make($this->all(), $this->valid_role, $this->valid_mesage);


        if ($this->email != "") {
            $user_data = help_user_auth($this->email);

            if ($user_data != "") {
                if ($user_data->f_status == '1') {
                    $validator->errors()->add('email', 'User Tidak Aktif');
                }
                if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
                    session([
                        'user_id' => $user_data->id,
                        'user_name' => $user_data->name,
                        'user_email' => $user_data->email,
                        'user_frole' => $user_data->f_role,
                        'user_forg' => $user_data->f_org,
                        'user_org' => $user_data->org,
                        'user_image' => $user_data->image,
                    ]);

                    $dataflash = [
                        'pesan' => 'Selamat datang ' . $user_data->name,
                        'flashtype' => 'success',
                    ];

                    session()->flash('dataflash', $dataflash);
                    activity()->log('User Login');

                    if ($user_data->f_role == '1') {
                        return redirect('adm_dashboard');
                    } else {
                        return redirect('usr_profile');
                    }
                } else {
                    $validator->errors()->add('email', 'Email atau Password Anda salah');
                }
            } else {
                $validator->errors()->add('email', 'Email tidak terdaftar');
            }
        }

        if ($validator->errors()->count() > 0) {
            $this->setErrorBag($validator->errors());
            $this->dispatch('sweet-alert', icon: 'warning', title: 'Login Gagal', text: 'Periksa kembali input data anda!');
            return;
        }


        // =========================== VALIDATION END ====================================
    }

    public function logout()
    {
        activity()->log('User Logout');
        Auth::logout();
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $dataflash = [
            'pesan' => 'User Logout',
            'flashtype' => 'success',
        ];

        session()->flash('dataflash', $dataflash);

        return redirect('/');
    }
}
