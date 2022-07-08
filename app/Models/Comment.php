<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends BaseModel implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['comment', 'post_id', 'parent_id', 'user_id', 'path', 'unsign_text'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts() {
        return $this->belongsTo(Post::class);
    }

    public function reply(){
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'comment_like', 'comment_id', 'user_id');
    }

    private static $searchable = [
        'comment',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
