<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Dashboard extends Component
{
    public ?Cv $cv = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $search;

    public function mount(): void
    {
        /** @var User $user */
        $user = request()->user();

        $userable = $user->userable;

        if ($userable instanceof Candidate) {
            $this->cv = $user->cv()->firstOrCreate(['candidate_id' => $userable->id]);
        }
    }

    public function send(): void
    {
        $this->validate();

        $this->redirect("offers?search=$this->search", true);
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
