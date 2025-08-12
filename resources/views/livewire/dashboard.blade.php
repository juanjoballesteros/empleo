<div>
    @if(auth()->user()->userable instanceof App\Models\Candidate)
        <div class="flex flex-col gap-4">
            <h2 class="text-2xl text-center"><b>Bienvenido:</b> {{ request()->user()->name }}</h2>

            <div class="relative border border-gray-300 rounded-md">
                <div class="flex flex-col items-center gap-2 p-4">
                    <p class="text-center"><b>Paso 1:</b> Complete el formulario de hoja de vida</p>

                    <flux:button href="{{ route('cv.personal-info') }}"
                                 variant="primary" wire:navigate>
                        Complete su hoja de vida
                    </flux:button>
                </div>

                @if($cv->isCompleted())
                    <div class="absolute top-0 bg-gray-300/90 w-full h-full p-4">
                        <div class="my-auto w-full h-full flex flex-col justify-center items-center">
                            <flux:icon icon="check-circle" class="text-green-400 size-1/2"/>
                            <p>Paso Completado</p>
                        </div>
                    </div>
                @endif
            </div>

            <form wire:submit="send" class="border border-gray-300 rounded-md p-4 flex flex-col items-center gap-2">
                <p class="text-center"><b>Paso 2:</b> Digite el puesto que busca y postulate</p>

                <flux:input.group>
                    <flux:input wire:model="search" placeholder="Digite el puesto"/>

                    <flux:button icon="magnifying-glass"/>
                </flux:input.group>
            </form>
        </div>
    @endif

    @if(auth()->user()->userable instanceof App\Models\Company)
        <div class="flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('company.offers.index') }}" class="border border-gray-200 rounded-lg p-4 w-full">
                    <div class="flex gap-4">
                        <flux:icon.briefcase class="self-center size-8"/>

                        <div>
                            <h3 class="text-xl">Ofertas publicadas</h3>
                            <span class="text-4xl text-blue-600 font-bold">{{ $offers->total() }}</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('company.offers.index') }}" class="border border-gray-200 rounded-lg p-4 w-full">
                    <div class="flex gap-4">
                        <flux:icon.user-group class="self-center size-8"/>

                        <div>
                            <h3 class="text-xl">Candidatos postulados</h3>
                            <span class="text-4xl text-green-600 font-bold">{{ $applications->count() }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between">
                        <h3 class="text-xl">Ultimas Ofertas Publicadas</h3>

                        <flux:button href="{{ route('company.offers.index') }}" variant="primary">
                            Ver todas
                        </flux:button>
                    </div>

                    @forelse($offers as $offer)
                        <a href="{{ route('company.offers.index') }}" class="border border-gray-300 rounded-md p-2">
                            <div class="flex flex-col md:flex-row md:justify-between gap-1 md:gap-4">
                                <h4 class="text-lg font-bold">{{ $offer->title }}</h4>

                                <p>Publicado: {{ $offer->created_at->translatedFormat('j \d\e F \d\e\l Y') }}
                                    <b>({{ $offer->created_at->diffForHumans() }})</b></p>
                            </div>

                            <div class="flex flex-col md:flex-row gap-1 md:gap-4">
                                <p>$ {{ Number::format($offer->salary) }} COP</p>

                                <p>Modalidad: {{ $offer->location }}</p>

                                @if($offer->location === 'Presencial')
                                    <p>Ubicación: {{ $offer->city->name  }}</p>
                                @endif
                            </div>
                        </a>

                        {{ $offers->links() }}
                    @empty
                        <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado ofertas"/>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
