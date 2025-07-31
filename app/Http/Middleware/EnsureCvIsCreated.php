<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Candidate;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

final class EnsureCvIsCreated
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        assert($user instanceof User);

        $candidate = $user->userable;
        assert($candidate instanceof Candidate);

        if ($candidate->cv()->doesntExist()) {
            $candidate->cv()->create([
                'user_id' => $user->id,
            ]);
        }

        return $next($request);
    }
}
