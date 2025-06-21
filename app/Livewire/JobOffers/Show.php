<?php

declare(strict_types=1);

namespace App\Livewire\JobOffers;

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

final class Show extends Component
{
    public JobOffer $jobOffer;

    public bool $hasApplied = false;

    #[On('job-offer.change')]
    public function changeJobOffer(JobOffer $jobOffer): void
    {
        $this->jobOffer = $jobOffer;

        /** @var User $user */
        $user = request()->user();

        $candidate = $user->userable;
        assert($candidate instanceof Candidate);

        $this->hasApplied = $candidate->jobApplications()->where('job_offer_id', $jobOffer->id)->exists();
    }

    public function applyForJob(): void
    {
        /** @var User $user */
        $user = request()->user();

        $candidate = $user->userable;
        assert($candidate instanceof Candidate);

        if ($this->hasApplied) {
            LivewireAlert::title('Ya has aplicado a esta oferta')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            return;
        }

        $candidate->jobApplications()->create([
            'job_offer_id' => $this->jobOffer->id,
            'company_id' => $this->jobOffer->company_id,
        ]);

        $this->hasApplied = true;

        LivewireAlert::title('Te has postulado exitosamente a esta oferta.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.job-offers.show');
    }
}
