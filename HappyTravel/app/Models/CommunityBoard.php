<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityBoard extends Model
{
    
    use HasFactory, SoftDeletes; // 소프트 삭제 적용

    protected $primaryKey = 'community_id'; // 기본키 설정

    protected $fillable = [
        'user_id',
        'community_id',
        'commuinty_type',
        'community_title',
        'community_content',
        'community_view',
        'community_like',
        'community_board_type'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id')->select('user_id', 'nickname','profile');
    }
    public function communityPhotos() {
        return $this->hasMany(CommunityPhoto::class,'community_id')->select('community_id','community_photo_id', 'community_photo_url')->orderBy('created_at');
    }

    // protected $dates =['deleted_at']; //소프트 삭제를 위한 빌드
}
