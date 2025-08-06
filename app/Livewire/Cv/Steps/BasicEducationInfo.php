<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class BasicEducationInfo extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $level;

    #[Validate(['required', 'string', 'max:255'])]
    public string $program;

    #[Validate(['required', 'date'])]
    public string $end_date;

    public ?TemporaryUploadedFile $certification = null;

    public string $certification_url;

    /** @return array<string, list<string|RequiredIf>> */
    public function rules(): array
    {
        return [
            'certification' => ['nullable', Rule::requiredIf(! isset($this->certification_url)), 'file', 'image'],
        ];
    }

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($basicEducationInfo = $this->cv->basicEducationInfo) {
            $this->fill($basicEducationInfo);
            $this->end_date = $basicEducationInfo->end_date->format('Y-m-d');
            $this->certification_url = $basicEducationInfo->getFirstMediaUrl();
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.higher-education-info', navigate: true);

        $basicEducationInfo = $this->cv->basicEducationInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->only([
            'program',
            'level',
            'end_date',
        ]));

        if ($this->certification instanceof TemporaryUploadedFile) {
            if ($certification = $basicEducationInfo->getFirstMedia()) {
                $certification->delete();
            }

            $basicEducationInfo->addMedia($this->certification)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        LivewireAlert::title('Información De Educación Básica Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.basic-education-info');
    }
}
