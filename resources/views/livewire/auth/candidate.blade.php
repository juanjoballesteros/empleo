<div>
    <x-auth-header title="Registrate Fácil Y Rápido" description=""/>

    @if(!$show)
        <div x-data="{ loading: false }" class="flex flex-col gap-4">
            <h3 class="text-lg text-center">Toma una foto frontal de tu documento</h3>

            <div class="flex flex-col gap-4">
                <div @click="$dispatch('openCamera', { id: $wire.id, file: 'file' })"
                     class="flex flex-col items-center cursor-pointer w-full h-full border-2 border-dashed border-gray-400 rounded-lg p-6">
                    <flux:icon.identification class="size-12 text-gray-500"/>

                    <p class="text-gray-500">Toma Una Foto</p>
                </div>

                <flux:button variant="primary" color="blue" class="w-full" wire:click="$toggle('show')">
                    Poner los datos manualmente
                </flux:button>
            </div>

            <div wire:loading wire:target="file">Cargando...</div>
            <livewire:camera/>
        </div>
    @else
        <form wire:submit="store" class="flex flex-col gap-4">
            <h3 class="text-lg text-center">Por favor verifica los datos y completa los campos</h3>

            <flux:input wire:model="name" label="Nombre Completo" required autofocus/>

            <flux:input wire:model="identification" label="Nº Identificación" required/>

            <flux:input type="email" wire:model="email" label="Correo Electrónico" required/>

            <flux:select wire:model.live="department_id" label="Departamento" required>
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

            <flux:input type="password" wire:model="password" label="Contraseña" required viewable/>

            <flux:input type="password" wire:model="password_confirmation" label="Confirmar Contraseña" required
                        viewable/>

            <flux:button type="submit" variant="primary" color="blue" class="w-full">
                Confirmar Datos
            </flux:button>
        </form>
    @endif
</div>
