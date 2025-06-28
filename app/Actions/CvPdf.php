<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Cv;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

final class CvPdf
{
    public function __invoke(Cv $cv): PdfBuilder
    {
        return pdf()->view('pdf', ['cv' => $cv])->name('hv.pdf');
    }
}
