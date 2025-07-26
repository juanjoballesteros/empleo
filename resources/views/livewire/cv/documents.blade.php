<div>
    @if(!$cv->isCompleted())
        <flux:callout variant="warning" icon="exclamation-circle" inline
                      heading="No has completado tu hoja de vida, completala antes de ver tu carpeta digital">
            <x-slot name="actions">
                <flux:button href="{{ route('cv.create.personal-info', $cv->id) }}" icon-trailing="arrow-right"
                             wire:navigate>
                    Completar Hoja De Vida
                </flux:button>
            </x-slot>
        </flux:callout>
    @else
        <h2 class="text-2xl text-center font-bold mb-2">Tu Carpeta Digital</h2>

        <div class="flex flex-col gap-4">
            <div x-data="{ expanded: false }" x-on:click="expanded =! expanded"
                 class="border border-gray-200 rounded-lg p-4 cursor-pointer">
                <div class="flex justify-between">
                    <h4 class="flex-1 text-lg text-center">Documento De Identidad Y Foto De Perfil</h4>

                    <flux:icon.chevron-down x-show="!expanded"/>
                    <flux:icon.chevron-up x-show="expanded" x-cloak/>
                </div>

                <div x-show="expanded" x-cloak x-collapse>
                    <div class="flex flex-wrap justify-center gap-2 mt-2">
                        <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                            <img src="{{ $card['front'] }}" alt="Documento Frontal" class="h-48 object-contain m-auto">
                        </div>

                        <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                            <img src="{{ $card['back'] }}" alt="Documento Trasero" class="h-48 object-contain m-auto">
                        </div>

                        <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                            <img src="{{ $card['profile'] }}" alt="Perfil" class="h-48 object-contain m-auto">
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ expanded: false }" x-on:click="expanded =! expanded"
                 class="border border-gray-200 rounded-lg p-4 cursor-pointer">
                <div class="flex justify-between">
                    <h4 class="flex-1 text-lg text-center">Education Básica Y Superior</h4>

                    <flux:icon.chevron-down x-show="!expanded"/>
                    <flux:icon.chevron-up x-show="expanded" x-cloak/>
                </div>

                <div x-show="expanded" x-cloak x-collapse>
                    <div class="flex flex-wrap justify-center gap-2 mt-2">
                        @foreach($education as $image)
                            <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                                <img src="{{ $image }}" alt="Certificado" class="h-48 object-contain m-auto">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-data="{ expanded: false }" x-on:click="expanded =! expanded"
                 class="border border-gray-200 rounded-lg p-4 cursor-pointer">
                <div class="flex justify-between">
                    <h4 class="flex-1 text-lg text-center">Experiencia Laboral</h4>

                    <flux:icon.chevron-down x-show="!expanded"/>
                    <flux:icon.chevron-up x-show="expanded" x-cloak/>
                </div>

                <div x-show="expanded" x-cloak x-collapse>
                    <div class="flex flex-wrap justify-center gap-2 mt-2">
                        @foreach($work as $image)
                            <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                                <img src="{{ $image }}" alt="Certificado" class="h-48 object-contain m-auto">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-data="{ expanded: false }" x-on:click="expanded =! expanded"
                 class="border border-gray-200 rounded-lg p-4 cursor-pointer">
                <div class="flex justify-between">
                    <h4 class="flex-1 text-lg text-center">Idiomas</h4>

                    <flux:icon.chevron-down x-show="!expanded"/>
                    <flux:icon.chevron-up x-show="expanded" x-cloak/>
                </div>

                <div x-show="expanded" x-cloak x-collapse>
                    <div class="flex flex-wrap justify-center gap-2 mt-2">
                        @foreach($lenguajes as $image)
                            <div class="bg-gray-100 w-full max-w-sm rounded-lg">
                                <img src="{{ $image }}" alt="Certificado" class="h-48 object-contain m-auto">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
