<div>
    @include('layouts.wizard.navigation')

    <div wire:show="!show" wire:cloak class="flex flex-col gap-4 items-center max-w-lg m-auto mt-4">
        <h3 class="text-lg text-center">¿Cuenta Usted Con Educación Superior?</h3>

        <flux:button variant="primary" color="blue" wire:click="show = true" class="w-full">Sí</flux:button>

        <flux:separator text="o"/>

        <flux:button wire:click="check" class="w-full">
            No
        </flux:button>
    </div>

    <div wire:show="show" wire:cloak>
        <h4 class="text-lg text-center mb-2">5. Educación Superior</h4>

        <div class="flex flex-col gap-4 max-w-md mx-auto">
            @forelse($higherEducations as $higherEducation)
                @php
                    $type = match ($higherEducation->type) {
                        'TC' => 'Técnica',
                        'TL' => 'Tecnológica',
                        'TE' => 'Tecnológica Especializada',
                        'UN' => 'Universitaria',
                        'ES' => 'Especialización',
                        'MG' => 'Maestria',
                        'DOC' => 'Doctorado',
                        default => 'Otro',
                    }
                @endphp

                <div class="relative bg-gray-50 rounded-lg p-2 h-28">
                    <h4 class="text-lg">{{ $type }}</h4>
                    <p>{{ $higherEducation->program }}</p>
                    <p class="text-gray-500">{{ $higherEducation->date_semester->toDateString() }}</p>

                    <div class="absolute top-2 right-2">
                        <flux:dropdown>
                            <flux:button icon="ellipsis-vertical"></flux:button>

                            <flux:menu>
                                <flux:menu.item icon="pencil"
                                                wire:click="$dispatch('edit', { higherEducation: {{ $higherEducation->id }} })">
                                    Editar
                                </flux:menu.item>

                                <flux:menu.item variant="danger" icon="trash"
                                                wire:click="delete({{ $higherEducation->id }})">
                                    Eliminar
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            @empty
                <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado información"/>
            @endforelse

            <flux:button @click="$flux.modal('create').show()" variant="primary" color="blue" class="w-full">
                Añadir
            </flux:button>
        </div>

        <flux:modal name="create">
            <livewire:cv.steps.higher-education.create :$cv/>
        </flux:modal>

        <livewire:cv.steps.higher-education.edit/>
        @include('layouts.wizard.footer')
    </div>
</div>
