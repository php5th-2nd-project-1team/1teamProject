<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTheme extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_themes';

    protected $primaryKey = 'category_theme_id';

    protected $fillable = [
        'category_theme_name',
        'category_theme_num',
    ];

    protected function serialize(\DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
