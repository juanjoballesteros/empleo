<?php

declare(strict_types=1);

namespace App\Livewire\Company\JobOffers;

use App\Enums\JobStatus;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Flux\Flux;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

final class Applications extends Component
{
    use WithPagination;

    public JobOffer $jobOffer;

    #[Validate(['required', 'string', 'min:20', 'max:255'])]
    public ?string $notes = null;

    public function updateApplicationStatus(JobApplication $jobApplication, string $status): void
    {
        $status = JobStatus::tryFrom($status);

        /** @var User $user */
        $user = request()->user();

        if ($status === JobStatus::REJECTED) {
            $this->validate();
            Flux::modal('notes')->close();
        }

        $company = $user->userable;
        assert($company instanceof Company);

        $jobApplication->update([
            'status' => $status,
            'notes' => $this->notes,
        ]);

        LivewireAlert::title('Estado de la aplicación actualizado correctamente.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        $jobApplications = $this->jobOffer->jobApplications()->paginate();

        return view('livewire.company.job-offers.applications', [
            'jobApplications' => $jobApplications,
        ]);
    }
}
