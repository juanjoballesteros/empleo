<div>
    <div class="bg-white shadow-sm rounded-lg p-4 m-4">
        @include('layouts.wizard.navigation')

        <form wire:submit="store" class="border border-gray-300 rounded-lg px-4 py-2 mb-2">
            <h2 class="text-xl text-center mb-2">Añadir Nuevo</h2>

            <div class="sm:flex gap-4 mb-2">
                <div class="flex-1">
                    <flux:input wire:model="program" label="Nombre del programa*" required/>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="semester" label="Último semestre aprobado*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        @for($i = 1; $i <= 12; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                        @endfor
                    </flux:select>
                </div>

                <div class="flex-1">
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
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:select wire:model="licensed" label="Graduado*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        <flux:select.option value="Si">Si</flux:select.option>
                        <flux:select.option value="No">No</flux:select.option>
                    </flux:select>
                </div>

                <div class="flex-1">
                    <flux:input type="date" wire:model="date_semester" label="Fecha último semestre cursado*" required/>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:select wire:model="department_id" wire:change="updateCities" label="Departamento*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        @foreach($departments as $department)
                            <flux:select.option value="{{ $department->id }}">
                                {{ $department->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="city_id" label="Ciudad*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        @foreach($cities as $city)
                            <flux:select.option value="{{ $city->id }}">{{ $city->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:field>
                        <flux:label>Certificado</flux:label>

                        <flux:input.group>
                            <flux:input type="file" wire:model="certification" accept="image/*"/>

                            <flux:button type="button" icon="camera"
                                         @click="$dispatch('openCamera', { id: $wire.id, file: 'certification' })"/>
                        </flux:input.group>
                    </flux:field>
                </div>
            </div>

            @if ($certification)
                <img src="{{ $certification->temporaryUrl() }}" alt="Certificación" class="w-32 p-2 m-auto">
            @endif

            <flux:button type="submit" variant="primary">Añadir</flux:button>

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
                        <th class="p-2">Editar</th>
                        <th class="p-2">Eliminar</th>
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
                                <flux:button icon="pencil" wire:click="$dispatch('edit', {
                                        higherEducation: {{ $higherEducation->id }}
                                    })" size="sm">
                                    Editar
                                </flux:button>
                            </td>
                            <td>
                                <flux:button wire:click="delete({{ $higherEducation->id }})" variant="danger"
                                             icon="trash" size="sm">
                                    Eliminar
                                </flux:button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div
                class="bg-red-300 border border-red-500 text-red-800 font-medium rounded-md p-4 text-center mb-2">
                No ha agregado educación superior
            </div>
        @endif

        <livewire:cv.steps.higher-education.edit/>
        @include('layouts.wizard.footer')
    </div>
</div>
