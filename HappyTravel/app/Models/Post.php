<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'manager_id',
        'category_local_num',
        'category_theme_num',
        'post_local_name',
        'post_title',
        'post_content',
        'post_detail_content',
        'post_img',
        'post_like',
        'post_view',
    ];

    protected function serialize(\DateTimeInterface $date) {
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
}
