<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BirthInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $birthdate
 * @property bool $check
 * @property int $department_id
 * @property int $city_id
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Department $department
 * @property-read City $city
 * @property-read Cv $cv
 */
final class BirthInfo extends Model
{
    /** @use HasFactory<BirthInfoFactory> */
    use HasFactory;

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
            'birthdate' => 'date',
        ];
    }
}
