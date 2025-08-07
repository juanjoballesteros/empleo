<?php

declare(strict_types=1);

namespace App\Livewire\Company\JobOffers;

use App\Models\City;
use App\Models\Department;
use App\Models\JobOffer;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Edit extends Component
{
    public JobOffer $jobOffer;

    #[Validate(['required', 'string', 'max:255'])]
    public string $title = '';

    #[Validate(['required', 'string'])]
    public string $description = '';

    #[Validate(['required', 'string'])]
    public string $requirements = '';

    #[Validate(['required', 'integer'])]
    public int $salary;

    #[Validate(['required', 'string', 'max:255'])]
    public string $type;

    #[Validate(['required', 'string', 'max:255'])]
    public string $location;

    #[Validate(['nullable', 'required_if:type,Presencial', 'integer'])]
    public ?int $department_id = null;

    #[Validate(['nullable', 'required_if:type,Presencial', 'integer'])]
    public ?int $city_id = null;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|null[] */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();

        $this->fill($this->jobOffer);
    }

    public function update(): void
    {
        $this->validate();

        $this->jobOffer->update($this->only([
            'title',
            'description',
            'requirements',
            'salary',
            'type',
            'location',
            'department_id',
            'city_id',
        ]));

        $this->redirectRoute('company.offers.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.company.job-offers.edit');
    }
}
