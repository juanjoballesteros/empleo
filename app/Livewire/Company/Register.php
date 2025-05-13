<?php

declare(strict_types=1);

namespace App\Livewire\Company;

use App\Enums\Roles;
use App\Models\City;
use App\Models\Company;
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
    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'integer', 'unique:companies,nit'])]
    public int|string $nit;

    #[Validate(['required', 'integer', 'exists:departments,id'])]
    public int $department_id;

    #[Validate(['required', 'integer', 'exists:cities,id'])]
    public int $city_id;

    /**
     * @var Collection<int, Department>
     */
    public Collection $departments;

    /**
     * @var Collection<int, City>|null[]
     */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();
    }

    public function store(): void
    {
        $this->validate();

        /** @var User $user */
        $user = request()->user();

        $company = Company::query()->create($this->only([
            'name',
            'nit',
            'department_id',
            'city_id',
        ]));

        $user->userable()->associate($company)->save();
        $user->assignRole(Roles::EMPRESA);

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
        return view('livewire.company.register');
    }
}
