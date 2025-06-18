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
