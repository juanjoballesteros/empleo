<?php

declare(strict_types=1);

namespace App\Enums;

enum JobStatus: string
{
    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
