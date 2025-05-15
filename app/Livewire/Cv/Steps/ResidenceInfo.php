<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class ResidenceInfo extends Component
{
    public Cv $cv;

    #[Validate(['required', 'numeric'])]
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    #[Validate(['required', 'string', 'max:255'])]
    public string $address;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|list<null> */
    public Collection|array $cities = [];

    public function mount(Cv $cv): void
    {
        $this->departments = Department::all();

        if ($residenceInfo = $cv->residenceInfo) {
            $this->cities = $residenceInfo->department->cities;
            $this->fill($residenceInfo);
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.create.basic-education-info', $this->cv->id, navigate: true);

        $this->cv->residenceInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->only([
            'address',
            'department_id',
            'city_id',
        ]));

        LivewireAlert::title('Información De Residencia Guardada')
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
        return view('livewire.cv.steps.residence-info');
    }
}
