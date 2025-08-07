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

    public function mount(): void
    {
        $this->departments = Department::all();

        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;

        if ($residenceInfo = $this->cv->residenceInfo) {
            $this->cities = $residenceInfo->department->cities;
            $this->fill($residenceInfo);
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.basic-education-info', navigate: true);

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

    public function render(): View
    {
        return view('livewire.cv.steps.residence-info')
            ->layout('components.layouts.cv', [
                'cv' => $this->cv,
            ]);
    }
}
