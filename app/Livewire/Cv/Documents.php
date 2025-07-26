<?php

declare(strict_types=1);

namespace App\Livewire\Cv;

use App\Models\Candidate;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\LanguageInfo;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

final class Documents extends Component
{
    public Cv $cv;

    /** @var string[] */
    public array $card = [];

    /** @var list<string> */
    public array $education = [];

    /** @var list<string> */
    public array $work = [];

    /** @var list<string> */
    public array $lenguajes = [];

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);
        $candidate = $user->userable;
        assert($candidate instanceof Candidate);

        $this->cv = $user->cv()->firstOrCreate(['candidate_id' => $candidate->id]);

        if (! $this->cv->isCompleted()) {
            LivewireAlert::title('No has completado tu hoja de vida, completala antes de ver tu carpeta digital')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();

            return;
        }

        if ($personalInfo = $this->cv->personalInfo) {
            $this->card = [
                'front' => $personalInfo->getFirstMediaUrl('front'),
                'back' => $personalInfo->getFirstMediaUrl('back'),
                'profile' => $personalInfo->getFirstMediaUrl('profile'),
            ];
        }

        if ($basicEducationInfo = $this->cv->basicEducationInfo) {
            $this->education = [$basicEducationInfo->getFirstMediaUrl()];
        }

        $this->cv->higherEducations()->each(function (HigherEducation $education): void {
            $this->education[] = $education->getFirstMediaUrl();
        });

        $this->cv->workExperiences()->each(function (WorkExperience $workExperience): void {
            $this->work[] = $workExperience->getFirstMediaUrl();
        });

        $this->cv->languageInfos()->each(function (LanguageInfo $languageInfo): void {
            $this->lenguajes[] = $languageInfo->getFirstMediaUrl();
        });
    }

    public function render(): View
    {
        return view('livewire.cv.documents');
    }
}
