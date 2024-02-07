<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class GroupPostComment extends Model
{

    use HasFactory;
    protected $table = "group_post_comments";
    protected $fillable = [
        'value',
        'user_id',
        'post_id',
        //'notif_id'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(GroupPost::class , 'post_id');
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class,'user_id');
    }
    //reverse

//  public $withCount= 'reaction' ;
}
