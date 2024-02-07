<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post_Group extends Model
{
    use HasFactory;
    protected $table = "post__groups";
    protected $fillable = [
        'post_id',
        'group_id'
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class );
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
