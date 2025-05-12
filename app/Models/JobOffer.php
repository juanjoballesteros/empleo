<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\JobOfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property array<string, string> $requirements
 * @property int $salary
 * @property string $type
 * @property string $location
 * @property ?int $department_id
 * @property ?int $city_id
 * @property int $company_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Company $company
 * @property-read Department $department
 * @property-read City $city
 */
final class JobOffer extends Model
{
    /** @use HasFactory<JobOfferFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function casts(): array
    {
        return [
            'requirements' => 'array',
        ];
    }
}
