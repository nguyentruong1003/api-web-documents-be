<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnsignTextSearchModel extends Model
{
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
