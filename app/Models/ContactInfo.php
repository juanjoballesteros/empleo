<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ContactInfoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $phone_number
 * @property string $email
 * @property bool $check
 * @property int $cv_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Cv $cv
 */
final class ContactInfo extends Model
{
    /** @use HasFactory<ContactInfoFactory> */
    use HasFactory;

    /** @return BelongsTo<Cv, $this> */
    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }
}
