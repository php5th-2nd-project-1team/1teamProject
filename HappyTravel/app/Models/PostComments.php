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

    protected function serializeDate(\DateTimeInterface $date) {
        // 댓글 기능은 일자를 날짜만 둠 (시간x)
        return $date->format('Y-m-d');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'post_id')->select('post_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->select('user_id', 'nickname', 'profile')->withTrashed();
    }
}
