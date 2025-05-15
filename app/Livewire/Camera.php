<?php

declare(strict_types=1);

namespace App\Livewire;

use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Camera extends Component
{
    use WithFileUploads;

    public string|int $idComponent;

    public string $file;

    #[On('openCamera')]
    public function openCamera(string|int $id, string $file): void
    {
        $this->idComponent = $id;
        $this->file = $file;
        $this->js('startCamera');
        Flux::modal('camera')->show();
    }

    public function stopCamera(): void
    {
        $this->js('stopCamera');
        $this->dispatch('stopCamera');
    }

    public function render(): View
    {
        return view('livewire.camera');
    }
}
