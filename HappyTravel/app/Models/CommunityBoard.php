<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityBoard extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'communinty_id';

    protected $fillable = [
        'community_id',
        'commuinty_type',
        'community_title',
        'community_content',
        'community_view',
        'community_like',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id')->select('user_id', 'nickname');
    }
}
