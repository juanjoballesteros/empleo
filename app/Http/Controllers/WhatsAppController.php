<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class WhatsAppController extends Controller
{
    public function token(Request $request)
    {
        $hubChallenge = $request->input('hub_challenge');
        $token = $request->input('hub_verify_token');

        $ourToken = 'Hola1234';

        if ($token === $ourToken) {
            Log::info('WhatsApp token verified');

            return response()->json(['success' => true, 'hub.challenge' => $hubChallenge, 'hub.mode' => 'subscribe']);
        }

        Log::info($hubChallenge);
        Log::info($token);
        Log::info($ourToken);

        return response()->json(['success' => false], 403);
    }
}
