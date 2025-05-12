<x-layouts.auth>
    <div class="border border-gray-300 rounded-lg p-4">
        <div class="text-center mb-4">
            <h3 class="text-xl font-bold">
                Selecciona tu perfil
            </h3>

            <p>Selecciona si eres una empresa o si eres un candidato</p>
        </div>

        <div class="flex gap-4 justify-between">
            <flux:button href="{{ route('candidate.register') }}" variant="primary" class="w-full">
                Candidato
            </flux:button>

            <flux:separator vertical/>

            <flux:button href="{{ route('company.register') }}" variant="primary" class="w-full">
                Empresa
            </flux:button>
        </div>
    </div>
</x-layouts.auth>
