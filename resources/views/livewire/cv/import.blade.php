<div>
    @if(!$data)
        <form wire:submit="import" class="flex flex-col gap-4">
            <h2 class="text-2xl text-center">Importa Información</h2>

            @if(!$file)
                <div x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false"
                     x-on:livewire-upload-cancel="uploading = false"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <label
                        class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                        <flux:icon.arrow-up-on-square class="size-8 text-gray-500"/>

                        <p class="text-gray-500">Sube Tu Archivo</p>

                        <input type="file" wire:model="file" name="file" class="hidden" accept=".xls, .xlsx">
                    </label>

                    <flux:error name="file"/>
                    <span wire:loading wire:target="file" class="text-sm">Cargando...</span>
                    <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
                        <div x-bind:style="'width: ' + progress"
                             class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-4">
                    <flux:callout variant="success" icon="check-circle">
                        <flux:callout.heading>
                            ¡Archivo <b>{{ $file->getClientOriginalName() }}</b> Cargado Exitosamente!
                        </flux:callout.heading>
                    </flux:callout>

                    <flux:button variant="primary" color="blue" type="submit">
                        Importar Datos
                    </flux:button>
                </div>
            @endif
        </form>
    @else
        <div class="flex flex-col gap-4">
            <h2 class="text-2xl text-center">Información A Subir</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        @foreach($headings as $heading)
                            <th class="py-3 px-6 text-left">{{ $heading }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                    @foreach($data as $row)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            @foreach($row as $key => $value)
                                @php
                                    if(str_contains($key, 'fecha')) {
                                        $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('d/m/Y');
                                    }
                                @endphp

                                <td class="py-4 px-6">
                                    {{ $value }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
