<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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

    public bool $show = false;

    #[Validate(['required', 'string', 'max:255'])]
    public string $first_name;

    #[Validate(['nullable', 'nullable', 'max:255'])]
    public ?string $second_name = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $first_surname;

    #[Validate(['nullable', 'string', 'max:255'])]
    public ?string $second_surname = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $sex;

    #[Validate(['required', 'string', 'max:255'])]
    public string $document_type;

    #[Validate(['required', 'numeric'])]
    public string $document_number;

    #[Validate(['required', 'date'])]
    public string $birthdate;

    #[Validate(['required', 'numeric', 'exists:departments,id'])]
    public string $department_id;

    #[Validate(['required', 'numeric', 'exists:cities,id'])]
    public string $city_id;

    /** @var Collection<int, Department> */
    public Collection $departments;

    public string $description;

    public ?TemporaryUploadedFile $document_front = null;

    public ?TemporaryUploadedFile $document_back = null;

    public ?TemporaryUploadedFile $profile = null;

    /** @var array<string, string>|null[] */
    public array $document_urls = ['front' => null, 'back' => null, 'profile' => null];

    /** @return array<string, list<string|RequiredIf>> */
    public function rules(): array
    {
        return [
            'document_front' => [Rule::requiredIf(! isset($this->document_urls['front'])), 'nullable', 'file', 'image'],
            'document_back' => [Rule::requiredIf(! isset($this->document_urls['back'])), 'nullable', 'file', 'image'],
            'profile' => [Rule::requiredIf(! isset($this->document_urls['profile'])), 'nullable', 'file', 'image'],
        ];
    }

    public function mount(): void
    {
        if (session()->has('error')) {
            LivewireAlert::title(session()->get('error'))->error()
                ->toast()
                ->position('top-end')
                ->show();
        }

        $this->departments = Department::all();

        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($personalInfo = $this->cv->personalInfo) {
            $this->document_urls = [
                'front' => $personalInfo->getFirstMediaUrl('front'),
                'back' => $personalInfo->getFirstMediaUrl('back'),
                'profile' => $personalInfo->getFirstMediaUrl('profile'),
            ];

            $this->fill($personalInfo);
            $this->show = true;
            $this->birthdate = $personalInfo->birthdate->toDateString();
        }
    }

    public function analyzeImage(): void
    {
        $this->validate([
            'document_front' => ['required', 'image'],
            'document_back' => ['required', 'image'],
        ]);

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
            ]
        );

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-flash')
            ->withSchema($cardSchema)
            ->withPrompt(
                'Analyze this image that can be: cedula de ciudadanía, cedula de extranjería, pasaporte, tarjeta de identidad', [
                    Image::fromLocalPath($this->document_front?->getRealPath() ?? ''),
                    Image::fromLocalPath($this->document_back?->getRealPath() ?? ''),
                ])
            ->asStructured();

        $data = $response->structured;

        if (! isset($data['first_name'], $data['document_number'])) {
            LivewireAlert::title('No hemos detectado un documento valido, por favor ingrese los datos manualmente')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            $this->show = true;

            return;
        }

        if (isset($data['birthdate'])) {
            $data['birthdate'] = Carbon::parse($data['birthdate'])->toDateString();
        }

        if (isset($data['sex'])) {
            $data['sex'] = match ($data['sex']) {
                'M' => 'Masculino',
                'F' => 'Femenino',
                default => '',
            };
        }

        $this->show = true;
        $this->fill($data);
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.contact-info', navigate: true);

        /** @var \App\Models\PersonalInfo $personalInfo */
        $personalInfo = $this->cv->personalInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->only([
            'first_name',
            'second_name',
            'first_surname',
            'second_surname',
            'sex',
            'document_type',
            'document_number',
            'birthdate',
            'description',
            'department_id',
            'city_id',
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

        LivewireAlert::title('Información Personal Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.personal-info')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }

    public function resetImages(): void
    {
        $this->document_urls = ['front' => null, 'back' => null, 'profile' => null];
    }
}
