<?php

declare(strict_types=1);

namespace App\Livewire\Cv;

use App\Imports\CvImport;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\HeadingRowImport;

final class Import extends Component
{
    use WithFileUploads;

    /** @var Collection<int, Collection<int, string>> */
    public Collection $headings;

    /** @var Collection<int, Collection<int, list<string>>> */
    public Collection $data;

    #[Validate(['required', 'file', 'mimes:xlsx,xls', 'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])]
    public ?TemporaryUploadedFile $file = null;

    // @codeCoverageIgnoreStart
    public function import(): void
    {
        $this->validate();
        $headings = (new HeadingRowImport)->toCollection($this->file);
        if ($headings->isEmpty()) {
            LivewireAlert::title('No se encontró información para importar del archivo por favor verífica el archivo')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();

            $this->reset(['file']);

            return;
        }
        $this->headings = $headings[0][0]->map(fn (string $heading) => str_replace('_', ' ', mb_strtolower($heading)));

        $collection = (new CvImport)->toCollection($this->file);
        if ($collection->isEmpty() || $collection[0]->isEmpty()) {
            LivewireAlert::title('No se encontró información para importar del archivo por favor verífica el archivo')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();

            $this->reset(['file']);

            return;
        }

        $this->data = $collection->flatMap(fn (Collection $row): Collection => $row);
    }
    // @codeCoverageIgnoreEnd

    public function render(): View
    {
        return view('livewire.cv.import');
    }
}
