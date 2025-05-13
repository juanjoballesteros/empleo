<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\LanguageInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $write
 * @property string $speak
 * @property string $read
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Cv $cv
 */
final class LanguageInfo extends Model implements HasMedia
{
    /** @use HasFactory<LanguageInfoFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }
}
