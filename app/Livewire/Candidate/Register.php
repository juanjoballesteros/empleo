<?php

declare(strict_types=1);

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use App\Models\City;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
final class Register extends Component
{
    #[Validate(['required', 'integer', 'exists:departments,id'])]
    public int $department_id;

    #[Validate(['required', 'integer', 'exists:cities,id'])]
    public int $city_id;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|null[] */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();
    }

    public function store(): void
    {
        /** @var User $user */
        $user = request()->user();

        $candidate = Candidate::query()->create($this->only([
            'department_id',
            'city_id',
        ]));

        $user->userable()->associate($candidate)->save();

        $this->redirectRoute('dashboard', navigate: true);
        LivewireAlert::title('Registrado correctamente')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    // @codeCoverageIgnoreStart
    public function updateCities(): void
    {
        $this->cities = City::query()->where('department_id', $this->department_id)->get();
    }
    // @codeCoverageIgnoreEnd

    public function render(): View
    {
        return view('livewire.candidate.register');
    }
}
