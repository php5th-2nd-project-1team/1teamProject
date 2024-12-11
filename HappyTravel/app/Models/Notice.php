<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory ,SoftDeletes;

    protected $primaryKey = 'notice_id';

    protected $fillable = [
        'manager_id',       
        'notice_title',
        'notice_content',
        'notice_img',
    ];
    
}
