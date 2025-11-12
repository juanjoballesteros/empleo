<div class="relative">
    @include('layouts.wizard.navigation')

    <h4 class="text-lg text-center mb-2">1. Información Personal</h4>

    <div x-data="{ uploading: false, progress: 0 }"
         x-on:livewire-upload-start="uploading = true"
         x-on:livewire-upload-finish="uploading = false"
         x-on:livewire-upload-cancel="uploading = false"
         x-on:livewire-upload-error="uploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        @if(!$document_urls['front'] && !$document_urls['back'])
            <form wire:submit="analyzeImage" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(!$document_front)
                    <div class="flex flex-col gap-4">
                        <h3 class="text-xl text-center">Toma una foto frontal de tu documento</h3>

                        <div class="flex flex-col gap-4">
                            <div @click="$dispatch('openCamera', { id: $wire.id, file: 'document_front' })"
                                 class="flex flex-col items-center cursor-pointer w-full h-full border-2 border-dashed border-gray-400 rounded-lg p-6">
                                <flux:icon.camera class="size-12 text-gray-500"/>

                                <p class="text-gray-500">Toma Una Foto</p>
                            </div>
                        </div>

                        <div wire:loading wire:target="document_front">Cargando...</div>
                    </div>
                @else
                    <div class="flex flex-col gap-4">
                        <div class="bg-gray-200 rounded-lg flex justify-center">
                            <img src="{{ $document_front->temporaryUrl() }}" alt="Image" class="h-44 object-contain">
                        </div>

                        <flux:button @click="$dispatch('openCamera', { id: $wire.id, file: 'document_front' })"
                                     variant="primary" icon="camera" class="w-full m-auto">
                            Tomar Otra Foto
                        </flux:button>
                    </div>
                @endif

                @if(!$document_back)
                    <div class="flex flex-col gap-4">
                        <h3 class="text-xl text-center">Toma una foto trasera de tu documento</h3>

                        <div class="flex flex-col gap-4">
                            <div @click="$dispatch('openCamera', { id: $wire.id, file: 'document_back' })"
                                 class="flex flex-col items-center cursor-pointer w-full h-full border-2 border-dashed border-gray-400 rounded-lg p-6">
                                <flux:icon.camera class="size-12 text-gray-500"/>

                                <p class="text-gray-500">Toma Una Foto</p>
                            </div>
                        </div>

                        <div wire:loading wire:target="document_back">Cargando...</div>
                    </div>
                @else
                    <div class="flex flex-col gap-4">
                        <div class="bg-gray-200 rounded-lg flex justify-center">
                            <img src="{{ $document_back->temporaryUrl() }}" alt="Image" class="h-44 object-contain">
                        </div>

                        <flux:button @click="$dispatch('openCamera', { id: $wire.id, file: 'document_back' })"
                                     variant="primary" icon="camera" class="w-full m-auto">
                            Tomar Otra Foto
                        </flux:button>
                    </div>
                @endif

                @if(!$show)
                    <flux:button type="submit" variant="primary" color="blue" class="w-full md:col-span-2">
                        Subir
                    </flux:button>
                @endif
            </form>
        @else
            <div class="grid grid-cols-1  md:grid-cols-2 gap-4">
                <div>
                    <div class="bg-gray-200 rounded-lg flex justify-center">
                        <img src="{{ $document_urls['front'] }}" alt="Image" class="h-60 object-contain">
                    </div>
                </div>

                <div>
                    <div class="bg-gray-200 rounded-lg flex justify-center">
                        <img src="{{ $document_urls['back'] }}" alt="Image" class="h-60 object-contain">
                    </div>
                </div>

                <flux:button wire:click="resetImages"
                             variant="primary" color="blue" icon="camera" class="w-full m-auto mt-2 md:col-span-2">
                    Tomar Otra Foto
                </flux:button>
            </div>
        @endif

        <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
            <div x-bind:style="'width: ' + progress"
                 class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
        </div>
    </div>

    @if($show)
        <form wire:submit="store" class="flex flex-col gap-4 mt-4">
            <flux:input wire:model="first_name" label="Primer nombre*" required/>
            <flux:input wire:model="second_name" label="Segundo nombre"/>

            <flux:input wire:model="first_surname" label="Primer apellido*" required/>
            <flux:input wire:model="second_surname" label="Segundo apellido"/>

            <flux:select wire:model="document_type" label="Tipo de documento*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="CC">Cédula de ciudadanía</flux:select.option>
                <flux:select.option value="CE">Cédula de extranjería</flux:select.option>
                <flux:select.option value="PAS">Pasaporte</flux:select.option>
                <flux:select.option value="TI">Tarjeta De Identidad</flux:select.option>
            </flux:select>

            <flux:input wire:model="document_number" label="Nº de documento*"/>

            <flux:select wire:model="sex" label="Sexo*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="Femenino">Femenino</flux:select.option>
                <flux:select.option value="Masculino">Masculino</flux:select.option>
            </flux:select>

            <flux:input type="date" wire:model="birthdate" label="Fecha De Nacimiento" required/>

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

            <flux:textarea label="Añada una breve descripción de sus habilidades*" wire:model="description"
                           resize="vertical" rows="2" required/>

            <h3 class="text-xl text-center">Foto principal para tu hoja de vida</h3>

            @if($profile)
                <div class="w-full max-w-lg bg-gray-50 rounded-lg m-auto">
                    <img src="{{ $profile->temporaryUrl() }}" alt="Image" class="h-60 object-contain m-auto">
                </div>

                <flux:button @click="$dispatch('openCamera', { id: $wire.id, file: 'profile' })"
                             variant="primary" color="blue" icon="camera" class="w-full max-w-lg m-auto">
                    Tomar Otra Foto
                </flux:button>
            @elseif($document_urls['profile'])
                <div class="w-full max-w-lg bg-gray-50 rounded-lg m-auto">
                    <img src="{{ $document_urls['profile'] }}" alt="Image" class="h-60 object-contain m-auto">
                </div>

                <flux:button @click="$dispatch('openCamera', { id: $wire.id, file: 'profile' })"
                             variant="primary" color="blue" icon="camera" class="w-full max-w-lg m-auto">
                    Tomar Otra Foto
                </flux:button>
            @else
                <div class="flex flex-col gap-4">
                    <div @click="$dispatch('openCamera', { id: $wire.id, file: 'profile' })"
                         class="flex flex-col items-center cursor-pointer w-full h-full border-2 border-dashed border-gray-400 rounded-lg p-6">
                        <flux:icon.camera class="size-12 text-gray-500"/>

                        <p class="text-gray-500">Toma Una Foto</p>
                    </div>
                </div>
            @endif

            @include('layouts.wizard.footer')
        </form>
    @endif

    <livewire:camera/>
</div>
