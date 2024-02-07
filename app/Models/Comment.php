<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $fillable = [
        'value',
        'user_id',
        'post_id',
        // 'notif_id'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class,'user_id');
    }
    public function notification(): BelongsTo {
        return $this->belongsTo(Notification::class,'notif_id');
    }
    //reverse
    public function reaction(): HasMany
 {
     return $this->hasMany(Reaction::class);
 }
}
