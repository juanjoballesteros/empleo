<div>
    <x-auth-header title="Registrate como candidato" description="Termina tu registro"/>

    <form wire:submit="store" class="flex flex-col gap-4">
        <h3 class="text-lg text-center">Por favor verifica los datos y completa los campos</h3>

        <flux:input wire:model="identification" label="Nº Identificación" required/>

        <flux:select wire:model.live="department_id" label="Departamento" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            @foreach(App\Models\Department::all() as $department)
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

        <flux:button type="submit" variant="primary" color="blue" class="w-full">
            Confirmar Datos
        </flux:button>
    </form>
</div>
