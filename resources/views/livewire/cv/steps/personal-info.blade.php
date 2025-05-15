<div xmlns:flux="http://www.w3.org/1999/html">
    <form wire:submit="store" class="bg-white shadow-sm rounded-lg p-4 m-4">
        @include('layouts.wizard.navigation')

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:input wire:model="first_name" label="Primer nombre*" required autofocus/>
            </div>

            <div class="flex-1">
                <flux:input wire:model="second_name" label="Segundo nombre"/>
            </div>
        </div>

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:input wire:model="first_surname" label="Primer apellido*" required/>
            </div>

            <div class="flex-1">
                <flux:input wire:model="second_surname" label="Segundo apellido*" required/>
            </div>
        </div>

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:select wire:model="sex" label="Sexo*" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    <flux:select.option value="Femenino">Femenino</flux:select.option>
                    <flux:select.option value="Masculino">Masculino</flux:select.option>
                </flux:select>
            </div>

            <div class="flex-1">
                <flux:select wire:model="document_type" label="Tipo de documento*" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    <flux:select.option value="CC">Cédula de ciudadanía</flux:select.option>
                    <flux:select.option value="CE">Cédula de extranjería</flux:select.option>
                    <flux:select.option value="PAS">Pasaporte</flux:select.option>
                </flux:select>
            </div>
        </div>

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:input wire:model="document_number" label="Nº de documento*"/>
            </div>
        </div>

        <div class="mb-2">
            <flux:textarea label="Añada una breve descripción de sus habilidades*" wire:model="description"
                           resize="vertical" rows="2" required/>
        </div>

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:field>
                    <flux:label>Anexe una imagen delante de su documento</flux:label>

                    <flux:input.group>
                        <flux:input type="file" wire:model="document_front" accept="image/*"/>

                        <flux:button type="button" icon="camera"
                                     @click="$dispatch('openCamera', { id: $wire.id, file: 'document_front' })"/>
                    </flux:input.group>
                </flux:field>

                @if ($document_front)
                    <img src="{{ $document_front->temporaryUrl() }}" alt="Documento" class="w-32 p-2 m-auto">
                @elseif($document_urls['front'])
                    <img src="{{ $document_urls['front'] }}" alt="Documento" class="w-32 p-2 m-auto">
                @endif
            </div>

            <div class="flex-1">
                <flux:field>
                    <flux:label>Anexe una imagen atrás de su documento</flux:label>

                    <flux:input.group>
                        <flux:input type="file" wire:model="document_back" accept="image/*"/>

                        <flux:button type="button" icon="camera"
                                     @click="$dispatch('openCamera', { id: $wire.id, file: 'document_back' })"/>
                    </flux:input.group>
                </flux:field>

                @if ($document_back)
                    <img src="{{ $document_back->temporaryUrl() }}" alt="Documento" class="w-32 p-2 m-auto">
                @elseif($document_urls['back'])
                    <img src="{{ $document_urls['back'] }}" alt="Documento" class="w-32 p-2 m-auto">
                @endif
            </div>
        </div>

        <div class="mb-2">
            <flux:field>
                <flux:label>Añada una foto de perfil para su hoja de vida</flux:label>

                <flux:input.group>
                    <flux:input type="file" wire:model="profile" accept="image/*"/>

                    <flux:button type="button" icon="camera"
                                 @click="$dispatch('openCamera', { id: $wire.id, file: 'profile' })"/>
                </flux:input.group>
            </flux:field>

            @if ($profile)
                <img src="{{ $profile->temporaryUrl() }}" alt="Documento" class="w-32 p-2 m-auto">
            @elseif($document_urls['back'])
                <img src="{{ $document_urls['profile'] }}" alt="Documento" class="w-32 p-2 m-auto">
            @endif
        </div>

        <livewire:camera/>

        @include('layouts.wizard.footer')
    </form>
</div>
