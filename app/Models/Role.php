<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends UnsignTextSearchModel implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = "roles";
    public $autoincrement = true;
    protected $guarded=['*'];
    protected $fillable = [
        'code',
        'name',
        'guard_name',
        'note',
        'status',
        'unsign_text',
    ];

    public function users() {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles');
    }

    private static $searchable = [
        'name',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
