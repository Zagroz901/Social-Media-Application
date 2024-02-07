<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Imgae extends Model
{
    use HasFactory;
    protected $table = "imgaes";
    protected $fillable = [
        'post_id',
        'value_img',
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
