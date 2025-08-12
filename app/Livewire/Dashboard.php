<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\Cv;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Dashboard extends Component
{
    public ?Cv $cv = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $search;

    private Company|Candidate|null $userable = null;

    public function mount(): void
    {
        /** @var User $user */
        $user = request()->user();

        $this->userable = $user->userable;

        if ($this->userable instanceof Candidate) {
            $this->cv = $user->cv()->firstOrCreate(['candidate_id' => $this->userable->id]);
        }
    }

    public function send(): void
    {
        $this->validate();

        $this->redirect("offers?search=$this->search", true);
    }

    public function render(): View
    {
        if ($this->userable instanceof Company) {
            $offers = $this->userable->jobOffers()->paginate();

            $applications = $offers->flatMap(fn (JobOffer $offer) => $offer->jobApplications()->get());
        }

        return view('livewire.dashboard', [
            'offers' => $offers ?? [],
            'applications' => $applications ?? [],
        ]);
    }
}
