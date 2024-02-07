<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupPostText extends Model
{
    use HasFactory;
    protected $table = "group_post_texts";
    protected $fillable = [
    'post_id',
    'value'
];
    public function post(): BelongsTo
    {
        return $this->belongsTo(GroupPost::class);
    }

}
