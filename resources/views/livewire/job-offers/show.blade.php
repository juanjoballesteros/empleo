<div>
    @isset($jobOffer)
        <div class="rounded-lg border border-gray-200 p-4">
            <flux:button wire:click="$parent.$set('open', false)" icon="x-mark"/>

            <h2 class="text-2xl font-bold">{{ $jobOffer->title }}</h2>
            <h3 class="text-xl">{{ $jobOffer->salary }}</h3>


            <p>Modalidad: {{ $jobOffer->location }}</p>
            @if($jobOffer->location === 'Presencial')
                <p>Ubicación: {{ $jobOffer->city->name  }}</p>
            @endif

            <div class="flex gap-2 justify-between text-sm">
                <p>Publicado por: <b>{{ $jobOffer->company->name }}</b></p>

                <p>{{ $jobOffer->created_at->diffForHumans() }}</p>
            </div>

            <flux:separator class="my-2"/>

            <p>{{ $jobOffer->description }}</p>
            <p>{{ $jobOffer->requirements }}</p>

            <div class="mt-4">
                <flux:button type="button" wire:click="applyForJob" variant="primary" color="blue"
                    @class(['w-full', 'opacity-50 cursor-not-allowed' => $hasApplied])>
                    {{ $hasApplied ? 'Ya te has postulado' : 'Postularme a esta oferta' }}
                </flux:button>
            </div>
        </div>
    @endisset
</div>
