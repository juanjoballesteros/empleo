<div>
    @include('layouts.wizard.navigation')

    <div wire:show="!show" wire:cloak class="flex flex-col gap-4 items-center max-w-lg m-auto mt-4">
        <h3 class="text-lg text-center">¿Usted Sabe Un Idioma Diferente Al Español Que: Hable, Lea y Escriba?</h3>

        <flux:button variant="primary" color="blue" wire:click="show = true" class="w-full">Sí</flux:button>

        <flux:separator text="o"/>

        <flux:button wire:click="check" class="w-full">
            No
        </flux:button>
    </div>

    <div wire:show="show" wire:cloak>
        <h4 class="text-lg text-center mb-2">7. Idiomas</h4>

        <div class="flex flex-col gap-4 max-w-md mx-auto">
            @forelse($languagesInfos as $languageInfo)
                @php
                    $speak = match ($languageInfo->speak) {
                        'MB' => 'Muy Bien',
                        'B' => 'Bien',
                        'R' => 'Regular',
                    };

                    $read = match ($languageInfo->read) {
                        'MB' => 'Muy Bien',
                        'B' => 'Bien',
                        'R' => 'Regular',
                    };

                    $write = match ($languageInfo->write) {
                        'MB' => 'Muy Bien',
                        'B' => 'Bien',
                        'R' => 'Regular',
                    };
                @endphp

                <div class="relative bg-gray-50 rounded-lg p-2 h-max min-h-24">
                    <h4 class="text-lg">{{ $languageInfo->name }}</h4>
                    <p>Habla: {{ $speak }}</p>
                    <p>Lee: {{ $read }}</p>
                    <p>Escribe: {{ $write }}</p>
                    @if($url = $languageInfo->getFirstMediaUrl())
                        <flux:button href="{{ $url }}" icon="photo" target="_blank">
                            Ver certificado
                        </flux:button>
                    @endif

                    <div class="absolute top-2 right-2">
                        <flux:dropdown>
                            <flux:button variant="ghost" icon="ellipsis-vertical"></flux:button>

                            <flux:menu>
                                <flux:menu.item icon="pencil"
                                                wire:click="$dispatch('edit', { languageInfo: {{ $languageInfo->id }} })">
                                    Editar
                                </flux:menu.item>

                                <flux:menu.item variant="danger" icon="trash"
                                                wire:click="delete({{ $languageInfo->id }})">
                                    Eliminar
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            @empty
                <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado información"/>
            @endforelse

            <flux:button href="{{ route('cv.language-info.create') }}" variant="primary" color="blue" class="w-full"
                         wire:navigate>
                Añadir
            </flux:button>
        </div>

        <flux:modal name="edit" class="md:min-w-3xl">
            <livewire:cv.steps.language.edit/>
        </flux:modal>

        <div class="flex justify-end mt-2">
            <flux:button href="{{ route('cv.completed') }}" variant="primary" wire:navigate>
                ¡Terminar!
            </flux:button>
        </div>
    </div>
</div>
