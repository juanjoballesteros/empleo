<?php

declare(strict_types=1);

namespace App\Livewire\JobOffers;

use App\Models\JobOffer;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Show extends Component
{
    public ?JobOffer $jobOffer = null;

    #[On('job-offer.change')]
    public function changeJobOffer(JobOffer $jobOffer): void
    {
        $this->jobOffer = $jobOffer;
    }

    public function render(): View
    {
        return view('livewire.job-offers.show');
    }
}
