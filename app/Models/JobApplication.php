<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JobStatus;
use Database\Factories\JobApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $job_offer_id
 * @property int $candidate_id
 * @property int $company_id
 * @property string $status
 * @property ?string $notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read JobOffer $jobOffer
 * @property-read Candidate $candidate
 * @property-read Company $company
 */
final class JobApplication extends Model
{
    /** @use HasFactory<JobApplicationFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<JobOffer, $this>
     */
    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }

    /**
     * @return BelongsTo<Candidate, $this>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected function casts(): array
    {
        return [
            'status' => JobStatus::class,
        ];
    }
}
