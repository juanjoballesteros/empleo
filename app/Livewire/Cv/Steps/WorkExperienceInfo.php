<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class WorkExperienceInfo extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'bool'])]
    public bool $actual;

    #[Validate(['nullable', 'date', 'required_if:actual,false'])]
    public ?string $date_end = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $post;

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    #[Validate(['required', 'numeric', 'digits:10', 'starts_with:3'])]
    public string $phone;

    #[Validate(['required', 'string', 'max:255'])]
    public string $address;

    #[Validate(['required', 'numeric'])]
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    #[Validate(['required', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    /** @var Collection<int, WorkExperience> */
    public Collection $workExperiences;

    /** @var Collection<int, Department> */
    public Collection $departments;

    public function mount(): void
    {
        $this->departments = Department::all();

        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;
    }

    public function store(): void
    {
        $this->validate();

        $workExperience = $this->cv->workExperiences()->create($this->pull([
            'name',
            'date_start',
            'actual',
            'date_end',
            'post',
            'email',
            'phone',
            'address',
            'department_id',
            'city_id',
        ]));

        assert($this->certification instanceof UploadedFile);
        $workExperience->addMedia($this->certification)
            ->preservingOriginal()
            ->toMediaCollection();

        $this->reset(['certification']);

        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function delete(WorkExperience $workExperience): void
    {
        $workExperience->delete();

        LivewireAlert::title('Experiencia Laboral Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('navigate')]
    public function navigate(): void
    {
        $this->redirectRoute('cv.language-info', navigate: true);

        LivewireAlert::title('Progreso Guardado')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('refresh')]
    public function render(): View
    {
        $this->workExperiences = $this->cv->workExperiences()->orderByDesc('date_start')->get();

        return view('livewire.cv.steps.work-experience-info')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }
}
