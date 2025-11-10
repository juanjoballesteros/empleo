<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\Language;

use App\Models\Cv;
use App\Models\LanguageInfo;
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

    /** @var Collection<int, LanguageInfo> */
    public Collection $languagesInfos;

    public bool $show = false;

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($this->cv->languageInfos()->exists()) {
            $this->show = true;
        }
    }

    public function delete(LanguageInfo $languageInfo): void
    {
        $languageInfo->delete();

        LivewireAlert::title('Información de Idioma Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function check(): void
    {
        $this->cv->lang = true;
        $this->cv->save();

        $this->redirectRoute('cv.completed');
    }

    #[On('lang.create')]
    #[On('lang.edit')]
    public function render(): View
    {
        $this->languagesInfos = $this->cv->languageInfos ?: collect();

        return view('livewire.cv.steps.language.index')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }
}
