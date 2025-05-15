<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class ContactInfo extends Component
{
    public Cv $cv;

    #[Validate(['required', 'numeric', 'digits:10', 'starts_with:3'])]
    public string $phone_number;

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    public function mount(Cv $cv): void
    {
        if ($contactInfo = $cv->contactInfo) {
            $this->fill($contactInfo);
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->redirectRoute('cv.create.residence-info', $this->cv->id, navigate: true);

        $this->cv->contactInfo()->updateOrCreate(['cv_id' => $this->cv->id], $this->only([
            'phone_number',
            'email',
        ]));

        LivewireAlert::title('Información De Contacto Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.contact-info');
    }
}
