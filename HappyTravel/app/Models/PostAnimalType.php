<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostAnimalType extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_animal_type_id';

    protected $guarded = [
        'post_animal_type_id',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
