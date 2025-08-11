<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\WorkExperience;

use App\Models\Cv;
use App\Models\Department;
use Flux\Flux;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class Create extends Component
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

        $this->cv->work = true;
        $this->cv->save();

        $this->reset(['certification']);

        $this->dispatch('work.create');
        Flux::modal('create')->close();
        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.work-experience.create', [
            'departments' => Department::all(),
        ]);
    }
}
