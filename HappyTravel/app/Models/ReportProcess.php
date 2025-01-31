<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportProcess extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'report_process_id';

    protected $guarded = [
        'report_process_id',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
