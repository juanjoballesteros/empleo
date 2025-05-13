<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PersonalInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string $first_surname
 * @property string $second_surname
 * @property string $sex
 * @property string $document_type
 * @property string $document_number
 * @property string $description
 * @property bool $check
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Cv $cv
 */
final class PersonalInfo extends Model implements HasMedia
{
    /** @use HasFactory<PersonalInfoFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }
}
