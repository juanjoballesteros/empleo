<?php

declare(strict_types=1);

namespace App\Livewire\JobOffers;

use App\Models\JobOffer;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

final class Index extends Component
{
    #[Url]
    public string $search = '';

    public bool $open = false;

    public function openJobOffer(JobOffer $jobOffer): void
    {
        $this->open = true;
        $this->dispatch('job-offer.change', $jobOffer);
    }

    public function render(): View
    {
        $jobOffers = JobOffer::query()
            ->whereLike('title', '%'.$this->search.'%')
            ->get();

        return view('livewire.job-offers.index', [
            'jobOffers' => $jobOffers,
        ]);
    }
}
