<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory ,SoftDeletes;

    protected $primaryKey = 'notice_id';

    protected $fillable = [
        'manager_id',       
        'notice_title',
        'notice_content',
        'notice_img',
        'notice_tag',
    ];
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date ->format('Y-m-d H:i:s');       
    }

    public function managers() {
        return $this->belongsTo(Manager::class, 'manager_id')->select('manager_id', 'm_nickname');
    }

    
}
