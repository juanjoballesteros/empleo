<?php

declare(strict_types=1);

namespace App\Livewire\Company\JobOffers;

use App\Models\Company;
use App\Models\User;
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
        /** @var User $user */
        $user = request()->user();
        $company = $user->userable;
        assert($company instanceof Company);

        $jobOffers = $company->jobOffers()
            ->when($this->search, fn (Builder $q) => $q->whereLike('title', '%'.$this->search.'%'))
            ->get();

        return view('livewire.company.job-offers.index', ['jobOffers' => $jobOffers]);
    }
}
