<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalType extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'animal_type_id';

    protected $fillable = [
        'animal_type_num',
        'animal_type_name',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    
}
