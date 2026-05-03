<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;


class M_setting_app extends Model
{
    use HasFactory, LogsActivity;
    public $timestamps = false;

    protected $table = 'setting_app';
    protected $fillable = [
        'name',
        'value',
        'label',
        'type',
        'for_setting',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public static function detail($id = null, $onlyquery = null)
    {
        $query = "SELECT A.* FROM setting_app A
                WHERE 1 = 1
                ";

        if ($id) {
            $query .= " AND A.id = $id ";
        }

        if ($onlyquery) {
            return $query;
        } else {
            $query .= " ORDER BY A.id ";
            $result = DB::select($query);

            return $result;
        }
    }
}
