<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AddFriend extends Model
{
    use HasFactory;
    protected $table = "add_friends";
    protected $fillable = [
        // 'user_id',
        // 'friend_id'
        'user_requested',
        // 'status',
        'accesptor'
        // 'notif_id'
    ];
    // public function newfriends()
    // {
    //     return $this->hasOne(User::class,'friend_id','id');
    // }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

}
