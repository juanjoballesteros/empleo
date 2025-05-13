<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\WorkExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $email
 * @property string $phone_number
 * @property Carbon $date_start
 * @property string $actual
 * @property Carbon $date_end
 * @property string $cause
 * @property string $post
 * @property string $dependency
 * @property string $address
 * @property int $department_id
 * @property int $city_id
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Department $department
 * @property-read City $city
 * @property-read Cv $cv
 */
final class WorkExperience extends Model implements HasMedia
{
    /** @use HasFactory<WorkExperienceFactory> */
    use HasFactory, InteractsWithMedia;

    /** @return BelongsTo<Department, $this> */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /** @return BelongsTo<City, $this> */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'date_end' => 'date',
        ];
    }
}
