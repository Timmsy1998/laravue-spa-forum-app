<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function($reply){
            $reply->user_id = auth()->id();
        });
    }

    protected $guarded = [];

    protected $fillable = ['body', 'user_id', 'post_id'];
    protected $visible = ['body', 'user', 'time'];
    protected $appends = ['user', 'time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function getUserAttribute()
    {
        $user = $this->user()->first();

        return [
            'id'   => $user->id,
            'name' => $user->name
        ];
    }

    public function getTimeAttribute()
    {
        return $this->created_at->timestamp;
    }
}
