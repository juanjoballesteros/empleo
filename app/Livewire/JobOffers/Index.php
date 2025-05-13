<?php

declare(strict_types=1);

namespace App\Livewire\JobOffers;

use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Builder;
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
            ->when($this->search, fn (Builder $q, $search) => $q->whereLike('title', '%'.$search.'%'))->get();

        return view('livewire.job-offers.index', [
            'jobOffers' => $jobOffers,
        ]);
    }
}
