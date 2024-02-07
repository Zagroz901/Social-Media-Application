<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'birthdate',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }
    public function friend(): HasMany
    {
        return $this->hasMany(Friend::class);
    }
    public function profile(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    public function newfriends(): HasMany
    {
        return $this->hasMany(AddFriend::class);
    }
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
    public function user_group(): HasMany
    {
        return $this->hasMany(User_Group::class);
    }
    public function picture()
    {
        return $this->hasOne(Picture::class);
	}
    //     public function addallFriend(User $user)
    //     {
    //         if($this->newfriends()->where('friend_id',$user->id)->first())
    //             {
    //                 return null;
    //                 }
    //                 return $this->newfriends()->save(
    //                 model:new AddFriend(['friend_id',$user->id])
    //     );
    // }
    ////////////////////Group////////////////////
    public function postg(): HasMany
    {
        return $this->hasMany(GroupPost::class);
    }
    public function commentg(): HasMany
    {
        return $this->hasMany(GroupPostComment::class);
    }
    public function reactiong(): HasMany
    {
        return $this->hasMany(GroupPostReaction::class);
    }

}
