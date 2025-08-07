<div>
    <form wire:submit="store">
        @include('layouts.wizard.navigation')

        <h4 class="text-lg text-center mb-2">2. Información De Contacto</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="phone_number" label="Teléfono*" required autofocus/>

            <flux:input wire:model="email" label="Correo*" required/>
        </div>

        @include('layouts.wizard.footer')
    </form>
</div>
