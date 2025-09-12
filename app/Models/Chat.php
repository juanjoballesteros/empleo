<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ChatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $state
 * @property int $phone
 * @property ?int $user_id
 * @property-read Collection<int, Message> $messages
 * @property-read ?User $user
 */
final class Chat extends Model implements HasMedia
{
    /** @use HasFactory<ChatFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return HasMany<Message, $this> */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    /** @return BelongsTo<User, $this */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
