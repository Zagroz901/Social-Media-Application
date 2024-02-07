<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\Relations\BelongsTo;
class GroupPostVideo extends Model
{
    use HasFactory;
    protected $table = "group_post_videos";
    protected $fillable = [
    'post_id',
    'value_vd',
    'views'
];
    public function post(): BelongsTo
    {
        return $this->belongsTo(GroupPost::class);
    }

}
