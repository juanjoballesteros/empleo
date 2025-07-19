<?php

declare(strict_types=1);

namespace App\Livewire\Candidate;

use App\Enums\Roles;
use App\Models\Candidate;
use App\Models\City;
use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

#[Layout('components.layouts.auth')]
final class Register extends Component
{
    use WithFileUploads;

    public bool $show = false;

    public ?TemporaryUploadedFile $file = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'numeric'])]
    public string|int $identification = '';

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    #[Validate(['required', 'integer', 'exists:departments,id'])]
    public int $department_id;

    #[Validate(['required', 'integer', 'exists:cities,id'])]
    public int $city_id;

    #[Validate(['required', 'string', 'max:255'])]
    public string $password = '';

    public string $password_confirmation = '';

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|null[] */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();
    }

    // @codeCoverageIgnoreStart
    public function updateCities(): void
    {
        $this->cities = City::query()->where('department_id', $this->department_id)->get();
    }
    // @codeCoverageIgnoreEnd

    #[On('photoTaken')]
    public function analyzeImage(): void
    {
        $this->validate([
            'file' => ['required', 'image'],
        ]);

        $schema = new ObjectSchema(
            'document_image_review',
            'This is a document image review. Please review the image and provide the data',
            [
                new StringSchema('names', 'The names in the card, can be 1 word or 2 words', true),
                new StringSchema('last_names', 'The last names in the card, can be 1 word or 2 words', true),
                new StringSchema('identification', 'The identification number without points or comas', true),
            ]
        );

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-flash-lite-preview-06-17')
            ->withSchema($schema)
            ->withPrompt('Analyze this image', [Image::fromUrl($this->file?->temporaryUrl())])
            ->asStructured();
        $data = $response->structured;

        if (! isset($data['names']) || ! isset($data['last_names']) || ! isset($data['identification'])) {
            LivewireAlert::title('No hemos identificado los datos, vuelve a intentar o ponlos manualmente')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            return;
        }

        $this->name = $data['names'].' '.$data['last_names'];
        $this->identification = $data['identification'];
        $this->show = true;
    }

    public function store(): void
    {
        $this->validate();

        $user = User::query()->create($this->only([
            'name',
            'email',
            'password',
        ]));

        event(new Registered($user));

        $candidate = Candidate::query()->create($this->only([
            'identification',
            'department_id',
            'city_id',
        ]));

        if ($this->file instanceof TemporaryUploadedFile) {
            $candidate->addMedia($this->file)
                ->toMediaCollection();
        }

        $user->userable()->associate($candidate)->save();
        $user->assignRole(Roles::CANDIDATO);

        Auth::login($user);
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.candidate.register');
    }
}
