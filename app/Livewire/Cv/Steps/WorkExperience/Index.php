<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\WorkExperience;

use App\Models\Cv;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Index extends Component
{
    use WithFileUploads;

    public Cv $cv;

    /** @var Collection<int, WorkExperience> */
    public Collection $workExperiences;

    public bool $show = false;

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($this->cv->workExperiences()->exists()) {
            $this->show = true;
        }
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

    public function check(): void
    {
        $this->cv->work = true;
        $this->cv->save();

        $this->redirectRoute('cv.language-info', navigate: true);
    }

    #[On('work.create')]
    #[On('work.edit')]
    public function render(): View
    {
        $this->workExperiences = $this->cv->workExperiences()->orderByDesc('date_start')->get();

        return view('livewire.cv.steps.work-experience.index')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }
}
