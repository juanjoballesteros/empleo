<div>
    <form wire:submit="store" x-data="{ actual: '' }"
          class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <h3 class="text-xl text-center md:col-span-2">Añadir</h3>

        <flux:input wire:model="program" label="Nombre del programa*" required/>
        <flux:input wire:model="institution" label="Institución Educativa*" required/>

        <flux:select wire:model="type" label="Modalidad Académica*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            <flux:select.option value="TC">Técnica</flux:select.option>
            <flux:select.option value="TL">Tecnológica</flux:select.option>
            <flux:select.option value="TE">Tecnológica Especializada</flux:select.option>
            <flux:select.option value="UN">Universitaria</flux:select.option>
            <flux:select.option value="ES">Especialización</flux:select.option>
            <flux:select.option value="MG">Maestría</flux:select.option>
            <flux:select.option value="DOC">Doctorado</flux:select.option>
        </flux:select>

        <flux:input type="date" wire:model="date_start" label="Fecha de inicio*" required
                    max="{{ today()->toDateString() }}"/>

        <flux:select wire:model="actual" x-model="actual" label="¿Ya terminaste?*" required>
            <flux:select.option value="">Seleccionar...</flux:select.option>
            <flux:select.option value="1">Si</flux:select.option>
            <flux:select.option value="0">No</flux:select.option>
        </flux:select>

        <div x-show="actual == true">
            <flux:input type="date" wire:model="date_end" label="Fecha finalizado*"
                        max="{{ today()->toDateString() }}"/>
        </div>

        <div x-show="actual == true" class="md:col-span-2">
            @if($certification)
                <div class="flex flex-col gap-4">
                    <div class="h-32 bg-gray-100 w-full rounded-lg">
                        <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                             class="h-32 object-contain m-auto">
                    </div>

                    <flux:button wire:click="$set('certification', null)" class="w-full">
                        Cambiar Certificado
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

        <flux:button type="submit" variant="primary" class="md:col-span-2">Añadir</flux:button>
    </form>
</div>
