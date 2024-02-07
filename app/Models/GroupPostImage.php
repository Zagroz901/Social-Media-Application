<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupPostImage extends Model
{
    use HasFactory;
    protected $table = "group_post_images";
    protected $fillable = [
        'post_id',
        'value_img',
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(GroupPost::class);
    }
}
