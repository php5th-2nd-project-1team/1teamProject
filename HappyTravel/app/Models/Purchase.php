<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $primaryKey = 'purchase_id';

    protected $fillable = [
        'purchase_price',  // 결제 금액
        'user_id',         // 사용자 ID
        'contact',         // 연락처
        'reservations_name', // 예약자 이름
        'animal_type',     // 동물 종류
        'notes',           // 주의사항
        'class_id',        // 클래스 ID
        'reservations_number',        // 예약자 숫자
        
    ];
}
