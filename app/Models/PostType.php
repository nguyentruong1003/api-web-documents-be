<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PostType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'post_type';

    protected $fillable = [
        'name',
        'parent_id',
        'slug',
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
