<?php

use Livewire\Component;

use App\Models\M_mt_pay_setting;
use Illuminate\Support\Facades\Validator;

new class extends Component
{

    public $id_header, $tot_hari_kerja, $d_Pph21, $d_PK_BPJS_TK, $d_PK_BPJS_KES, $d_PK_BPJS_JHT, $d_BP_BPJS_TK, $d_BP_BPJS_KES, $d_BP_BPJS_JHT, $d_BJ,
        $d_Bruto_JKM, $d_Bruto_KES;

    public $valid_role, $valid_mesage;

    public function mount()
    {
        help_update_sess_submenu(17);
    }

    public function save()
    {

        // ==================================== VALID INPUT =======================================
        $this->valid_role = [
            'tot_hari_kerja' => 'required',
            'd_Pph21' => 'required',
            'd_PK_BPJS_TK' => 'required',
            'd_PK_BPJS_KES' => 'required',
            'd_PK_BPJS_JHT' => 'required',
            'd_BP_BPJS_TK' => 'required',
            'd_BP_BPJS_KES' => 'required',
            'd_BP_BPJS_JHT' => 'required',
            'd_BJ' => 'required',
            'd_Bruto_JKM' => 'required',
            'd_Bruto_KES' => 'required',
        ];

        $this->valid_mesage = [
            'required' => 'Harus di isi',
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
                    'tot_hari_kerja' => $this->tot_hari_kerja,
                    'd_Pph21' => $this->d_Pph21,
                    'd_PK_BPJS_TK' => $this->d_PK_BPJS_TK,
                    'd_PK_BPJS_KES' => $this->d_PK_BPJS_KES,
                    'd_PK_BPJS_JHT' => $this->d_PK_BPJS_JHT,
                    'd_BP_BPJS_TK' => $this->d_BP_BPJS_TK,
                    'd_BP_BPJS_KES' => $this->d_BP_BPJS_KES,
                    'd_BP_BPJS_JHT' => $this->d_BP_BPJS_JHT,
                    'd_BJ' => $this->d_BJ,
                    'd_Bruto_JKM' => $this->d_Bruto_JKM,
                    'd_Bruto_KES' => $this->d_Bruto_KES,
                ];

                if ($this->id_header == "") {
                    $data_store_add = [
                        'create' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_pay_setting::create($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Simpan', text: '');
                    $this->store($execDB->id);
                } else {
                    $data_store_add = [
                        'update' => session('user_id'),
                    ];
                    $data_output = array_merge($data_store, $data_store_add);

                    $execDB = M_mt_pay_setting::withTrashed()->findOrFail($this->id_header)->update($data_output);

                    $this->dispatch('sweet-alert', icon: 'success', title: 'Data Berhasil Di Update', text: '');
                    $this->resetValidation();
                }
            } catch (\Exception $th) {
                activity()->log($th->getMessage());
                $this->dispatch('sweet-alert-notime', icon: 'error', title: 'Terjadi kesalahan sistem!', text: $th->getMessage());
            }
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
};
