<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeNotSuspended($query)
    {
        return $query->whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        if ($filters['user_id'] ?? false) {
            $query->where('user_id', request('user_id'));
        }

        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['disapproved'] ?? false) {
            $query->where('approved', false);
        }
    }

    public static function processTags($tags): string
    {
        return implode(',', array_filter(array_map('trim', explode(',', $tags))));
    }

}
