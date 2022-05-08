<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Post extends UnsignTextSearchModel implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'post_type_id',
        'user_id',
        'status',
        'unsign_text',
    ];

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id');
    }

    public function types() {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }

    public function files() {
        return $this->hasMany(File::class, 'model_id', 'id')->where('model_name', Post::class);
    }

    public function reports() {
        return $this->hasMany(PostReport::class);
    }

    private static $searchable = [
        'title',
    ];

    public static function getListSearchAble()
    {
        return self::$searchable;
    }
}
