<?php

declare(strict_types=1);

use App\Livewire\Cv\Import;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

test('can be rendered', function () {
    $response = $this->get('cv/import');

    $response->assertOk();
});

test('can import files', function () {
    Excel::fake();
    Storage::fake();

    $response = Livewire::test(Import::class)
        ->set('file', UploadedFile::fake()->create('file.xlsx'))
        ->call('import');

    $response->assertOk();
});
