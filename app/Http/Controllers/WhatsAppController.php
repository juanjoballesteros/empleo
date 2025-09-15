<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

final class WhatsAppController extends Controller
{
    private int $phone;

    public function token(Request $request): string|JsonResponse
    {
        $hubChallenge = $request->input('hub_challenge');
        $token = $request->input('hub_verify_token');

        $ourToken = 'Hola1234';

        if ($token === $ourToken) {
            return $hubChallenge;
        }

        return response()->json(['success' => false], 403);
    }

    public function webhook(Request $request): ?JsonResponse
    {
        $data = $request->input('entry.0.changes.0.value.messages.0');

        if (! $data) {
            return $this->response();
        }

        $this->phone = (int) $data['from'];
        $text = 'no hay mensaje';
        if ($data['type'] === 'text') {
            $text = $data['text']['body'];
        }

        $chat = Chat::query()->firstOrCreate(['phone' => $this->phone], [
            'phone' => $this->phone,
            'state' => 'welcome',
        ]);
        $state = $chat->state;
        $chat->messages()->create([
            'text' => $text,
        ]);

        if ($state === 'welcome') {
            $this->sendMessage("Bienvenido a DigiEconomías \nenvía una foto frontal de tu documento de identidad");
            $chat->update([
                'state' => 'personal-info-front',
            ]);

            return $this->response();
        }

        if ($state === 'personal-info-front') {
            if ($data['type'] !== 'image') {
                $this->sendMessage('no hemos identificado la foto, por favor vuelva a enviarla');

                return $this->response();
            }

            $mediaId = (int) $data['image']['id'];
            $url = $this->getMediaUrl($mediaId);
            $chat->addMedia($url)
                ->toMediaCollection('front');

            $chat->update([
                'state' => 'personal-info-back',
            ]);

            $this->sendMessage('Ahora envía la foto de la parte de atrás de tu documento');
        }

        if ($state === 'personal-info-back') {
            if ($data['type'] !== 'image') {
                $this->sendMessage('no hemos identificado la foto, por favor vuelva a enviarla');

                return $this->response();
            }

            $mediaId = (int) $data['image']['id'];
            $url = $this->getMediaUrl($mediaId);

            $front = $chat->addMedia($url)->toMediaCollection('front')->getPath();
            $back = $chat->getFirstMediaPath('back');

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
                    new StringSchema('sex', 'The sex of the document: M, F'),
                    new StringSchema('birthdate', 'Birthdate in the document in format (00-00-0000, d-m-Y)'),
                    new StringSchema('department_id', 'Department id taken of the DANE id departments'),
                    new StringSchema('city_id', 'City id taken of the DANE id city'),
                ],
                nullable: true,
            );

            $response = Prism::structured()
                ->using(Provider::Gemini, 'gemini-2.5-flash-lite')
                ->withSchema($cardSchema)
                ->withPrompt(
                    'Analyze this image that can be: cedula de ciudadanía, cedula de extranjería, pasaporte, tarjeta de identidad',
                    [Image::fromLocalPath($front), Image::fromLocalPath($back)]
                )->asStructured();

            $cardData = $response->structured;

            $chat->update([
                'state' => 'personal-info-back',
            ]);

            $this->sendMessage('estos son tus datos'.json_encode($cardData));
        }

        return $this->response();
    }

    private function response(): JsonResponse
    {
        return response()->json(['Mensaje Recibido']);
    }

    private function sendMessage(string $text, ?int $phone = null): void
    {
        if (is_null($phone)) {
            $phone = $this->phone;
        }

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

        $url = storage_path('app/public/whatsapp/'.Str::random().'.png');

        file_put_contents($url, $media->body());

        return $url;
    }
}
