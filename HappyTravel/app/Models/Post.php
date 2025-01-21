<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_id';

    protected $guarded = [
        'post_id',
    ];

    protected function serializeDate(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function manager(){
        return $this->belongsTo(Manager::class, 'manager_id')->select('m_nickname');
    }

    public function categoryLocal(){
        return $this->belongsTo(CategoryLocal::class, 'category_local_num');
    }

    public function categoryTheme(){
        return $this->belongsTo(CategoryTheme::class, 'category_theme_num');
    }

    public function postLikes(){
        return $this->hasMany(PostLike::class, 'post_id')->where('post_likes_flg', '=', '1');
    }

    public function animalType(){
        return $this->belongsTo(PostAnimalType::class, 'animal_type_num');
    }

    public function facilityType(){
        return $this->belongsTo(PostFacilityType::class, 'facility_type_num');
    }
}
