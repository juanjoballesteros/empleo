<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cv;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\PdfBuilder;

use function Spatie\LaravelPdf\Support\pdf;

final class PdfController extends Controller
{
    public function __invoke(Request $request): PdfBuilder
    {
        $user = $request->user();
        assert($user instanceof User);
        $candidate = $user->userable;
        assert($candidate instanceof Candidate);
        $cv = $candidate->cv;

        return pdf()->view('pdf', ['cv' => $cv])->name('hv.pdf');

    }
}
