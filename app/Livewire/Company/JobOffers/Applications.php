<?php

declare(strict_types=1);

namespace App\Livewire\Company\JobOffers;

use App\Enums\JobStatus;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

final class Applications extends Component
{
    use WithPagination;

    public JobOffer $jobOffer;

    public function updateApplicationStatus(JobApplication $jobApplication, string $status): void
    {
        $status = JobStatus::tryFrom($status);

        /** @var User $user */
        $user = request()->user();

        $company = $user->userable;
        assert($company instanceof Company);

        $jobApplication->update([
            'status' => $status,
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
