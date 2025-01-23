<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'user_id';

    protected $fillable= [
        'account',
        'password',
        'name',
        'nickname',
        'gender',
        'address',
        'detail_address',
        'phone_number',
        'refresh_token',
        'post_code'
        ,'profile'
        ,'email'
    ];
    protected $hidden = [
        'password',
        'refresh_token',        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');       
    }

    public function communityBoards() {
        return $this->hasMany(CommunityBoard::class , 'user_id');
    }

}
