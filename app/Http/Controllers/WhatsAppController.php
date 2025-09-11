<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class WhatsAppController extends Controller
{
    public function token(Request $request): string|JsonResponse
    {
        $hubChallenge = $request->input('hub_challenge');
        $token = $request->input('hub_verify_token');

        $ourToken = 'Hola1234';

        if ($token === $ourToken) {
            Log::info('WhatsApp token verified', $request->all());

            return $hubChallenge;
        }

        Log::info('WhatsApp token not verified', $request->all());

        return response()->json(['success' => false], 403);
    }

    public function webhook(Request $request): void
    {
        Log::info('WhatsApp webhook received', $request->all());
    }
}
