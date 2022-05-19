<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PostReport extends UnsignTextSearchModel implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'post_report';

    protected $fillable = [
        'description', 'post_id', 'user_id', 'resolve', 'unsign_text'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    private static $searchable = [
        'description',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
