<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_mt_pay_component extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mt_pay_component';

    protected $fillable = [
        'uuid',
        'kode',
        'pay_tipe',
        'pay_grup',
        'pay_set',
        'pay_tax',
        'nilai',
        'ket_rumusan',
        'ket',
        'ket2',
        'ket3',
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

        $query = "SELECT A.*, A.nilai as nama, B.nama as status, C.nama as org
                FROM mt_pay_component A
                INNER JOIN mt_status B ON B.id = A.f_status
                INNER JOIN mt_org C ON C.id = A.f_org
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
                $query .= " A.kode like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            } else {
                $query .= " AND ( ";
                $query .= " A.kode like '%" . $filterSearch . "%' OR ";
                $query .= " A.pay_tipe like '%" . $filterSearch . "%' OR ";
                $query .= " A.pay_grup like '%" . $filterSearch . "%' OR ";
                $query .= " A.pay_set like '%" . $filterSearch . "%' OR ";
                $query .= " A.pay_tax like '%" . $filterSearch . "%' OR ";
                $query .= " A.nilai like '%" . $filterSearch . "%' OR ";
                $query .= " A.ket_rumusan like '%" . $filterSearch . "%' OR ";
                $query .= " A.ket like '%" . $filterSearch . "%' OR ";
                $query .= " A.ket2 like '%" . $filterSearch . "%' OR ";
                $query .= " A.ket3 like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.kode ASC ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
