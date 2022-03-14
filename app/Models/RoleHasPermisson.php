<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermisson extends Model
{
    use HasFactory;
    protected $table = "role_has_permissions";
    protected $guarded=['*'];
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
