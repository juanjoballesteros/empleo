<div>
    <div class="p-4">
        <h2 class="text-2xl font-bold text-center mb-2">Ofertas De Empleo Publicadas</h2>

        <div class="flex gap-4 mb-4">
            <flux:button href="{{ route('company.offers.create') }}" icon="plus" wire:navigate>
                Añadir Oferta De Trabajo
            </flux:button>

            <flux:separator vertical/>

            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Buscar"/>
        </div>

        @forelse($jobOffers as $jobOffer)
            <div class="border border-gray-300 rounded-md p-2">
                <div class="flex justify-between gap-4">
                    <h3 class="text-xl font-bold">{{ $jobOffer->title }}</h3>

                    <p>Publicado: {{ $jobOffer->created_at->translatedFormat('j \d\e F \d\e\l Y') }}
                        <b>({{ $jobOffer->created_at->diffForHumans() }})</b></p>
                </div>

                <div class="flex gap-4">
                    <p>$ {{ Number::format($jobOffer->salary) }} COP</p>

                    <p>Modalidad: {{ $jobOffer->location }}</p>

                    @if($jobOffer->location === 'Presencial')
                        <p>Ubicación: {{ $jobOffer->city->name  }}</p>
                    @endif

                    <div class="ms-auto flex gap-2">
                        <flux:button href="{{ route('company.offers.applications', $jobOffer->id) }}" icon="users"
                                     variant="primary" wire:navigate>
                            Ver Candidatos
                        </flux:button>

                        <flux:button wire:click="delete({{ $jobOffer->id }})"
                                     wire:confirm="¿Estas seguro de que quieres eliminar esta oferta de empleo?"
                                     icon="trash" variant="danger">
                            Eliminar
                        </flux:button>
                    </div>
                </div>
            </div>
        @empty
            <flux:callout variant="warning" icon="exclamation-circle"
                          heading="No tiene ofertas de trabajo"/>
        @endforelse
    </div>
</div>
