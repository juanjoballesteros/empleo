<div>
    @role('candidato')
    <div class="flex flex-col gap-4">
        <h2 class="text-2xl text-center"><b>Bienvenido:</b> {{ request()->user()->name }}</h2>

        <div class="border border-gray-300 rounded-md p-4">
            <div class="flex flex-col items-center gap-2">
                <p><b>Paso 1:</b> Complete el formulario de hoja de vida</p>

                <flux:button href="{{ route('cv.create.personal-info', $cv->id) }}"
                             variant="primary" wire:navigate>
                    Complete su hoja de vida
                </flux:button>
            </div>
        </div>

        <form wire:submit="send" class="border border-gray-300 rounded-md p-4 flex flex-col items-center gap-2">
            <p><b>Paso 2:</b> Digite el puesto que busca</p>

            <flux:input.group>
                <flux:input wire:model="search" placeholder="Digite el puesto"/>

                <flux:button icon="magnifying-glass"/>
            </flux:input.group>
        </form>
    </div>
    @endrole
</div>
