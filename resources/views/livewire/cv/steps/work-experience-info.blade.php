<div>
    <div class="bg-white shadow-sm rounded-lg p-4 m-4">
        @include('layouts.wizard.navigation')

        <form wire:submit="store" class="border border-gray-300 rounded-lg px-4 py-2 mb-2">
            <h2 class="text-xl text-center mb-2">Añadir Nuevo</h2>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:input wire:model="name" label="Nombre de la entidad*" required/>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="type" label="Tipo de entidad*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        <flux:select.option value="Publica">Publica</flux:select.option>
                        <flux:select.option value="Privada">Privada</flux:select.option>
                    </flux:select>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:input type="email" wire:model="email" label="Correo de la entidad*" required/>
                </div>

                <div class="flex-1">
                    <flux:input type="tel" wire:model="phone_number" label="Teléfono de la entidad*" required/>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:select wire:model="actual" label="Es trabajo actual*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        <flux:select.option value="Si">Si</flux:select.option>
                        <flux:select.option value="No">No</flux:select.option>
                    </flux:select>
                </div>

                <div class="flex-1">
                    <flux:input type="date" wire:model="date_start" label="Fecha ingreso*" required/>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:input type="date" wire:model="date_end" label="Fecha de retiro*" required/>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="cause" label="Causa de retiro*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        <flux:select.option value="Abandono del cargo">Abandono del cargo</flux:select.option>
                        <flux:select.option value="Cese de actividades del empleador por más de 120 dias">Cese de
                            actividades del empleador por más de 120 dias
                        </flux:select.option>
                        <flux:select.option value="Clausura definitiva del establecimiento o supresión del cargo">
                            Clausura definitiva del establecimiento o supresión del cargo
                        </flux:select.option>
                        <flux:select.option value="Decisión unilateral o declaración de insubsistencia">Decisión
                            unilateral o declaración de insubsistencia
                        </flux:select.option>
                        <flux:select.option value="Jubilación o pensión de invalidez">Jubilación o pensión de
                            invalidez
                        </flux:select.option>
                        <flux:select.option
                            value="Justa causa por parte del empleador o incumplimiento del contratista">Justa causa por
                            parte del empleador o incumplimiento del contratista
                        </flux:select.option>
                        <flux:select.option
                            value="Justa causa por parte del trabajador o incumplimiento del contratante">Justa causa
                            por parte del trabajador o incumplimiento del contratante
                        </flux:select.option>
                        <flux:select.option value="Por mutuo acuerdo">Por mutuo acuerdo</flux:select.option>
                        <flux:select.option value="Renuncia voluntaria">Renuncia voluntaria</flux:select.option>
                        <flux:select.option value="Revocatoria o nulidad de nombramiento">Revocatoria o nulidad de
                            nombramiento
                        </flux:select.option>
                        <flux:select.option value="Sentencia ejecutoria">Sentencia ejecutoria</flux:select.option>
                        <flux:select.option value="Terminación de la obra, del plazo del contrato o vencimiento">
                            Terminación de la obra, del plazo del contrato o vencimiento
                        </flux:select.option>
                    </flux:select>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:input wire:model="address" label="Dirección de la entidad*" required/>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:input wire:model="post" label="Cargo*" required/>
                </div>

                <div class="flex-1">
                    <flux:input wire:model="dependency" label="Dependencia*" required/>
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

            <flux:button type="submit" variant="primary">Subir</flux:button>

            <livewire:camera/>
        </form>

        @if($workExperiences->count())
            <div class="border border-gray-300 rounded-md overflow-x-auto my-2">
                <table class="table-auto min-w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-300">
                    <tr>
                        <th class="p-2">Nombre de la institución</th>
                        <th class="p-2">Cargo</th>
                        <th class="p-2">Fecha de inicio</th>
                        <th class="p-2">Fecha de retiro</th>
                        <th class="p-2">Certificado</th>
                        <th class="p-2">Editar</th>
                        <th class="p-2">Eliminar</th>
                    </thead>

                    <tbody>
                    @foreach($workExperiences as $workExperience)
                        <tr>
                            <td class="p-2">{{ $workExperience->name }}</td>
                            <td class="p-2">{{ $workExperience->post }}</td>
                            <td class="p-2">{{ $workExperience->date_start->format('d-m-Y') }}</td>
                            <td class="p-2">{{ $workExperience->date_end->format('d-m-Y') }}</td>
                            <td class="p-2">
                                <flux:button href="{{ $workExperience->getFirstMediaUrl() }}"
                                             target="_blank" icon="photo" size="sm">
                                    Ver certificado
                                </flux:button>
                            </td>
                            <td>
                                <flux:button icon="pencil" wire:click="$dispatch('edit', {
                                        workExperience: {{ $workExperience->id }}
                                    })" size="sm">
                                    Editar
                                </flux:button>
                            </td>
                            <td>
                                <flux:button wire:click="delete({{ $workExperience->id }})" variant="danger"
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
                No ha agregado experiencia laboral
            </div>
        @endif

        <livewire:cv.steps.work-experience.edit/>
        @include('layouts.wizard.footer')
    </div>
</div>
