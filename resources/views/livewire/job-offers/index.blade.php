<div>
    <flux:input wire:model.live="search" placeholder="Nombre del puesto a buscar" icon="magnifying-glass" clearable
                class="mb-4"/>

    <div class="flex gap-4">
        <div @class(['flex-1', 'hidden md:block overflow-y-auto max-h-screen' => $open])>
            @if(strlen($search) <= 3)
                <flux:callout variant="warning" icon="exclamation-circle"
                              heading="Realiza una búsqueda"/>
            @else
                @forelse($jobOffers as $job)
                    <div wire:click="openJobOffer({{ $job->id }})"
                         class="border border-gray-300 hover:bg-gray-50 cursor-pointer rounded-md p-2 mb-4">

                        <h3 class="text-xl font-bold">{{ $job->title }}</h3>

                        <div class="flex gap-4">
                            <p>$ {{ Number::format($job->salary) }}</p>

                            <p><b>Modalidad:</b> {{ $job->location }}</p>

                            @if($job->location === 'Presencial')
                                <p>Ubicación: {{ $job->city->name  }}</p>
                            @endif
                        </div>

                        <div class="flex gap-2 justify-between text-sm">
                            <p>Publicado por: <b>{{ $job->company->name }}</b></p>

                            <p>{{ $job->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <flux:callout variant="warning" icon="exclamation-circle"
                                  heading="No hay ofertas de trabajo disponibles para tu búsqueda"/>
                @endforelse
            @endif
        </div>

        <div @class(['md:w-3/5', 'hidden' => !$open])>
            <livewire:job-offers.show/>
        </div>
    </div>
</div>
