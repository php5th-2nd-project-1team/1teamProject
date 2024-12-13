<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComments extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_comment_id';

    protected $fillable = [
        'post_id',
        'user_id',
        'post_comment',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
