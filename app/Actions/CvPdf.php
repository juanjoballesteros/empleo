<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Candidate;
use App\Models\User;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

final class CvPdf
{
    public function __invoke(): PdfBuilder
    {
        $user = request()->user();
        assert($user instanceof User);
        $candidate = $user->userable;
        assert($candidate instanceof Candidate);
        $cv = $candidate->cv;

        return pdf()->view('pdf', ['cv' => $cv])->name('hv.pdf');
    }
}
