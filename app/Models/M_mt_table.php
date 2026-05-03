<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class M_mt_table extends Model
{
    use HasFactory;

    protected $table = 'mt_table';

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'nama',
        'set_table',
        'i_standar',
        'f_submenu',
        'f_status',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public static function detail($id = null, $onlyquery = null, $filterSearch = null)
    {
        $sess_frole = session('user_frole');

        $query = "SELECT X.* FROM (SELECT A.*, B.nama as status, C.url, CASE WHEN A.f_submenu IS NULL THEN A.nama ELSE C.nama END as submenu
                FROM mt_table A
                INNER JOIN mt_status B ON B.id = A.f_status
                LEFT JOIN users_submenu C ON C.id = A.f_submenu
                WHERE A.f_status = 2 ) X
                ";

        if ($sess_frole != 1) {
            $query .= " INNER JOIN users_access_menu Y ON Y.f_submenu = X.f_submenu AND Y.f_role = '$sess_frole' ";
            $query .= " AND Y.ishow = 1 ";
        } else {
            $query .= " WHERE 1 = 1 ";
        }

        if ($id) {
            $query .= " AND X.id = $id ";
        }

        if ($filterSearch) {
            $query .= " AND ( ";
            $query .= " X.submenu like '%" . $filterSearch . "%' ";
            $query .= " ) ";
        }


        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY X.submenu ";
            $result = DB::select($query);

            return $result[0];
        }
    }
}
