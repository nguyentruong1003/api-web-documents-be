<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['comment', 'post_id', 'parend_id', 'user_id'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts() {
        return $this->belongsTo(Post::class);
    }

    public function reply(){
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
