<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityComment extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $primaryKey = 'community_comment_id';

    protected $fillable = [
        'community_id'
        ,'user_id'
        ,'comment_content'
    ];

    protected function serializeDate(\DateTimeInterface $date) {
        $today = Carbon::instance($date)->isToday();
        if($today) {
            return $date->format('H:i:s');
        }else {
            // 댓글 기능은 일자를 날짜만 둠 (시간x)
            return $date->format('Y-m-d');
        }
    }

    public function community_board(){
        return $this->belongsTo(CommunityBoard::class, 'community_id')->select('community_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id')->select('user_id', 'nickname', 'profile')->withTrashed();
    }
    
}
