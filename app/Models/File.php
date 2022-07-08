<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'files';
    protected $fillable=['url', 'file_name', 'model_type', 'size_file', 'model_id', 'admin_id'];

    private static $searchable = [
        'file_name'
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
