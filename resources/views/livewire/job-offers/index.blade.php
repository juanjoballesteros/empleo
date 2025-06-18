<div>
    <flux:input wire:model.live="search" placeholder="Nombre del puesto a buscar" icon="magnifying-glass" clearable
                class="mb-4"/>

    <div class="flex gap-4">
        <div class="w-1/4">
            <h3 class="text-xl font-bold text-center">Filtrar</h3>
        </div>

        <flux:separator vertical/>

        <div class="flex-1">
            @if(strlen($search) <= 3)
                <flux:callout variant="warning" icon="exclamation-circle"
                              heading="Realiza una búsqueda"/>
            @else
                @forelse($jobOffers as $jobOffer)
                    <div class="border border-gray-300 rounded-md p-2 mb-4">
                        <div class="flex justify-between gap-4">
                            <h3 class="text-xl font-bold">{{ $jobOffer->title }}</h3>

                            <p>Publicado: {{ $jobOffer->created_at->translatedFormat('j \d\e F \d\e\l Y') }}
                                <b>({{ $jobOffer->created_at->diffForHumans() }})</b></p>
                        </div>

                        <div class="flex gap-4">
                            <p>$ {{ Number::format($jobOffer->salary) }}</p>

                            <p>Modalidad: {{ $jobOffer->location }}</p>

                            @if($jobOffer->location === 'Presencial')
                                <p>Ubicación: {{ $jobOffer->city->name  }}</p>
                            @endif

                            <p class="ms-auto">Publicado por: <b>{{ $jobOffer->company->name }}</b></p>
                        </div>
                    </div>
                @empty
                    @if(strlen($search) > 3)
                        <flux:callout variant="warning" icon="exclamation-circle"
                                      heading="No hay ofertas de trabajo disponibles"/>
                    @endif
                @endforelse
            @endif
        </div>
    </div>
</div>
