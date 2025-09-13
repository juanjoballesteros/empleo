<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

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
        $data = $request->input('entry.0.changes.0.value.messages.0');

        Log::info('WhatsApp webhook received', $request->all());
        Log::info('Message', ['message' => $data]);
        Log::debug('Message', ['message' => $data]);

        if (! $data) {
            return;
        }

        $from = (int) $data['from'];
        $text = 'no hay mensaje';
        if ($data['type'] === 'text') {
            $text = $data['text']['body'];
        }

        if (! Chat::where('phone', $from)->exists()) {
            $chat = Chat::create([
                'phone' => $from,
                'state' => 'welcome',
            ]);

            $chat->messages()->create([
                'text' => $text,
            ]);

            $this->sendMessage('Bienvenido a DigiEconomías, para crear tu hoja de vida digita 1', $from);
            Log::debug('mensaje enviado digieconomias');

            return;
        }

        $chat = Chat::where('phone', $from)->firstOrFail();
        $state = $chat->state;
        Log::debug('ingresa a el chat');

        $chat->messages()->create([
            'text' => $text,
        ]);

        if ($state === 'welcome') {
            if ($text === '1') {
                $chat->update([
                    'state' => 'personal-info-front',
                ]);

                $this->sendMessage('Toma una foto de la zona frontal de tu puerta', $from);
                Log::debug('mensaje enviado foto');
            }
        }

        if ($state === 'personal-info-front') {
            if ($data['type'] !== 'image') {
                Log::debug('mensaje no hay foto');
                $this->sendMessage('no hemos identificado la foto', $from);

                return;
            }

            $mediaId = (int) $data['image']['id'];
            $media = $this->getMediaUrl($mediaId);
            Log::debug('mediaurl', ['media' => $media, 'mediaid' => $mediaId]);

            $media = $chat->addMedia($media)
                ->toMediaCollection('front');

            $cardSchema = new ObjectSchema(
                'document_card_review',
                'Complete Review Of A Document Card',
                [
                    new StringSchema('document_type', 'Document Type: CC, TI, PAS, CE'),
                    new NumberSchema('document_number', 'Document Number'),
                    new StringSchema('first_name', 'First Name Of Document (the first word in the name)'),
                    new StringSchema('second_name', 'Second Name Of Document (the second word in the name)', true),
                    new StringSchema('first_surname', 'First Surname Of Document (the first word in the last name)'),
                    new StringSchema('second_surname', 'Second Surname Of Document (the second word in the last name)', true),
                ]
            );

            $response = Prism::structured()
                ->using(Provider::Gemini, 'gemini-2.5-flash-lite-preview-06-17')
                ->withSchema($cardSchema)
                ->withPrompt(
                    'Analyze this image that can be: cedula de ciudadanía, cedula de extranjería, pasaporte, tarjeta de identidad',
                    [Image::fromStoragePath($media->getPath())])
                ->asStructured();

            $frontData = $response->structured;

            $chat->update([
                'state' => 'personal-info-back',
            ]);

            $this->sendMessage('estos son tus datos'.json_encode($frontData), $from);
            Log::debug('mensaje enviado con datos');
        }

        // $this->sendMessage($text, $from);
    }

    private function sendMessage(string $text, int $phone): void
    {
        Http::withToken(config('services.whatsapp.api_key'))
            ->post('https://graph.facebook.com/v23.0/100501593099262/messages', [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $text,
                ],
            ]);
    }

    private function getMediaUrl(int $mediaId): string
    {
        $responseUrl = Http::withToken(config('services.whatsapp.api_key'))
            ->get('https://graph.facebook.com/v23.0/'.$mediaId);
        $mediaUrl = $responseUrl->json()['url'];

        $media = Http::withToken(config('services.whatsapp.api_key'))
            ->get($mediaUrl);

        $url = Storage::put('whatsapp/'.Str::random(), $media->body());

        return $url;
    }
}
