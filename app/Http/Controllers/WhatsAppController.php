<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $message = $request->input('entry.0.changes.0.value.messages.0');

        Log::info('WhatsApp webhook received', $request->all());
        Log::info('Message', ['message' => $message]);

        if ($message) {
            Http::withToken(config('services.whatsapp.api_key'))
                ->post('https://graph.facebook.com/v22.0/100501593099262/messages', [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $message['from'],
                    'type' => 'text',
                    'text' => [
                        'body' => 'Mensaje recibido',
                    ],
                ]);
        }
    }
}
