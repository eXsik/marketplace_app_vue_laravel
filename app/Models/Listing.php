<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'tags', 'email', 'image', 'link', 'approved'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
