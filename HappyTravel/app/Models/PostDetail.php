<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_detail_id';

    protected $fillable = [
        'post_id',
        'manager_id',
        'post_detail_num',
        'post_detail_addr',
        'post_detail_time',
        'post_detail_site',
        'post_detail_price',
        'post_detail_parking',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
