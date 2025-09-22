<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Candidate as CandidateModel;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.auth')]
final class Candidate extends Component
{
    use WithFileUploads;

    #[Validate(['required', 'numeric'])]
    public string|int $identification = '';

    #[Validate(['required', 'integer', 'exists:departments,id'])]
    public int $department_id;

    #[Validate(['required', 'integer', 'exists:cities,id'])]
    public int $city_id;

    public function store(): void
    {
        $this->validate();

        $user = request()->user();
        assert($user instanceof User);

        $candidate = CandidateModel::query()->create($this->only([
            'identification',
            'department_id',
            'city_id',
        ]));

        $user->userable()->associate($candidate)->save();

        $this->redirectRoute('cv.personal-info', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.candidate');
    }
}
