<div class="relative">
    @include('layouts.wizard.navigation')

    <div wire:show="!show" wire:cloak class="flex flex-col gap-4 items-center max-w-lg m-auto mt-5">
        <h3 class="text-lg text-center">¿Cuenta Usted Con Educación Básica?</h3>

        <flux:button variant="primary" color="blue" wire:click="show = true" class="w-full">Sí</flux:button>

        <flux:separator text="o"/>

        <flux:button wire:click="check" class="w-full">
            No
        </flux:button>
    </div>

    <form wire:show="show" wire:cloak wire:submit="store">
        <h4 class="text-lg text-center mb-2">4. Education Básica</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="program" label="Nombre del programa*" required/>

            <flux:select wire:model="level" label="Último Grado Aprobado*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                @for($i = 1; $i < 12; $i++)
                    <flux:select.option value="{{ $i }}" :selected="$level">{{ $i }}
                    </flux:select.option>
                @endfor
            </flux:select>

            <flux:input type="date" wire:model="end_date" label="Fecha de terminación*" required
                        max="{{ today()->toDateString() }}"/>

            <div class="md:col-span-2">
                @if($certification)
                    <div class="flex flex-col gap-4">
                        <div class="h-32 bg-gray-100 w-full rounded-lg">
                            <img src="{{ $certification->temporaryUrl() }}" alt="Certificación"
                                 class="h-32 object-contain m-auto">
                        </div>

                        <flux:button type="button" wire:click="$set('certification', null)">
                            Cambiar Certificado
                        </flux:button>
                    </div>
                @elseif($certification_url)
                    <div class="flex flex-col gap-4">
                        <div class="h-32 bg-gray-100 w-full rounded-lg">
                            <img src="{{ $certification_url }}" alt="Certificación" class="h-32 object-contain m-auto">
                        </div>

                        <flux:button type="button" wire:click="$set('certification_url', null)">
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
        </div>

        @include('layouts.wizard.footer')
    </form>

    <livewire:camera/>
</div>
