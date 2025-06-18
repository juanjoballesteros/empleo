<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

final class Dashboard extends Component
{
    public ?Cv $cv = null;

    public function mount(): void
    {
        /** @var User $user */
        $user = request()->user();

        $userable = $user->userable;

        if ($userable instanceof Candidate) {
            $this->cv = $user->cv()->firstOrCreate(['candidate_id' => $userable->id]);
        }
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
