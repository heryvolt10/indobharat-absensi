<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_users_role extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'users_role';

    protected $fillable = [
        'uuid',
        'nama',
        'ket',
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
                FROM users_role A
                INNER JOIN mt_status B ON B.id = A.f_status
                INNER JOIN mt_org C ON C.id = A.f_org
                WHERE 1 = 1
                ";

        if (session('user_frole') != "1") {
            $query .= " AND A.id <> 1 ";
            $query .= " AND A.f_org = " . session('user_forg');
        }


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
                $query .= " A.ket like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.f_org, A.nama ";
            $result = DB::select($query);
            return $result[0];
        }
    }


    // public static function insert_access_menu()
    // {
    //     $query = "INSERT INTO users_access_menu
    //     SELECT LAST_INSERT_ID(), '" . Str::uuid() . "', A.id as f_role, B.f_submenu, 
    //     CASE WHEN A.id = 1 THEN 1 ELSE 0  END as ishow,
    //     CASE WHEN A.id = 1 THEN 1 ELSE 0  END as isave,
    //     CASE WHEN A.id = 1 THEN 1 ELSE 0  END as iadd,
    //     CASE WHEN A.id = 1 THEN 1 ELSE 0  END as iedit,
    //     CASE WHEN A.id = 1 THEN 1 ELSE 0  END as idelete,
    //     NULL, NULL, 
    //     '2020-01-01' as create_at,
    //     NULL as update_at,
    //     NULL as delete_at
    //     FROM users_role A
    //     INNER JOIN (
    //         SELECT X.id as f_submenu, X.f_menu FROM (
    //             SELECT A.* FROM users_submenu A
    //             INNER JOIN users_menu B ON B.id = A.f_menu
    //             WHERE A.f_status <> 1 AND B.f_status <> 1
    //         ) X
    //     ) B ON 1 = 1
    //     LEFT JOIN users_access_menu C ON C.f_role = A.id AND C.f_submenu = B.f_submenu
    //     WHERE A.f_status <> 1 AND C.id IS NULL
    //     ";

    //     DB::select($query);
    // }
}
