<x-layouts.app>
    <div class="flex flex-col gap-4 max-w-xl mx-auto">
        <hgroup class="space-y-2">
            <h1 class="text-3xl font-bold text-center">¡Felicidades!</h1>
            <h2 class="text-2xl text-center">¡Has Completado Tu Hoja De Vida!</h2>
            <p class="text-center">
                Ya puedes empezar a postularte a ofertas de trabajo, Ademas puedes descargar tu hoja de vida o
                imprimirla
            </p>
        </hgroup>

        <flux:button href="{{ route('cv.pdf') }}" target="_blank" variant="primary" color="blue" icon="document-text">
            Ver Hoja De Vida
        </flux:button>

        <form method="GET" action="{{ route('offers.index') }}"
              class="border border-gray-300 rounded-md p-4 flex flex-col items-center gap-2">
            <h3 class="text-lg font-bold text-center">¡Postulate a una oferta de trabajo!</h3>

            <p class="text-center">Digite el puesto que buscas y postulate</p>

            <flux:input.group>
                <flux:input name="search" placeholder="Puesto Que Buscas" required/>

                <flux:button type="submit" icon="magnifying-glass"/>
            </flux:input.group>
        </form>
    </div>
</x-layouts.app>
