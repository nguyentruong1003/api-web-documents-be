<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";
    public $autoincrement = true;
    protected $guarded=['*'];
    protected $fillable = [
        'code',
        'name',
        'guard_name',
        'note',
        'status',
    ];

    public function users() {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles');
    }
}
