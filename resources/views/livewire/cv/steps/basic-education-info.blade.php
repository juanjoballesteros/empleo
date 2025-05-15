<div>
    <form wire:submit="store" class="bg-white shadow-sm rounded-lg p-4 m-4" enctype="multipart/form-data">
        @include('layouts.wizard.navigation')

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:input wire:model="program" label="Nombre del programa*" required/>
            </div>

            <div class="flex-1">
                <flux:select wire:model="level" label="Último Grado Aprobado*" required>
                    <flux:select.option value="">Seleccionar...</flux:select.option>
                    @for($i = 1; $i < 12; $i++)
                        <flux:select.option value="{{ $i }}" :selected="$level">{{ $i }}
                        </flux:select.option>
                    @endfor
                </flux:select>
            </div>
        </div>

        <div class="sm:flex gap-4 mb-2">
            <div class="flex-1">
                <flux:input type="date" wire:model="end_date" label="Fecha de terminación*" required/>
            </div>

            <div class="flex-1">
                <flux:field>
                    <flux:label>Certificado</flux:label>

                    <flux:input.group>
                        <flux:input type="file" wire:model="certification" accept="image/*"/>

                        <flux:button type="button" icon="camera"
                                     @click="$dispatch('openCamera', { id: $wire.id, file: 'certification' })"/>
                    </flux:input.group>
                </flux:field>
            </div>
        </div>

        @if ($certification)
            <img src="{{ $certification->temporaryUrl() }}" alt="Certificación" class="w-32 p-2 m-auto">
        @elseif($certification_url)
            <img src="{{ $certification_url }}" alt="Certificación" class="w-32 p-2 m-auto">
        @endif

        <livewire:camera/>
        @include('layouts.wizard.footer')
    </form>
</div>
