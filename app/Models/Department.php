<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, City> $cities
 * @property-read Collection<int, Company> $companies
 * @property-read Collection<int, Candidate> $candidates
 * @property-read Collection<int, JobOffer> $jobOffers
 */
final class Department extends Model
{
    public $timestamps = false;

    /** @return HasMany<City, $this> */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'department_id');
    }

    /**
     * @return HasMany<Company, $this>
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'department_id');
    }

    /**
     * @return HasMany<Candidate, $this>
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'department_id');
    }

    /**
     * @return HasMany<JobOffer, $this>
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class, 'department_id');
    }
}
