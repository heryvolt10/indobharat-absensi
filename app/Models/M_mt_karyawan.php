<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_mt_karyawan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mt_karyawan';

    protected $fillable = [
        'uuid',
        'nama',
        'NIK',
        'password',
        'no_npwp',
        'no_bpjs',
        'nama_bank',
        'no_rek',
        'nama_rek',
        'alamat',
        'tgl_bekerja',
        'f_warga_negara',
        'f_divisi',
        'f_jabatan',
        'f_grade',
        'f_role',
        'f_gender',
        'f_agama',
        'f_ptkp',
        'tunjangan',
        'f_status',
        'f_org',
        'create',
        'update',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public static function detail($id = null, $onlyquery = null, $filterSearch = null, $filterStatus = null, $formodallist = null)
    {

        $query = "SELECT A.*, B.nama as status, C.nama as org, D.nama as role, E.nama as divisi, F.nama as jabatan, G.nama as grade, H.nama as gender, 
                I.nama as agama, J.nama as ptkp, J.nilai as ptkp_nilai, K.nama as warga_negara
                FROM mt_karyawan A
                LEFT JOIN mt_status B ON B.id = A.f_status
                LEFT JOIN mt_org C ON C.id = A.f_org
                LEFT JOIN users_role D ON D.id = A.f_role
                LEFT JOIN mt_divisi E ON E.id = A.f_divisi
                LEFT JOIN mt_jabatan F ON F.id = A.f_jabatan
                LEFT JOIN mt_grade G ON G.id = A.f_grade
                LEFT JOIN mt_gender H ON H.id = A.f_gender
                LEFT JOIN mt_agama I ON I.id = A.f_agama
                LEFT JOIN mt_ptkp J ON J.id = A.f_ptkp
                LEFT JOIN mt_warga_negara K ON K.id = A.f_warga_negara
                WHERE 1 = 1
                ";

        if ($id) {
            $query .= " AND A.id = $id ";
        }


        if ($filterStatus) {
            $query .= " AND A.f_status = $filterStatus ";
        }

        if ($filterSearch) {
            if ($formodallist == 1) {
                $query .= " AND ( ";
                $query .= " A.name like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            } else {
                $query .= " AND ( ";
                $query .= " A.nama like '%" . $filterSearch . "%' OR ";
                $query .= " A.NIK like '%" . $filterSearch . "%' OR ";
                $query .= " A.no_npwp like '%" . $filterSearch . "%' OR ";
                $query .= " A.no_bpjs like '%" . $filterSearch . "%' OR ";
                $query .= " A.nama_bank like '%" . $filterSearch . "%' OR ";
                $query .= " A.no_rek like '%" . $filterSearch . "%' OR ";
                $query .= " A.nama_rek like '%" . $filterSearch . "%' OR ";
                $query .= " A.tgl_bekerja like '%" . $filterSearch . "%' OR ";
                $query .= " D.nama like '%" . $filterSearch . "%' OR ";
                $query .= " E.nama like '%" . $filterSearch . "%' OR ";
                $query .= " F.nama like '%" . $filterSearch . "%' OR ";
                $query .= " G.nama like '%" . $filterSearch . "%' OR ";
                $query .= " H.nama like '%" . $filterSearch . "%' OR ";
                $query .= " I.nama like '%" . $filterSearch . "%' OR ";
                $query .= " J.nama like '%" . $filterSearch . "%' OR ";
                $query .= " K.nama like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.nama ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
