<div>
    @include('layouts.wizard.navigation')

    <h4 class="text-lg text-center mb-2">5. Educación Superior</h4>

    <form wire:submit="store"
          class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-gray-200/50 rounded-sm p-2 mb-2">
        <h3 class="text-xl text-center md:col-span-2">Añadir</h3>

        <flux:input wire:model="program" label="Nombre del programa*" required/>

        <flux:select wire:model="semester" label="Último semestre aprobado*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            @for($i = 12; $i >= 1; $i--)
                <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
            @endfor
        </flux:select>

        <flux:select wire:model="type" label="Modalidad Académica*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            <flux:select.option value="TC">Técnica</flux:select.option>
            <flux:select.option value="TL">Tecnológica</flux:select.option>
            <flux:select.option value="TE">Tecnológica Especializada</flux:select.option>
            <flux:select.option value="UN">Universitaria</flux:select.option>
            <flux:select.option value="ES">Especialización</flux:select.option>
            <flux:select.option value="MG">Maestría</flux:select.option>
            <flux:select.option value="DOC">Doctorado</flux:select.option>
        </flux:select>

        <flux:select wire:model="licensed" label="Graduado*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            <flux:select.option value="Si">Si</flux:select.option>
            <flux:select.option value="No">No</flux:select.option>
        </flux:select>

        <flux:input type="date" wire:model="date_semester" label="Fecha último semestre cursado*" required
                    max="{{ today()->toDateString() }}"/>

        <flux:select wire:model.live="department_id" label="Departamento*" required autofocus>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            @foreach($departments as $department)
                <flux:select.option value="{{ $department->id }}">
                    {{ $department->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="city_id" wire:key="{{ $city_id }}" label="Municipio*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            @foreach(App\Models\City::where('department_id', $department_id)->get() as $city)
                <flux:select.option value="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <div class="md:col-span-2">
            @if($certification)
                <div class="flex flex-col gap-4">
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>

                    <flux:button wire:click="$set('certification', null)" class="w-full">
                        Cambiar Certificado
                    </flux:button>
                </div>
            @else
                <div x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false"
                     x-on:livewire-upload-cancel="uploading = false"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div class="flex flex-col md:flex-row gap-2">
                        <div @click="$dispatch('openCamera', { id: $wire.id, file: 'certification' })"
                             class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                            <flux:icon.camera class="size-8 text-gray-500"/>

                            <p class="text-gray-500">Toma Una Foto Del Certificado</p>
                        </div>

                        <label
                            class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                            <flux:icon.arrow-up-on-square class="size-8 text-gray-500"/>

                            <p class="text-gray-500">Sube Tu Certificado</p>

                            <input type="file" wire:model="certification" name="file" class="hidden" accept="image/*">

                            <flux:error name="file"/>
                        </label>
                    </div>

                    <span wire:loading wire:target="certification" class="text-sm">Cargando...</span>
                    <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
                        <div x-bind:style="'width: ' + progress"
                             class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
                    </div>
                </div>
            @endif
        </div>

        <flux:button type="submit" variant="primary" class="md:col-span-2">Añadir</flux:button>

        <livewire:camera/>
    </form>

    @if($higherEducations->count())
        <div class="border border-gray-300 rounded-md overflow-x-auto my-2">
            <table class="table-auto min-w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-300">
                <tr>
                    <th class="p-2">Modalidad</th>
                    <th class="p-2">Programa</th>
                    <th class="p-2">Semestre</th>
                    <th class="p-2">Fecha de semestre cursado</th>
                    <th class="p-2">Graduado</th>
                    <th class="p-2">Lugar</th>
                    <th class="p-2">Certificado</th>
                    <th class="p-2">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach($higherEducations as $higherEducation)
                    <tr>
                        <td class="p-2">{{ $higherEducation->type }}</td>
                        <td class="p-2">{{ $higherEducation->program }}</td>
                        <td class="p-2">{{ $higherEducation->semester }}</td>
                        <td class="p-2">{{ $higherEducation->date_semester->format('Y-m-d') }}</td>
                        <td class="p-2">{{ $higherEducation->licensed }}</td>
                        <td class="p-2">{{ $higherEducation->city->name }}
                            ({{ $higherEducation->department->name }})
                        </td>
                        <td>
                            <flux:button href="{{ $higherEducation->getFirstMediaUrl() }}"
                                         target="_blank" icon="photo" size="sm">
                                Ver certificado
                            </flux:button>
                        </td>
                        <td class="p-2">
                            <flux:button.group>
                                <flux:button
                                    wire:click="$dispatch('edit', { higherEducation: {{ $higherEducation->id }} })"
                                    icon="pencil" size="sm">
                                    Editar
                                </flux:button>

                                <flux:button wire:click="delete({{ $higherEducation->id }})" variant="danger"
                                             icon="trash" size="sm">
                                    Eliminar
                                </flux:button>
                            </flux:button.group>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado información"/>
    @endif

    <livewire:cv.steps.higher-education.edit/>
    @include('layouts.wizard.footer')
</div>
