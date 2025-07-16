<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

final class PersonalInfo extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $first_name;

    #[Validate(['required', 'nullable', 'max:255'])]
    public string $second_name;

    #[Validate(['required', 'string', 'max:255'])]
    public string $first_surname;

    #[Validate(['required', 'string', 'max:255'])]
    public string $second_surname;

    #[Validate(['required', 'string', 'max:255'])]
    public string $sex;

    #[Validate(['required', 'string', 'max:255'])]
    public string $document_type;

    #[Validate(['required', 'numeric'])]
    public string $document_number;

    public string $description;

    public ?TemporaryUploadedFile $document_front = null;

    public ?TemporaryUploadedFile $document_back = null;

    public ?TemporaryUploadedFile $profile = null;

    /** @var array<string, string>|null[] */
    public array $document_urls = ['front' => null, 'back' => null, 'profile'];

    /** @var array<string, string> */
    public ?array $data = [];

    /** @return array<string, list<string|RequiredIf>> */
    public function rules(): array
    {
        return [
            'document_front' => [Rule::requiredIf(! isset($this->document_urls['front'])), 'nullable', 'file', 'image'],
            'document_back' => [Rule::requiredIf(! isset($this->document_urls['back'])), 'nullable', 'file', 'image'],
            'profile' => [Rule::requiredIf(! isset($this->document_urls['profile'])), 'nullable', 'file', 'image'],
        ];
    }

    public function mount(Cv $cv): void
    {
        if (session()->has('error')) {
            LivewireAlert::title(session()->get('error'))
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }

        if ($personalInfo = $cv->personalInfo) {
            $this->document_urls = [
                'front' => $personalInfo->getFirstMediaUrl('front'),
                'back' => $personalInfo->getFirstMediaUrl('back'),
                'profile' => $personalInfo->getFirstMediaUrl('profile'),
            ];

            $this->fill($personalInfo);
        }
    }

    // @codeCoverageIgnoreStart
    public function analyzeImage(): void
    {
        $this->validate([
            'document_front' => ['required', 'image'],
            'document_back' => ['required', 'image'],
        ]);

        $frontSchema = new ObjectSchema(
            'front_review_document_card',
            'Front Image Review Of A Document Card',
            [
                new StringSchema('document_type', 'Document Type: CC, TI, PAS, CE'),
                new NumberSchema('document_number', 'Document Number'),
                new StringSchema('first_name', 'First Name Of Document (the first word in the name)'),
                new StringSchema('second_name', 'Second Name Of Document (the second word in the name)', true),
                new StringSchema('first_surname', 'First Surname Of Document (the first word in the last name)'),
                new StringSchema('second_surname', 'Second Surname Of Document (the second word in the last name)', true),
            ]
        );

        $backSchema = new ObjectSchema(
            'back_review_document_card',
            'Back Image Review Of A Document Card',
            [
                new StringSchema('sex', 'The sex of the document: M, F'),
                /*new StringSchema('birthdate', 'Birthdate in the document in format (00-00-0000, d-m-Y), it can't be after today'),
                new StringSchema('department_id', 'Department id taken of the DANE id departments'),
                new StringSchema('city_id', 'City id taken of the DANE id city'),*/
            ],
        );

        $cardSchema = new ObjectSchema(
            'document_card_review',
            'Complete Review Of A Document Card',
            [$frontSchema, $backSchema]
        );

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-flash-lite-preview-06-17')
            ->withSchema($cardSchema)
            ->withPrompt(
                'Analyze this image that can be: cedula de ciudadanía, cedula de extranjería, pasaporte, tarjeta de identidad',
                [
                    Image::fromUrl($this->document_front?->temporaryUrl()),
                    Image::fromUrl($this->document_back?->temporaryUrl()),
                ])
            ->asStructured();

        $this->data = $response->structured;

        if (! isset($this->data['front_review_document_card']) || empty($this->data['front_review_document_card'])) {
            LivewireAlert::title('No hemos detectado un documento valido, por favor vuelva a intentarlo')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            $this->data = [];
            $this->document_front = null;
            $this->document_back = null;
        }

        $this->fill($this->data['front_review_document_card']);
    }
    // @codeCoverageIgnoreEnd

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.create.birth-info', $this->cv->id, navigate: true);

        /** @var \App\Models\PersonalInfo $personalInfo */
        $personalInfo = $this->cv->personalInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->pull([
            'first_name',
            'second_name',
            'first_surname',
            'second_surname',
            'sex',
            'document_type',
            'document_number',
            'description',
        ]));

        if ($this->document_front instanceof TemporaryUploadedFile) {
            if ($front = $personalInfo->getFirstMedia('front')) {
                $front->delete();
            }

            $personalInfo->addMedia($this->document_front)
                ->preservingOriginal()
                ->toMediaCollection('front');
        }

        if ($this->document_back instanceof TemporaryUploadedFile) {
            if ($back = $personalInfo->getFirstMedia('back')) {
                $back->delete();
            }

            $personalInfo->addMedia($this->document_back)
                ->preservingOriginal()
                ->toMediaCollection('back');
        }

        if ($this->profile instanceof TemporaryUploadedFile) {
            if ($profile = $personalInfo->getFirstMedia('profile')) {
                $profile->delete();
            }

            $personalInfo->addMedia($this->profile)
                ->preservingOriginal()
                ->toMediaCollection('profile');
        }

        LivewireAlert::title('Información Personal Guardado')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.personal-info');
    }
}
