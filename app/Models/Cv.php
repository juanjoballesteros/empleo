<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CvFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $candidate_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read Candidate $candidate
 * @property-read ?PersonalInfo $personalInfo
 * @property-read ?ContactInfo $contactInfo
 * @property-read ?ResidenceInfo $residenceInfo
 * @property-read ?BasicEducationInfo $basicEducationInfo
 * @property-read ?Collection<int, HigherEducation> $higherEducations
 * @property-read ?Collection<int, WorkExperience> $workExperiences
 * @property-read ?Collection<int, LanguageInfo> $languageInfos
 */
final class Cv extends Model
{
    /** @use HasFactory<CvFactory> */
    use HasFactory;

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Candidate, $this> */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function isCompleted(): bool
    {
        return $this->personalInfo?->check
            && $this->contactInfo?->check
            && $this->residenceInfo?->check
            && $this->basicEducationInfo?->check
            && $this->higherEducations()->exists()
            && $this->workExperiences()->exists()
            && $this->languageInfos()->exists();
    }

    /** @return HasMany<HigherEducation, $this> */
    public function higherEducations(): HasMany
    {
        return $this->hasMany(HigherEducation::class, 'cv_id');
    }

    /** @return HasMany<WorkExperience, $this> */
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class, 'cv_id');
    }

    /** @return HasMany<LanguageInfo, $this> */
    public function languageInfos(): HasMany
    {
        return $this->hasMany(LanguageInfo::class, 'cv_id');
    }

    /** @return HasOne<PersonalInfo, $this> */
    public function personalInfo(): HasOne
    {
        return $this->hasOne(PersonalInfo::class, 'cv_id');
    }

    /** @return HasOne<ContactInfo, $this> */
    public function contactInfo(): HasOne
    {
        return $this->hasOne(ContactInfo::class, 'cv_id');
    }

    /** @return HasOne<ResidenceInfo, $this> */
    public function residenceInfo(): HasOne
    {
        return $this->hasOne(ResidenceInfo::class, 'cv_id');
    }

    /** @return HasOne<BasicEducationInfo, $this> */
    public function basicEducationInfo(): HasOne
    {
        return $this->hasOne(BasicEducationInfo::class, 'cv_id');
    }
}
