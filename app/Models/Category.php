<?php

namespace App\Models;

use App\Traits\HasPrimaryKeyUuid;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory, HasPrimaryKeyUuid, SerializeDate;

    protected $fillable = [
        'name',
    ];

    public function scopeUserAuth(Builder $builder, string $user_id): void
    {
        $builder->where('user_id', $user_id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
