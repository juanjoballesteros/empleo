<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Company as CompanyModel;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
final class Company extends Component
{
    public int|string $nit;

    public int $department_id;

    public int $city_id;

    public function store(): void
    {
        $this->validate([
            'nit' => ['required', 'integer', 'unique:companies,nit'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
        ]);

        $user = request()->user();
        assert($user instanceof User);

        $company = CompanyModel::query()->create($this->only([
            'name',
            'nit',
            'department_id',
            'city_id',
        ]));

        $user->userable()->associate($company)->save();

        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.company');
    }
}
