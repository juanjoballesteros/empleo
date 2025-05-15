<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Cv\Steps\Language\Edit;
use App\Livewire\Cv\Steps\LanguageInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\LanguageInfo as LanguageInfoModel;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('language info screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get("/cv/{$user->cv->id}/language-info");

    $response->assertOk();
});

it('can be created', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(LanguageInfo::class, ['cv' => $user->cv])
        ->set('name', 'Inglés')
        ->set('write', 'Avanzado')
        ->set('speak', 'Intermedio')
        ->set('read', 'Avanzado')
        ->set('certificate', UploadedFile::fake()->image('certificate.jpg'))
        ->call('store');

    $response->assertHasNoErrors();

    $this->assertDatabaseCount('language_infos', 1);
});

it('show validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(LanguageInfo::class, ['cv' => $user->cv])
        ->set('name', '')
        ->set('write', '')
        ->set('speak', '')
        ->set('read', '')
        ->call('store');

    $response->assertHasErrors([
        'name',
        'write',
        'speak',
        'read',
        'certificate',
    ])->assertNoRedirect();

    $this->assertDatabaseCount('language_infos', 0);
});

it('can be deleted', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(LanguageInfoModel::factory(2)))
        ->create();

    $this->assertDatabaseCount('language_infos', 2);

    $response = Livewire::test(LanguageInfo::class, ['cv' => $user->cv])
        ->call('delete', $user->cv->languageInfos()->first());

    $response->assertNoRedirect();
    $this->assertDatabaseCount('language_infos', 1);
});

test('navigate to next step', function () {
    $response = Livewire::test(LanguageInfo::class, ['cv' => Cv::factory()->create()])
        ->call('navigate');

    $response->assertRedirect('/cv/1/pdf/commercial');
});

it('can be updated', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(LanguageInfoModel::factory(2)))
        ->create();
    $languageInfo = $user->cv->languageInfos->first();
    $languageInfo->addMedia(UploadedFile::fake()->image('certificate_1.jpg'))
        ->toMediaCollection();

    $response = Livewire::test(Edit::class)
        ->call('edit', $languageInfo)
        ->assertSet('name', $languageInfo->name)
        ->assertSet('write', $languageInfo->write)
        ->assertSet('speak', $languageInfo->speak)
        ->assertSet('read', $languageInfo->read)
        ->set('name', 'Francés')
        ->set('write', 'Básico')
        ->set('speak', 'Básico')
        ->set('read', 'Intermedio')
        ->set('certificate', UploadedFile::fake()->image('certificate.jpg'))
        ->call('update');

    $response->assertHasNoErrors()
        ->assertDispatched('refresh');

    Storage::disk('public')->assertExists('2/certificate.jpg')
        ->assertMissing('1/certificate_1.jpg');
});
