<div>
    <flux:modal name="edit" class="md:min-w-4xl">
        <form wire:submit="update" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <h3 class="text-xl text-center md:col-span-2">Editar Experiencia Laboral</h3>

            <flux:input wire:model="name" label="Nombre de la entidad*" required/>
            <flux:input wire:model="post" label="Cargo*" required/>

            <flux:input type="date" wire:model="date_start" label="Fecha ingreso*" required
                        max="{{ today()->toDateString() }}"/>
            <flux:select id="nose" wire:model="actual" x-model="$store.actual" label="Es trabajo actual*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="1">Si</flux:select.option>
                <flux:select.option value="0">No</flux:select.option>
            </flux:select>

            <div x-show="$store.actual == false" x-cloak>
                <flux:input type="date" wire:model="date_end" label="Fecha de retiro*"
                            max="{{ today()->toDateString() }}"/>
            </div>

            <flux:input type="email" wire:model="email" label="Correo de la entidad*" required/>
            <flux:input type="tel" wire:model="phone" label="Teléfono de la entidad*" required/>
            <flux:input wire:model="address" label="Dirección de la entidad*" required/>

            <flux:select wire:model.live="department_id" label="Departamento*" required>
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
                    <flux:select.option value="{{ $city->id }}">{{ $city->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex flex-col gap-4 md:col-span-2">
                <div x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false"
                     x-on:livewire-upload-cancel="uploading = false"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div class="flex flex-col md:flex-row gap-2">
                        <div @click="$dispatch('openCamera', { id: $wire.id, file: 'certification' })"
                             class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                            <flux:icon.camera class="size-8 text-gray-500"/>

                            <p class="text-gray-500">Toma Una Foto Del Certificado</p>
                        </div>

                        <label
                            class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                            <flux:icon.arrow-up-on-square class="size-8 text-gray-500"/>

                            <p class="text-gray-500">Sube Tu Certificado</p>

                            <input type="file" wire:model="certification" name="file" class="hidden" accept="image/*">

                            <flux:error name="file"/>
                        </label>
                    </div>

                    <span wire:loading wire:target="certification" class="text-sm">Cargando...</span>
                    <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
                        <div x-bind:style="'width: ' + progress"
                             class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
                    </div>
                </div>

                @if ($certification)
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>
                @elseif($certification_url)
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification_url }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>
                @endif</div>

            <div class="flex gap-4 justify-end md:col-span-2">
                <flux:button type="button" variant="danger" @click="$flux.modal('edit').close()">Cancelar</flux:button>

                <flux:button type="submit" variant="primary">Aceptar Cambios</flux:button>
            </div>
        </form>
    </flux:modal>

    @script
    <script>
        Alpine.store('actual', false)

        $js('changeActual', (actual) => {
            switch (actual) {
                case true:
                    Alpine.store('actual', 1)
                    break
                case false:
                    Alpine.store('actual', 0)
            }
        })
    </script>
    @endscript
</div>
