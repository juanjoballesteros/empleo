<?php

declare(strict_types=1);

use App\Livewire\Camera;
use Livewire\Livewire;

test('can render component', function () {
    Livewire::test(Camera::class)
        ->assertOk();
});

test('can open camera', function () {
    Livewire::test(Camera::class)
        ->call('openCamera', '123', 'photo')
        ->assertSet('idComponent', '123')
        ->assertSet('file', 'photo');
});

test('can stop camera', function () {
    Livewire::test(Camera::class)
        ->call('stopCamera')
        ->assertDispatched('stopCamera');
});
