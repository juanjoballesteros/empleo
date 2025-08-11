<div>
    @include('layouts.wizard.navigation')

    <div wire:show="!show" wire:cloak class="flex flex-col gap-4 items-center max-w-lg m-auto mt-4">
        <h3 class="text-lg text-center">¿Cuenta Usted Con Experiencia Laboral?</h3>

        <flux:button variant="primary" color="blue" wire:click="show = true" class="w-full">Sí</flux:button>

        <flux:separator text="o"/>

        <flux:button wire:click="check" class="w-full">
            No
        </flux:button>
    </div>

    <div wire:show="show" wire:cloak>
        <h4 class="text-lg text-center mb-2">6. Experiencia Laboral</h4>

        <div class="flex flex-col gap-4 max-w-md mx-auto">
            @forelse($workExperiences as $workExperience)
                <div class="relative bg-gray-50 rounded-lg p-2 h-max min-h-24">
                    <h4 class="text-lg">{{ $workExperience->post }}</h4>
                    <p>{{ $workExperience->name }}</p>
                    <p class="text-gray-500">
                        {{ $workExperience->date_start->toDateString() }}
                        - {{ $workExperience->date_end?->toDateString() ?? 'Actualmente' }}
                    </p>

                    <div class="absolute top-2 right-2">
                        <flux:dropdown>
                            <flux:button variant="ghost" icon="ellipsis-vertical"></flux:button>

                            <flux:menu>
                                <flux:menu.item icon="pencil"
                                                wire:click="$dispatch('edit', { workExperience: {{ $workExperience->id }} })">
                                    Editar
                                </flux:menu.item>

                                <flux:menu.item variant="danger" icon="trash"
                                                wire:click="delete({{ $workExperience->id }})">
                                    Eliminar
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            @empty
                <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado experiencia laboral"
                              class="mb-2"/>
            @endforelse

            <flux:button @click="$flux.modal('create').show()" variant="primary" color="blue" class="w-full">
                Añadir
            </flux:button>
        </div>


        <flux:modal name="create" class="md:min-w-3xl">
            <livewire:cv.steps.work-experience.create :$cv/>
        </flux:modal>

        <flux:modal name="edit" class="md:min-w-4xl">
            <livewire:cv.steps.work-experience.edit/>
        </flux:modal>

        <livewire:camera/>
        @include('layouts.wizard.footer')
    </div>
</div>
