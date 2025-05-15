<div>
    <form wire:submit="store" class="bg-white shadow-sm rounded-lg p-4 m-4">
        @include('layouts.wizard.navigation')

        <div class="sm:flex gap-2 mb-2">
            <div class="flex-1">
                <flux:select wire:model="department_id" wire:change="updateCities" label="Departamento*"
                             required autofocus>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    @foreach($departments as $department)
                        <flux:select.option value="{{ $department->id }}" :selected="$department_id">
                            {{ $department->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex-1">
                <flux:select wire:model="city_id" label="Ciudad*" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    @foreach($cities as $city)
                        <flux:select.option value="{{ $city->id }}" :selected="$city_id">
                            {{ $city->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="sm:flex gap-2 mb-2">
            <div class="flex-1">
                <flux:input wire:model="address" label="Dirección*" required/>
            </div>
        </div>
        
        @include('layouts.wizard.footer')
    </form>
</div>
