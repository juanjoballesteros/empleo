<div>
    <div class="border border-gray-300 rounded-md p-4">
        <h2 class="text-2xl font-bold text-center mb-2">Editar Oferta De Empleo</h2>

        <form wire:submit="update" class="flex flex-col gap-6">
            <flux:input wire:model="title" label="Titulo de la oferta" autofocus required/>

            <flux:textarea wire:model="description" label="Descripción de la oferta" required/>

            <flux:textarea wire:model="requirements" label="Requerimientos" required/>

            <flux:input wire:model="salary" label="Salario" required/>

            <flux:select wire:model="type" label="Tipo de oferta" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option>Indefinido</flux:select.option>
                <flux:select.option>Temporal</flux:select.option>
                <flux:select.option>Por Proyecto</flux:select.option>
            </flux:select>

            <flux:select wire:model="location" label="Ubicación">
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option>Remoto</flux:select.option>
                <flux:select.option>Presencial</flux:select.option>
            </flux:select>

            <div x-show="$wire.location === 'Presencial'">
                <flux:select wire:model.live="department_id" label="Departamento" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    @foreach($departments as $department)
                        <flux:select.option value="{{ $department->id }}">
                            {{ $department->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="city_id" wire:key="{{ $city_id }}" label="Municipio" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    @foreach(App\Models\City::where('department_id', $department_id)->get() as $city)
                        <flux:select.option value="{{ $city->id }}">
                            {{ $city->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:button type="submit" variant="primary" class="ms-auto">
                Editar
            </flux:button>
        </form>
    </div>
</div>
