<div>
    @isset($jobOffer)
        <div class="rounded-lg border border-gray-200 p-4">
            <flux:button wire:click="$parent.$set('open', false)" icon="x-mark"/>

            <h2 class="text-2xl font-bold">{{ $jobOffer->title }}</h2>
            <h3 class="text-xl">$ {{ Number::format($jobOffer->salary) }}</h3>


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
        </div>
    @endisset
</div>
