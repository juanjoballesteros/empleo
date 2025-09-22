<?php

declare(strict_types=1);

use App\Livewire\Cv\Steps\PersonalInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Prism\Prism\Prism;
use Prism\Prism\Testing\StructuredResponseFake;

beforeEach(function () {
    $this->user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
});

test('personal info screen can be rendered', function () {

    $response = $this->actingAs($this->user)->get('/cv/personal-info');

    $response->assertStatus(200);
});

test('show alert', function () {
    $this->withSession([
        'error' => 'Error',
    ]);

    $response = $this->actingAs($this->user)->get('/cv/personal-info');

    $response->assertSessionHas('error');
});

test('can create personal info', function () {
    Storage::fake('public');

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('first_name', 'Test')
        ->set('second_name', 'Middle')
        ->set('first_surname', 'Doe')
        ->set('second_surname', 'Smith')
        ->set('sex', 'Masculino')
        ->set('document_type', 'ID')
        ->set('document_number', '12345678')
        ->set('birthdate', '12-12-2012')
        ->set('description', 'Test description')
        ->set('department_id', '13')
        ->set('city_id', '13140')
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->set('profile', UploadedFile::fake()->image('profile.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/contact-info');

    Storage::disk('public')->assertExists('1/front.jpg')
        ->assertExists('2/back.jpg')
        ->assertExists('3/profile.jpg');
});

test('shows validation errors', function () {

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('first_name', '')
        ->set('first_surname', '')
        ->set('document_number', 'not-a-number')
        ->call('store');

    $response->assertHasErrors([
        'first_name',
        'first_surname',
        'sex',
        'document_type',
        'document_number',
    ]);
});

test('can update personal info', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(App\Models\PersonalInfo::factory(['first_name' => 'Test'])))
        ->create();

    $personalInfo = $user->cv->personalInfo;
    $personalInfo->addMedia(UploadedFile::fake()->image('front.jpg'))
        ->toMediaCollection('front');

    $personalInfo->addMedia(UploadedFile::fake()->image('back.jpg'))
        ->toMediaCollection('back');

    $personalInfo->addMedia(UploadedFile::fake()->image('profile.jpg'))
        ->toMediaCollection('profile');

    $response = Livewire::actingAs($user)->test(PersonalInfo::class);

    $response->assertSet('first_name', 'Test')
        ->assertSet('second_name', $personalInfo->second_name)
        ->assertSet('first_surname', $personalInfo->first_surname)
        ->assertSet('second_surname', $personalInfo->second_surname)
        ->assertSet('document_number', $personalInfo->document_number);

    $response->set('first_name', 'Test')
        ->set('second_name', 'Middle')
        ->set('first_surname', 'Doe')
        ->set('second_surname', 'Smith')
        ->set('sex', 'Male')
        ->set('document_type', 'ID')
        ->set('document_number', '12345678')
        ->set('description', 'Test description')
        ->set('document_front', UploadedFile::fake()->image('front_other.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back_other.jpg'))
        ->set('profile', UploadedFile::fake()->image('profile_other.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/contact-info');

    Storage::disk('public')
        ->assertExists('4/front_other.jpg')
        ->assertExists('5/back_other.jpg')
        ->assertExists('6/profile_other.jpg')
        ->assertMissing('1/front.jpg')
        ->assertMissing('2/back.jpg')
        ->assertMissing('3/profile.jpg');
});

test('show error if images are not valid', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'document_type' => 'CC',
            'second_name' => 'Jose',
            'sex' => 'M',
        ]);

    Prism::fake([$fakeResponse]);
    Storage::fake();

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->call('analyzeImage');

    $response->assertSet('show', true)
        ->assertNotSet('document_type', 'CC')
        ->assertNotSet('document_number', '123456789')
        ->assertNotSet('first_name', 'Juan')
        ->assertNotSet('second_name', 'Jose')
        ->assertNotSet('sex', 'Masculino');
});

test('can analyze images', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'document_type' => 'CC',
            'document_number' => '123456789',
            'first_name' => 'Juan',
            'second_name' => 'Jose',
            'birthdate' => '12-12-2012',
            'sex' => 'M',
        ]);

    Prism::fake([$fakeResponse]);
    Storage::fake();

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->call('analyzeImage');

    $response->assertSet('show', true)
        ->assertSet('document_type', 'CC')
        ->assertSet('document_number', '123456789')
        ->assertSet('first_name', 'Juan')
        ->assertSet('second_name', 'Jose')
        ->assertSet('sex', 'Masculino');
});

test('return "Femenino"', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'document_number' => '123456789',
            'first_name' => 'Juan',
            'sex' => 'F',
        ]);

    Prism::fake([$fakeResponse]);
    Storage::fake();

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->call('analyzeImage');

    $response->assertSet('show', true)
        ->assertSet('document_number', '123456789')
        ->assertSet('first_name', 'Juan')
        ->assertSet('sex', 'Femenino');
});

test('return empty string', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'document_number' => '123456789',
            'first_name' => 'Juan',
            'sex' => 'other',
        ]);

    Prism::fake([$fakeResponse]);
    Storage::fake();

    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->call('analyzeImage');

    $response->assertSet('show', true)
        ->assertSet('document_number', '123456789')
        ->assertSet('first_name', 'Juan')
        ->assertSet('sex', '');
});

test('reset images', function () {
    $response = Livewire::actingAs($this->user)->test(PersonalInfo::class)
        ->set('document_front', UploadedFile::fake()->image('front.jpg'))
        ->set('document_back', UploadedFile::fake()->image('back.jpg'))
        ->call('resetImages');

    $response->assertSet('document_front', null)
        ->assertSet('document_back', null)
        ->assertSet('profile', null);
});
