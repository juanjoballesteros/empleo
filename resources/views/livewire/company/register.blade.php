<div>
    <x-auth-header title="Registrate como empresa" description="Completa los campos para registrarte"/>

    <form wire:submit="store" class="flex flex-col gap-6 mt-6">
        <flux:input wire:model="name" label="Nombre o razón social de la empresa" autofocus required/>

        <flux:input wire:model="nit" label="Nit" required/>

        <flux:select wire:change="updateCities" wire:model="department_id" label="Departamento" required>
            <flux:select.option>Seleccionar...</flux:select.option>
            @foreach($departments as $department)
                <flux:select.option value="{{ $department->id }}">
                    {{ $department->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model="city_id" label="Municipio" required>
            <flux:select.option>Seleccionar...</flux:select.option>
            @foreach($cities as $city)
                <flux:select.option value="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:button type="submit" variant="primary" class="w-full">
            Registrarme
        </flux:button>
    </form>
</div>
