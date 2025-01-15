<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityType extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'facility_type_id';

    protected $fillable = [
        'facility_type_num',
        'facility_type_name',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
