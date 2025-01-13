<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $primaryKey = 'verifications_id';

    protected $fillable = ['email', 'verification_code', 'expires_at'];

    public $timestamps = true;

    protected $dates = ['expires_at'];
}

