<div>
    <div class="p-4">
        <h2 class="text-2xl font-bold text-center mb-2">Ofertas De Empleo Publicadas</h2>

        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Buscar"/>

            <flux:separator vertical class="hidden md:block"/>

            <flux:button href="{{ route('company.offers.create') }}" icon="plus" wire:navigate>
                Añadir Oferta De Trabajo
            </flux:button>
        </div>

        <div class="flex flex-col gap-4">
            @forelse($jobOffers as $jobOffer)
                <div class="relative border border-gray-300 rounded-md p-2">
                    <div class="flex flex-col md:flex-row justify-between md:gap-4">
                        <h3 class="text-xl font-bold">{{ $jobOffer->title }}</h3>

                        <p>Publicado: {{ $jobOffer->created_at->translatedFormat('j \d\e F \d\e\l Y') }}
                            <b>({{ $jobOffer->created_at->diffForHumans() }})</b></p>
                    </div>

                    <div class="flex flex-col md:flex-row gap-1 md:gap-4">
                        <p>{{ $jobOffer->salary }}</p>

                        <p>Modalidad: {{ $jobOffer->location }}</p>

                        @if($jobOffer->location === 'Presencial')
                            <p>Ubicación: {{ $jobOffer->city->name  }}</p>
                        @endif

                        <flux:button href="{{ route('company.offers.applications', $jobOffer->id) }}" icon="users"
                                     variant="primary" wire:navigate class="md:hidden">
                            Ver Candidatos
                        </flux:button>

                        {{-- Desktop Actions Buttons --}}
                        <div class="hidden ms-auto md:flex gap-2">
                            <flux:button.group>
                                <flux:button href="{{ route('company.offers.applications', $jobOffer->id) }}"
                                             icon="users"
                                             variant="primary" wire:navigate>
                                    Ver Candidatos
                                </flux:button>

                                <flux:button href="{{ route('company.offers.edit', $jobOffer->id) }}" icon="pencil"
                                             variant="primary" color="yellow" wire:navigate>
                                    Editar
                                </flux:button>

                                <flux:button wire:click="delete({{ $jobOffer->id }})"
                                             wire:confirm="¿Estas seguro de que quieres eliminar esta oferta de empleo?"
                                             icon="trash" variant="danger">
                                    Eliminar
                                </flux:button>
                            </flux:button.group>
                        </div>
                    </div>

                    {{-- Mobile Actions Menu --}}
                    <div class="md:hidden absolute top-1 right-1">
                        <flux:dropdown>
                            <flux:button variant="ghost" icon="ellipsis-vertical"></flux:button>

                            <flux:menu>
                                <flux:menu.item href="{{ route('company.offers.edit', $jobOffer->id) }}"
                                                icon="pencil" wire:navigate>
                                    Editar
                                </flux:menu.item>

                                <flux:menu.item wire:click="delete({{ $jobOffer->id }})"
                                                wire:confirm="¿Estas seguro de que quieres eliminar esta oferta de empleo?"
                                                icon="trash" variant="danger">
                                    Eliminar
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            @empty
                <flux:callout variant="warning" icon="exclamation-circle"
                              heading="No tiene ofertas de trabajo"/>
            @endforelse

            {{ $jobOffers->links() }}
        </div>
    </div>
</div>
