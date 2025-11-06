<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\Cv;
use App\Models\Department;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Media\Image;

final class Create extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $program;

    #[Validate(['required', 'string', 'max:255'])]
    public string $institution;

    #[Validate(['required', 'string', 'max:255'])]
    public string $type;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'bool'])]
    public bool $actual = false;

    #[Validate(['nullable', 'date', 'after:date_start'])]
    public ?string $date_end = null;

    #[Validate(['nullable', 'required_if:actual,true', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    public bool $open = false;

    public function analyzeImage(): void
    {
        $this->validate([
            'certification' => ['required', 'image'],
        ]);

        $schema = new ObjectSchema(
            'certification_data',
            'Certification Data Extracted From Image',
            [
                new StringSchema('program', 'Program or name of the certification'),
                new StringSchema('institution', 'Institution or name of the certification'),
                new StringSchema('date_end', 'Date expedition of the certification in format (00-00-0000, d-m-Y)'),
            ]
        );

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.5-flash-lite')
            ->withSchema($schema)
            ->withPrompt('Get the data of this certification image', [Image::fromLocalPath($this->certification?->getRealPath() ?? '')])
            ->asStructured();

        $data = $response->structured;

        if (! isset($data['program'], $data['institution'], $data['date_end'])) {
            LivewireAlert::title('Hemos tenido para identificar los datos del certificado, por favor ingrese los datos manualmente')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            $this->open = true;

            return;
        }

        $this->fill($data);
        $this->open = true;
        $this->actual = true;
        $this->js('changeActual', $this->actual);

        if (($date = Carbon::createFromFormat('d-m-Y', $data['date_end'])) instanceof Carbon) {
            $this->date_end = $date->toDateString();
        }
    }

    public function store(): void
    {
        $this->validate();

        $higherEducation = $this->cv->higherEducations()->create($this->pull([
            'program',
            'institution',
            'type',
            'date_start',
            'actual',
            'date_end',
        ]));

        if ($this->certification instanceof TemporaryUploadedFile) {
            $higherEducation->addMedia($this->certification)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        $this->cv->high = true;
        $this->cv->save();

        $this->dispatch('high.create');
        $this->reset(['certification']);

        LivewireAlert::title('Información Añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
        Flux::modal('create')->close();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.higher-education.create', [
            'departments' => Department::all(),
        ]);
    }
}
