<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $visible = ['id', 'title', 'body', 'likes', 'time', 'breadcumbs', 'category_id', 'user', 'replies'];
    protected $appends = ['time', 'breadcrumbs', 'user', 'replies'];
    protected $casts = [
        'likes' => 'integer',
        'user_id' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($post){
            $post->slug = str_slug($post->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getTimeAttribute() {
        return $this->created_at->timestamp;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function getUserAttribute()
    {
        $user = $this->user()->first();

        return [
            'id'   => $user->id,
            'name' => $user->name
        ];
    }

    public function getBreadcrumbsAttribute()
    {
        $category = $this->category;

        return [
            [ 'name' => 'Home', 'link' => '/' ],
            [ 'name' => $category->name, 'link' => "/category/$category->id"],
            [ 'name' => $this->title, 'link' => "/category/$category->id/$this->slug"]
        ];
    }
    
    public function getPathAttribute()
    {
        $category = $this->category;

        return "/category/$category->id/$this->slug";
    }

    public function getRepliesAttribute()
    {
        return $this->replies()->get();
    }
}
