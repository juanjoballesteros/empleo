<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\WorkExperience;

use App\Models\Cv;
use App\Models\Department;
use Flux\Flux;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

final class Create extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'bool'])]
    public bool $actual;

    #[Validate(['nullable', 'date', 'required_if:actual,false'])]
    public ?string $date_end = null;

    #[Validate(['required', 'string', 'max:255'])]
    public string $post;

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    #[Validate(['required', 'numeric', 'digits:10', 'starts_with:3'])]
    public string $phone;

    #[Validate(['required', 'string', 'max:255'])]
    public string $address;

    #[Validate(['required', 'numeric'])]
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    #[Validate(['required', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    public bool $open = false;

    public function analyzeImage(): void
    {
        $this->validate([
            'certification' => ['required', 'image'],
        ]);

        $schema = new ObjectSchema(
            'certification_data',
            'The data extracted from the certification image',
            [
                new StringSchema('name', 'the name of the company that dispatch the certification'),
                new StringSchema('date_end', 'la fecha cuando el colaborador termino de trabajar en la empresa en formato: dd-mm-yyyy'),
                new StringSchema('post', 'el puesto o cargo que tenia el colaborador'),
                new StringSchema('email', 'el correo electrónico de la empresa'),
                new StringSchema('email', 'el numero telefónico de la empresa'),
                new NumberSchema('phone', 'el numero telefónico de la empresa'),
                new StringSchema('address', 'la dirección física de la empresa'),
                new StringSchema('department_id', 'el departamento donde se expide el certificado con el código de el DANE'),
                new StringSchema('city_id', 'el departamento donde se expide el certificado con el código de el DANE'),
            ]
        );

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-flash-lite')
            ->withSchema($schema)
            ->withPrompt('Extract the data of the laboral certification', [Image::fromLocalPath($this->certification?->getRealPath())])
            ->asStructured();

        $data = $response->structured;

        if (! isset($data['name'], $data['post'])) {
            LivewireAlert::title('No pudimos sacar la información de la imagen por favor ingrese los datos manualmente')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            $this->open = true;

            return;
        }

        if (isset($data['date_end']) && $date = Carbon::createFromFormat('d-m-Y', $data['date_end'])) {
            $this->date_end = $date->toDateString();
        }

        $this->fill($data);
        $this->open = true;
        $this->actual = false;
        $this->js('changeActual', false);
    }

    public function store(): void
    {
        $this->validate();

        $workExperience = $this->cv->workExperiences()->create($this->pull([
            'name',
            'date_start',
            'actual',
            'date_end',
            'post',
            'email',
            'phone',
            'address',
            'department_id',
            'city_id',
        ]));

        assert($this->certification instanceof UploadedFile);
        $workExperience->addMedia($this->certification)
            ->preservingOriginal()
            ->toMediaCollection();

        $this->cv->work = true;
        $this->cv->save();

        $this->reset(['certification']);
        $this->open = false;

        $this->dispatch('work.create');
        Flux::modal('create')->close();
        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.work-experience.create', [
            'departments' => Department::all(),
        ]);
    }
}
