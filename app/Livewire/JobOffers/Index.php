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
