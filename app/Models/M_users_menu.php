<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;


class M_users_menu extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'users_menu';

    protected $fillable = [
        'uuid',
        'nama',
        'ket',
        'icon',
        'seq',
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

        $query = "SELECT A.*, B.nama as status, C.nama as org
                FROM users_menu A
                INNER JOIN mt_status B ON B.id = A.f_status
                INNER JOIN mt_org C ON C.id = A.f_org
                WHERE 1 = 1
                ";

        if ($id) {
            $query .= " AND A.id = $id ";
        }


        if ($filterSearch) {
            if ($formodallist == 1) {
                $query .= " AND ( ";
                $query .= " A.name like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            } else {
                $query .= " AND ( ";
                $query .= " A.nama like '%" . $filterSearch . "%' OR ";
                $query .= " A.ket like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($filterStatus) {
            $query .= " AND A.f_status = $filterStatus ";
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.seq ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
