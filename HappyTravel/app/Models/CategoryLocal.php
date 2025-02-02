<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryLocal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_locals';

    protected $primaryKey = 'category_local_id';

    protected $fillable = [
        'category_local_name',
        'category_local_num',
        'category_local_img',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
