<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_users extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'f_role',
        'image',
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
        $query = "SELECT A.*, A.name as nama, B.nama as status, C.nama as org, D.nama as role
                FROM users A
                INNER JOIN mt_status B ON B.id = A.f_status
                INNER JOIN mt_org C ON C.id = A.f_org
                INNER JOIN users_role D ON D.id = A.f_role
                WHERE 1 = 1 
                ";

        if (session('user_frole') != "1") {
            $query .= " AND A.id <> 1 ";
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
                $query .= " A.name like '%" . $filterSearch . "%' OR ";
                $query .= " A.email like '%" . $filterSearch . "%' OR ";
                $query .= " D.nama  like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.name ";
            $result = DB::select($query);

            return $result[0];
        }
    }

    public static function table_list()
    {
        $columns = [
            ['data' => 'id', 'title' => 'id',  'class' => 'id col-hide', 'width' => '', 'sort' => ''],
            ['data' => '', 'title' => 'No',  'class' => '', 'width' => '1%', 'sort' => ''],
            ['data' => 'nama', 'title' => 'Nama',  'class' => 'nama', 'width' => '', 'sort' => '1'],
            ['data' => 'role', 'title' => 'Role',  'class' => 'role', 'width' => '', 'sort' => '1'],
            ['data' => 'email', 'title' => 'Email',  'class' => 'email', 'width' => '', 'sort' => '1'],
            ['data' => 'org', 'title' => 'Org',  'class' => 'org', 'width' => '', 'sort' => '1'],
            ['data' => 'status', 'title' => 'Status',  'class' => 'status', 'width' => '', 'sort' => '1'],
            ['data' => 'id', 'title' => '#',  'class' => 'last-col sticky-col', 'width' => '5%', 'sort' => ''],
        ];

        return json_decode(json_encode($columns));
    }
}
