<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class M_mt_pay_setting extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'mt_pay_setting';

    protected $fillable = [
        'tot_hari_kerja',
        'd_Pph21',
        'd_PK_BPJS_TK',
        'd_PK_BPJS_KES',
        'd_PK_BPJS_JHT',
        'd_BP_BPJS_TK',
        'd_BP_BPJS_KES',
        'd_BP_BPJS_JHT',
        'd_BJ',
        'd_Bruto_JKM',
        'd_Bruto_KES',
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

    public static function detail($id = null, $onlyquery = null)
    {

        $query = "SELECT A.*
                FROM mt_pay_setting A
                WHERE 1 = 1
                ";

        if ($id) {
            $query .= " AND A.id = $id ";
        }

        if ($onlyquery) {
            return $query;
        } else {
            $result = DB::select($query);

            return $result[0];
        }
    }
}
