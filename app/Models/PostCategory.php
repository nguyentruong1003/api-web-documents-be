<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PostCategory extends BaseModel implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'post_categories';

    protected $fillable = [
        'name',
        'parent_id',
        'path',
        'slug',
        'unsign_text',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function children(){
        return $this->hasMany(PostType::class, 'parent_id', 'id');
    }
    
    public function parent()
    {
        # code...
        return $this->belongsTo(PostType::class, 'parent_id', 'id');
    }
}
