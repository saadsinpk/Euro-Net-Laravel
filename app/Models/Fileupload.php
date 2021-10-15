<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileupload extends Model
{
    use HasFactory;

    
    protected $table = "fileupload";

    protected $fillable = [
        'file_name',
        'updated_at',
        'created_at',
    ];

}