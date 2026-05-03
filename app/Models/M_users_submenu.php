<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;


class M_users_submenu extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'users_submenu';

    protected $fillable = [
        'uuid',
        'nama',
        'ket',
        'icon',
        'seq',
        'url',
        'controller',
        'f_menu',
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

        $query = "SELECT A.*, B.nama as status, C.nama as org, D.nama as menu, D.seq as menu_seq
                FROM users_submenu A
                INNER JOIN mt_status B ON B.id = A.f_status
                INNER JOIN mt_org C ON C.id = A.f_org
                INNER JOIN users_menu D ON D.id = A.f_menu
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
                $query .= " A.url like '%" . $filterSearch . "%' OR ";
                $query .= " D.nama like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($filterStatus) {
            $query .= " AND A.f_status = $filterStatus ";
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY D.seq, A.seq ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
