<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityPhoto extends Model {
    use HasFactory, SoftDeletes;

    protected $primaryKey ='community_photo_id';

    protected $fillable = [
        'community_id'
        ,'community_photo_url'
        ,'created_at'
        ,'updated_at'
        ,'deleted_at'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');
    }

    
}
