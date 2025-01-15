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

    public function post() {
        return $this->belongsTo(Post::class, 'post_id')->select('post_id');
    }

    public function animalType() {
        return $this->belongsTo(AnimalType::class, 'animal_type_num')->select('animal_type_num');
    }
}
