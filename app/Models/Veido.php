<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Veido extends Model
{
    use HasFactory;
    protected $table = "veidos";
    protected $fillable = [
    'post_id',
    'value_vd'
];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
