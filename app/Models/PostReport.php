<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PostReport extends BaseModel implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'post_reports';

    protected $fillable = [
        'content', 'post_id', 'user_id', 'resolve', 'unsign_text'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    private static $searchable = [
        'content',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
