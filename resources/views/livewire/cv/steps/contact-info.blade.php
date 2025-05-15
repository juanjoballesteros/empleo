<div>
    <form wire:submit="store" class="bg-white shadow-sm rounded-lg p-4 m-4">
        @include('layouts.wizard.navigation')

        <div class="sm:flex gap-2 mb-2">
            <div class="flex-1">
                <flux:input wire:model="phone_number" label="Teléfono*" required autofocus/>
            </div>

            <div class="flex-1">
                <flux:input wire:model="email" label="Correo*" required/>
            </div>
        </div>

        @include('layouts.wizard.footer')
    </form>
</div>
