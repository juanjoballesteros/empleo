<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\HigherEducationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $program
 * @property string $institution
 * @property string $type
 * @property Carbon $date_start
 * @property bool $actual
 * @property ?Carbon $date_end
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Cv $cv
 */
final class HigherEducation extends Model implements HasMedia
{
    /** @use HasFactory<HigherEducationFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'actual' => 'boolean',
            'date_end' => 'date',
        ];
    }
}
