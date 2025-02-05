<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $primaryKey = "password_resets_id";

    protected $table = 'password_resets'; // 테이블명 지정

    protected $fillable = ['email', 'token', 'created_at']; // 대량 할당 가능 속성

    public $timestamps = false; // `created_at`만 사용하고 `updated_at`은 필요 없음

}
