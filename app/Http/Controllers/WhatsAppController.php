<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class WhatsAppController extends Controller
{
    public function token(Request $request)
    {
        $hubChallenge = $request->input('hub.challenge');
        $token = $request->input('hub.verify_token');

        $ourToken = 'Hola1234';

        if ($token === $ourToken) {
            Log::info('WhatsApp token verified');

            return response()->json(['success' => true, 'hub.challenge' => $hubChallenge, 'hub.mode' => 'subscribe']);
        }

        return response()->json(['success' => false], 403);
    }
}
