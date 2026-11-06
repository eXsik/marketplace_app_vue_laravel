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
        if ($search = ($filters['search'] ?? null)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($filters['user_id'] ?? false) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($tag = trim($filters['tag'] ?? '')) {
            $escapedTag = str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $tag);

            $query->where(function (Builder $query) use ($tag, $escapedTag) {
                $query->where('tags', $tag)
                    ->orWhereRaw("tags LIKE ? ESCAPE '!'", [$escapedTag . ',%'])
                    ->orWhereRaw("tags LIKE ? ESCAPE '!'", ['%,' . $escapedTag . ',%'])
                    ->orWhereRaw("tags LIKE ? ESCAPE '!'", ['%,' . $escapedTag]);
            });
        }

        if ($filters['disapproved'] ?? false) {
            $query->where('approved', false);
        }
    }

    public static function processTags($tags): string
    {
        if (!is_string($tags) || trim($tags) === '') {
            return '';
        }

        return implode(',', array_filter(array_map('trim', explode(',', $tags))));
    }

}
