<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $fillable = [
    //'group_id'
    'user_id',
    'post_type',
    'group_post'
];


    public function group(): BelongsTo
 {
     return $this->belongsTo(Group::class, 'group_id');
 }

 public function user(): BelongsTo {
     return $this->belongsTo(User::class);
 }
 //reverse
 public function comments(): HasMany
 {
     return $this->hasMany(Comment::class,'post_id');
 }
 public function reactions(): HasMany
 {
     return $this->hasMany(Reaction::class);
 }
 public function text(): HasOne
 {
     return $this->hasOne(Text::class,'post_id');
 }
 public function image(): HasMany
 {
     return $this->hasMany(Imgae::class,'post_id');
 }
 public function video(): HasOne
 {
     return $this->hasOne(Veido::class,'post_id');
 }
 public function post_group(): HasOne
 {
     return $this->hasOne(Post_Group::class);
 }

 public $withCount = ['comments', 'reactions'];
}
