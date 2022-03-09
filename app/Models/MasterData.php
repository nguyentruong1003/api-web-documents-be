<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MasterData extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'master_data';
    protected $searchable = [
        'v_key' => 'like',
        'type' => 'equal',
        'v_value' => 'like'
    ];

    public $timestamps = false;
    protected $fillable = [
        'v_key',
        'v_value',
        'order_number',
        'type',
        'parent_id',
        'v_content',
        'note',
    ];
}
