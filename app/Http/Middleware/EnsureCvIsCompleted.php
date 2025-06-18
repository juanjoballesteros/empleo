<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Candidate;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureCvIsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = $request->user();
        $candidate = $user->userable;
        assert($candidate instanceof Candidate);

        if ($candidate->cv && ! $candidate->cv->isCompleted()) {
            $cv = $user->cv()->firstOrCreate(['candidate_id' => $candidate->id]);

            session()->flash('error', 'Complete su hoja de vida para continuar.');

            return redirect()->route('cv.create.personal-info', $cv->id);
        }

        return $next($request);
    }
}
