<div>
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
</div>
