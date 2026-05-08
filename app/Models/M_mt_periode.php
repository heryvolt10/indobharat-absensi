<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_mt_periode extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mt_periode';

    protected $fillable = [
        'uuid',
        'tanggal',
        'tanggal_mulai',
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

        $query = "SELECT A.*, A.tanggal as nama, B.nama as status, C.nama as org
                FROM mt_periode A
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
                $query .= " A.tanggal like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            } else {
                $query .= " AND ( ";
                $query .= " A.tanggal like '%" . $filterSearch . "%' OR ";
                $query .= " A.tanggal_mulai like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.tanggal ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
