<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Post extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'post_like', 'post_id', 'user_id');
    }

    public function types() {
        return $this->belongsTo(PostType::class);
    }
}
