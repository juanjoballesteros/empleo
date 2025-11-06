<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cv;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class PdfController extends Controller
{
    public function __invoke(Request $request, ?Cv $cv = null): Response
    {
        if (is_null($cv)) {
            $user = $request->user();
            assert($user instanceof User);
            $candidate = $user->userable;
            assert($candidate instanceof Candidate);
            $cv = $candidate->cv;
        }

        return Pdf::loadView('pdf', ['cv' => $cv])->setOption('defaultFont', 'Courier')->stream();
    }
}
