<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Company as CompanyModel;
use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
final class Company extends Component
{
    public string $name = '';

    public int|string $nit;

    public int $department_id;

    public int $city_id;

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function store(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'integer', 'unique:companies,nit'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        $company = CompanyModel::query()->create($this->only([
            'name',
            'nit',
            'department_id',
            'city_id',
        ]));

        $user->userable()->associate($company)->save();

        $this->redirectRoute('dashboard', navigate: true);
        LivewireAlert::title('Registrado correctamente')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.auth.company', [
            'departments' => Department::all(),
        ]);
    }
}
