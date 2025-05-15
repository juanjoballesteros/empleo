<div>
    <flux:modal name="edit">
        <form wire:submit="update" class="px-4 py-2">
            <h2 class="text-xl text-center mb-2">Editar</h2>

            <div class="sm:flex gap-4 mb-2">
                <div class="flex-1">
                    <flux:input wire:model="program" label="Nombre del programa*" required/>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="semester" label="Ultimo semestre aprobado*" required>
                        <option value="">Seleccionar...</option>
                        @for($i = 1; $i <= 12; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                        @endfor
                    </flux:select>
                </div>

                <div class="flex-1">
                    <flux:select wire:model="type" label="Graduado*" required>
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
                    <flux:input wire:model="licensed" label="Graduado*" required>
                        <flux:select.option value="">Seleccionar...</flux:select.option>
                        <flux:select.option value="Si">Si</flux:select.option>
                        <flux:select.option value="No">No</flux:select.option>
                    </flux:select>
                </div>

                <div class="flex-1">
                    <flux:input type="date" wire:model="date_semester" label="Fecha ultimo semestre cursado*" required/>
                </div>
            </div>

            <div class="sm:flex gap-2 mb-2">
                <div class="flex-1">
                    <flux:select wire:model="department_id" label="Departamento*" required>
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
                        <flux:label>Certificación de la educación superior</flux:label>

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

            <flux:button type="submit" variant="primary">Editar</flux:button>
        </form>
    </flux:modal>
</div>
