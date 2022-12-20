<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['numberOfPosts']

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getPathAttribute() {
        return "/category/$this->slug";
    }

    public function posts() {
        return $this->hasMany(Posts::class);
    }

    public function getNumberOfPostsAttribute() {
        return $this->posts->count();
    }
}
