<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{       
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'manager_id';

    protected $fillable = [        
        'm_account',
        'm_password',
        'm_nickname',
        'refresh_token',
    ];

    protected $hidden = [
        'm_password',
        'refresh_token',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');       
    }

    public function notices() {
        return $this->hasMany(Notice::class , 'manager_id');
    }
}
