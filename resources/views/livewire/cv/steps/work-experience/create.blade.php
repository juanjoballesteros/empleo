<div class="relative">
    <flux:button href="{{ route('cv.work-experience-info') }}" variant="ghost" icon="arrow-left" wire:navigate>
        Volver
    </flux:button>

    <div wire:show="!open" wire:cloak class="flex flex-col gap-4 p-4">
        <h3 class="text-xl text-center">Sube Tu Certificado</h3>

        <flux:button wire:show="!open" wire:click="$set('open', true)" class="w-full">
            No cuento con certificado o es mi trabajo actualmente
        </flux:button>

        <div>
            @if($certification)
                <div class="flex flex-col gap-4">
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>

                    <flux:button wire:click="$set('certification', null)" class="w-full">
                        Cambiar Certificado
                    </flux:button>

                    <flux:button wire:click="analyzeImage" variant="primary" color="blue" class="w-full">
                        Subir
                    </flux:button>
                </div>
            @else
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

                            <input type="file" wire:model="certification" name="file" class="hidden"
                                   accept="image/*">

                            <flux:error name="file"/>
                        </label>
                    </div>

                    <span wire:loading wire:target="certification" class="text-sm">Cargando...</span>
                    <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
                        <div x-bind:style="'width: ' + progress"
                             class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <form wire:show="open" wire:cloak wire:submit="store" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <h3 class="text-xl text-center md:col-span-2">Añadir</h3>

        <flux:input wire:model="name" label="Nombre de la empresa o entidad*" required/>
        <flux:input wire:model="post" label="Cargo o rol a ejercer*" required/>

        <flux:input type="date" wire:model="date_start" label="Fecha ingreso*" required
                    max="{{ today()->toDateString() }}"/>

        <flux:select wire:model="actual" x-model="$store.actual" label="Es trabajo actual*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            <flux:select.option value="true">Si</flux:select.option>
            <flux:select.option value="false">No</flux:select.option>
        </flux:select>

        <div x-show="$store.actual == 'false'" x-cloak>
            <flux:input type="date" wire:model="date_end" label="Fecha de retiro*"
                        max="{{ today()->toDateString() }}"/>
        </div>

        <flux:input type="email" wire:model="email" label="Correo de la empresa*" required/>
        <flux:input type="tel" wire:model="phone" label="Teléfono de la empresa*" required/>
        <flux:input wire:model="address" label="Dirección de la empresa*" required/>

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
                <flux:select.option value="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <div x-show="$store.actual" x-cloak class="md:col-span-2">
            @if($certification)
                <div class="flex flex-col gap-4">
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>

                    <flux:button wire:click="$set('certification', null)">
                        Cambiar Certificado
                    </flux:button>
                </div>
            @endif
        </div>

        <flux:button type="submit" variant="primary" class="w-full md:col-span-2">Añadir</flux:button>
    </form>

    <livewire:camera/>

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
