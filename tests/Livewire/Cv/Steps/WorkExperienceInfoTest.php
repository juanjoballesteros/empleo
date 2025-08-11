<?php

declare(strict_types=1);

use App\Livewire\Cv\Steps\WorkExperience\Create;
use App\Livewire\Cv\Steps\WorkExperience\Edit;
use App\Livewire\Cv\Steps\WorkExperienceInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

});

test('work experience screen can be rendered', function () {
    $response = $this->actingAs($this->user)->get('/cv/work-experience-info');

    $response->assertOk();
});

test('can check that not have', function () {
    $response = Livewire::actingAs($this->user)->test(WorkExperienceInfo::class)
        ->call('check');

    $response->assertRedirectToRoute('cv.language-info');
    $this->assertDatabaseHas('cvs', [
        'work' => true,
    ]);
});

test('can be created', function () {
    Storage::fake();

    $department = Department::all()->random()->first();

    $response = Livewire::actingAs($this->user)->test(Create::class, ['cv' => $this->user->cv])
        ->set('name', 'Empresa Test')
        ->set('email', 'empresa@test.com')
        ->set('phone', '3001234567')
        ->set('date_start', '2020-01-01')
        ->set('actual', 'No')
        ->set('date_end', '2023-01-01')
        ->set('post', 'Desarrollador')
        ->set('address', 'Calle Principal #123')
        ->set('department_id', $department->id)
        ->set('city_id', $department->cities->random()->first()->id)
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertDispatched('work.create');
    $this->assertDatabaseHas('work_experiences', [
        'name' => 'Empresa Test',
        'email' => 'empresa@test.com',
    ]);
});

test('show validation errors', function () {
    $response = Livewire::actingAs($this->user)->test(Create::class)
        ->set('name', '')
        ->set('email', '')
        ->set('phone', '')
        ->set('date_start')
        ->set('date_end')
        ->set('post', '')
        ->set('address', '')
        ->call('store');

    $response->assertHasErrors([
        'name',
        'email',
        'phone',
        'date_start',
        'post',
        'address',
        'department_id',
        'city_id',
        'certification',
    ])->assertNoRedirect();

    $this->assertDatabaseCount('work_experiences', 0);
});

test('can be deleted', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(WorkExperience::factory(2)))
        ->create();

    $this->assertDatabaseCount('work_experiences', 2);

    $response = Livewire::actingAs($user)->test(WorkExperienceInfo::class)
        ->call('delete', $user->cv->workExperiences()->first());

    $response->assertNoRedirect();
    $this->assertDatabaseCount('work_experiences', 1);
});

test('navigate to next step', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(WorkExperience::factory(2)))
        ->create();

    $response = Livewire::actingAs($user)
        ->test(WorkExperienceInfo::class)
        ->call('navigate');

    $response->assertRedirect('/cv/language-info');
});

test('can be updated', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(WorkExperience::factory(2)))
        ->create();
    $workExperience = $user->cv->workExperiences->first();
    $workExperience->addMedia(UploadedFile::fake()->image('certification_1.jpg'))
        ->toMediaCollection();

    $response = Livewire::actingAs($user)->test(Edit::class)
        ->call('edit', $workExperience)
        ->assertSet('name', $workExperience->name)
        ->assertSet('email', $workExperience->email)
        ->assertSet('phone', $workExperience->phone)
        ->assertSet('date_start', $workExperience->date_start->format('Y-m-d'))
        ->assertSet('actual', $workExperience->actual)
        ->assertSet('date_end', $workExperience->date_end->format('Y-m-d'))
        ->assertSet('post', $workExperience->post)
        ->assertSet('address', $workExperience->address)
        ->assertSet('department_id', $workExperience->department_id)
        ->assertSet('city_id', $workExperience->city_id)
        ->set('name', 'Nueva Empresa')
        ->set('email', 'nueva@empresa.com')
        ->set('phone', '3001234567')
        ->set('date_start', '2020-01-01')
        ->set('actual', 'No')
        ->set('date_end', '2023-01-01')
        ->set('post', 'Desarrollador Senior')
        ->set('address', 'Calle Nueva #456')
        ->set('department_id', $workExperience->department_id)
        ->set('city_id', $workExperience->city_id)
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('update');

    $response->assertHasNoErrors()
        ->assertDispatched('work.edit');

    Storage::disk('public')->assertExists('2/certification.jpg')
        ->assertMissing('1/certification.jpg');
});
