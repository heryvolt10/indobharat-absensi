<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;


class M_users_access_menu extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'users_access_menu';

    protected $fillable = [
        'uuid',
        'f_role',
        'f_submenu',
        'ishow',
        'iadd',
        'isave',
        'iedit',
        'idelete',
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


    public static function detail($submenuid = null)
    {

        $sess_role = session('user_frole');
        $sess_org = session('user_forg');

        if ($sess_role == "1") {
            $query = "SELECT A.*, B.id as f_menu, B.nama as menu, B.seq as menu_seq, B.icon as menu_icon, 1 as ishow, 1 as isave, 1 as iadd, 1 as iedit, 1 as idelete
                FROM users_submenu A
                INNER JOIN users_menu B ON B.id = A.f_menu WHERE A.f_status = 2";

            $query .= " ORDER BY B.seq, A.seq ";

            if ($submenuid) {
                $query .= " LIMIT 1 ";
            }
        } else {
            $query = "SELECT B.*, C.id as f_menu, C.nama as menu, C.seq as menu_seq, C.icon as menu_icon, A.ishow, A.isave, A.iadd, A.iedit, A.idelete
                FROM users_access_menu A
                INNER JOIN users_submenu B ON B.id = A.submenu_id
                INNER JOIN users_menu C ON C.id = B.f_menu
                INNER JOIN users_role D ON D.id = A.f_role
                WHERE B.f_org = $sess_org AND B.f_status = 2 AND D.f_status = 2 AND A.ishow = 1 
                AND A.f_role = $sess_role 
                ";

            if ($submenuid) {
                $query .= " AND B.id = $submenuid ";
            }

            $query .= " ORDER BY C.seq, B.seq ";

            if ($submenuid) {
                $query .= " LIMIT 1 ";
            }
        }

        $result = DB::select($query);

        if ($submenuid) {
            return $result[0];
        } else {
            return $result;
        }
    }


    public static function pending_access_menu()
    {
        $query = "SELECT A.id as f_role, B.f_submenu, 
        CASE WHEN A.id = 1 THEN 1 ELSE 0  END as ishow,
        CASE WHEN A.id = 1 THEN 1 ELSE 0  END as isave,
        CASE WHEN A.id = 1 THEN 1 ELSE 0  END as iadd,
        CASE WHEN A.id = 1 THEN 1 ELSE 0  END as iedit,
        CASE WHEN A.id = 1 THEN 1 ELSE 0  END as idelete,
        NULL, NULL, 
        '2020-01-01' as create_at,
        NULL as update_at,
        NULL as delete_at
        FROM users_role A
        INNER JOIN (
            SELECT X.id as f_submenu, X.f_menu FROM (
                SELECT A.* FROM users_submenu A
                INNER JOIN users_menu B ON B.id = A.f_menu
                WHERE A.f_status <> 1 AND B.f_status <> 1
            ) X
        ) B ON 1 = 1
        LEFT JOIN users_access_menu C ON C.f_role = A.id AND C.f_submenu = B.f_submenu
        WHERE A.f_status <> 1 AND C.id IS NULL
        ";

        $result = DB::select($query);

        return $result;
    }
}
