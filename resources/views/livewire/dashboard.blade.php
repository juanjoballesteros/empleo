<div>
    @role('candidato')
    <div>
        <h2 class="text-2xl font-bold text-center">Bienvenido {{ request()->user()->name }}</h2>

        <div class="border border-gray-300 rounded-md p-4">
            <div class="flex flex-col items-center gap-2">
                <p>Para continuar complete el formulario de hoja de vida:</p>

                <flux:button href="{{ route('cv.create.personal-info', $cv->id) }}"
                             variant="primary" wire:navigate>
                    Complete su hoja de vida
                </flux:button>
            </div>
        </div>
    </div>
    @endrole
</div>
