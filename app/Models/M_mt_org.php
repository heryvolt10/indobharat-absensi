<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_mt_org extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mt_org';

    protected $fillable = [
        'uuid',
        'nama',
        'alamat',
        'email',
        'no_tlp',
        'kontak_person',
        'image',
        'i_pusat',
        'f_status',
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

        $query = "SELECT X.* FROM (SELECT A.*, B.nama as status, A.id as f_org, A.nama as org, 
                CASE WHEN i_pusat = 1 THEN 'Head Office' ELSE 'Cabang' END as pusat
                FROM mt_org A
                INNER JOIN mt_status B ON B.id = A.f_status
                ) X WHERE 1 = 1 
                ";

        if ($id) {
            $query .= " AND X.id = $id ";
        }

        if ($filterStatus) {
            $query .= " AND X.f_status = $filterStatus ";
        }

        if ($filterSearch) {
            if ($formodallist == 1) {
                $query .= " AND ( ";
                $query .= " X.nama like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            } else {
                $query .= " AND ( ";
                $query .= " X.nama like '%" . $filterSearch . "%' OR ";
                $query .= " X.pusat like '%" . $filterSearch . "%' OR ";
                $query .= " X.alamat like '%" . $filterSearch . "%' OR ";
                $query .= " X.email like '%" . $filterSearch . "%' OR ";
                $query .= " X.no_tlp like '%" . $filterSearch . "%' OR ";
                $query .= " X.pusat like '%" . $filterSearch . "%' OR ";
                $query .= " X.kontak_person like '%" . $filterSearch . "%' ";
                $query .= " ) ";
            }
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY X.i_pusat DESC, X.nama ";
            $result = DB::select($query);
            return $result[0];
        }
    }
}
