<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BasicEducationInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $level
 * @property string $program
 * @property Carbon $end_date
 * @property bool $check
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Cv $cv
 */
final class BasicEducationInfo extends Model implements HasMedia
{
    /** @use HasFactory<BasicEducationInfoFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }

    protected function casts(): array
    {
        return [
            'end_date' => 'date',
        ];
    }
}
