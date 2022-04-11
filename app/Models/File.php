<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'files';
    protected $fillable=['url','file_name','model_name','size_file','model_id','type', 'admin_id','note','file_name_en','note_en'];
}
