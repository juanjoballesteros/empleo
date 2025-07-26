<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

final class CvPdf
{
    public function __invoke(): PdfBuilder
    {
        $user = request()->user();
        assert($user instanceof User);
        $cv = $user->cv;

        return pdf()->view('pdf', ['cv' => $cv])->name('hv.pdf');
    }
}
