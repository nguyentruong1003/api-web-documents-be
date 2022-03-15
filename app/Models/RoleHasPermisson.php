<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RoleHasPermisson extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = "role_has_permissions";
    protected $guarded=['*'];
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
