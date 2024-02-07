<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Group extends Model
{
    use HasFactory;
    protected $table = "groups";
    protected $fillable = [
    'group_name',
    'details',
    'admin_id',
    'value_img'
];

    // public function post(): HasMany
    // {
    //     return $this->hasMany(Post::class,'user_id');
    // }

    public function user3():BelongsTo
    {
        return $this->belongsTo(User::class ,'admin_id');
    }
    public function user_group(): HasMany
    {
        return $this->hasMany(User_Group::class);
    }
    public function post_group(): HasMany
    {
        return $this->hasMany(Post_Group::class);
    }
    public function grouppost(): HasMany
    {
        return $this->hasMany(GroupPost::class);
    }
}
