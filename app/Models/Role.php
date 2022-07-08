<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasPermissions;

class Role extends SpatieRole implements Auditable
{
    use HasFactory, HasPermissions;
    use \OwenIt\Auditing\Auditable;
    protected $table = "roles";
    public $autoincrement = true;
    protected $guarded=['*'];
    protected $fillable = [
        'name',
        'guard_name',
        'unsign_text',
    ];

    private static $searchable = [
        'name',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $arrSearchAble  = self::getSearchTextFiels();
            if ($arrSearchAble) {
                $unsign_text = '';
                $separate = '';
                foreach ($arrSearchAble as $keyColumn) {
                    $unsign_text =  $unsign_text . $separate . removeStringUtf8($model->$keyColumn);
                }
                $model->unsign_text = strtolower($unsign_text);
            }
        });
        self::updating(function ($model) {
            $arrSearchAble  = self::getSearchTextFiels();
            if ($arrSearchAble) {
                $unsign_text = '';
                $separate = '';
                foreach ($arrSearchAble as $keyColumn) {
                    $unsign_text =  $unsign_text . $separate . removeStringUtf8($model->$keyColumn);
                }
                $model->unsign_text = strtolower($unsign_text);
            }
        });
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getSearchTextFiels()
    {
        if (method_exists(static::class, 'getListSearchAble')) {
            return static::getListSearchAble();
        }
        return false;
    }
}
