<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'inquiry_id';

    protected $fillable = [
        'user_id',
        'inquiry_title',
        'inquiry_content',
        'inquiry_secret',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
