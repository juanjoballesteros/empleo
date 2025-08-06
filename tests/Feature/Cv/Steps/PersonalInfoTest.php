<?php

declare(strict_types=1);

use App\Livewire\Cv\Steps\PersonalInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('personal info screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = $this->actingAs($user)->get('/cv/personal-info');

    $response->assertStatus(200);
});

it('show alert', function () {
    $this->withSession([
        'error' => 'Error',
    ]);

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = $this->actingAs($user)->get('/cv/personal-info');

    $response->assertSessionHas('error');
});

it('can create personal info', function () {
    Storage::fake('public');

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::actingAs($user)->test(PersonalInfo::class)
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

it('shows validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::actingAs($user)->test(PersonalInfo::class)
        ->set('first_name', '')
        ->set('first_surname', '')
        ->set('second_surname', '')
        ->set('document_number', 'not-a-number')
        ->call('store');

    $response->assertHasErrors([
        'first_name',
        'first_surname',
        'second_surname',
        'sex',
        'document_type',
        'document_number',
    ]);
});

it('can update personal info', function () {
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
