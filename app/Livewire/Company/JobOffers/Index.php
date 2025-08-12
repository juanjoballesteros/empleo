<?php

declare(strict_types=1);

namespace App\Livewire\Company\JobOffers;

use App\Models\Company;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;

final class Index extends Component
{
    #[Url]
    public string $search = '';

    public function delete(JobOffer $jobOffer): void
    {
        $jobOffer->delete();

        LivewireAlert::title('Oferta eliminada correctamente')
            ->info()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        /** @var User $user */
        $user = request()->user();
        $company = $user->userable;
        assert($company instanceof Company);

        $jobOffers = $company->jobOffers()
            ->when($this->search, fn (Builder $q) => $q->whereLike('title', '%'.$this->search.'%'))
            ->paginate();

        return view('livewire.company.job-offers.index', [
            'jobOffers' => $jobOffers,
        ]);
    }
}
