<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class GroupPost extends Model
{
    use HasFactory;
    protected $table = "group_posts";
    protected $fillable = [
    'group_id',
    'user_id',

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
     return $this->hasMany(GroupPostComment::class,'post_id');
 }
 public function reactions(): HasMany
 {
     return $this->hasMany(GroupPostReaction::class,'post_id');
 }
 public function text(): HasOne
 {
     return $this->hasOne(GroupPostText::class,'post_id');
 }
 public function image(): HasOne
 {
     return $this->hasOne(GroupPostImage::class,'post_id');
 }
 public function video(): HasOne
 {
     return $this->hasOne(GroupPostVideo::class,'post_id');
 }

 public $withCount = ['comments','reactions'];
}
