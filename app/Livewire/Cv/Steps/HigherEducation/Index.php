<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\User;
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

    /** @var Collection<int, HigherEducation> */
    public Collection $higherEducations;

    public bool $show = false;

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($this->cv->higherEducations()->exists()) {
            $this->show = true;
        }
    }

    public function delete(HigherEducation $higherEducation): void
    {
        $higherEducation->delete();

        LivewireAlert::title('Educación Superior Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('navigate')]
    public function navigate(): void
    {
        $this->redirectRoute('cv.work-experience-info', navigate: true);

        LivewireAlert::title('Información De Educación Superior Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function check(): void
    {
        $this->cv->high = true;
        $this->cv->save();

        $this->redirectRoute('cv.work-experience-info', navigate: true);
    }

    #[On('high.create')]
    #[On('high.edit')]
    public function render(): View
    {
        $this->higherEducations = $this->cv->higherEducations()
            ->orderByDesc('date_start')
            ->get();

        return view('livewire.cv.steps.higher-education.index')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }
}
