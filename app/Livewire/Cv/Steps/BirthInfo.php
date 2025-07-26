<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class BirthInfo extends Component
{
    public Cv $cv;

    #[Validate(['required', 'date'])]
    public string $birthdate;

    #[Validate(['required', 'numeric'])]
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int,City>|list<null> */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();

        $user = request()->user();
        assert($user instanceof User);
        $this->cv = $user->cv;
        $cv = $user->cv;

        if ($birthInfo = $cv->birthInfo) {
            $this->fill($birthInfo);
            $this->cities = $birthInfo->department->cities;
            $this->birthdate = $birthInfo->birthdate->format('Y-m-d');
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.create.contact-info', navigate: true);

        $this->cv->birthInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->only([
            'birthdate',
            'department_id',
            'city_id',
        ]));

        LivewireAlert::title('Información De Nacimiento Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    // @codeCoverageIgnoreStart
    public function updateCities(): void
    {
        $department = Department::query()->findOrFail($this->department_id);
        $this->cities = $department->cities()->get();
    }

    // @codeCoverageIgnoreEnd
    public function render(): View
    {
        return view('livewire.cv.steps.birth-info');
    }
}
