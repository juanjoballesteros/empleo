<div>
    <x-auth-header title="Registrate como empresa" description="Completa los campos para terminar el registro"/>

    <form wire:submit="store" class="flex flex-col gap-6 mt-6">
        <flux:input wire:model="nit" label="Nit" required autofocus/>

        <flux:select wire:model.live="department_id" label="Departamento" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            @foreach(App\Models\Department::all() as $department)
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

        <flux:button type="submit" variant="primary" class="w-full">
            Registrarme
        </flux:button>
    </form>
</div>
