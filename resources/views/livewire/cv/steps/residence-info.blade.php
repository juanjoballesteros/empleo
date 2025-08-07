<div>
    <form wire:submit="store">
        @include('layouts.wizard.navigation')

        <h4 class="text-lg text-center mb-2">3. Información De Residencia</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:select wire:model.live="department_id" label="Departamento de residencia*" required autofocus>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                @foreach($departments as $department)
                    <flux:select.option value="{{ $department->id }}">
                        {{ $department->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="city_id" wire:key="{{ $city_id }}" label="Municipio de residencia*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                @foreach(App\Models\City::where('department_id', $department_id)->get() as $city)
                    <flux:select.option value="{{ $city->id }}">
                        {{ $city->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="address" label="Dirección de residencia*" required/>
        </div>

        @include('layouts.wizard.footer')
    </form>
</div>
