<div class="max-md:hidden">
    <flux:navbar class="flex justify-center">
        <flux:navbar.item href="{{ route('cv.personal-info') }}" wire:navigate>
            1. Información Personal
            @if ($cv->personalInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.contact-info') }}" wire:navigate>
            2. Información De Contacto
            @if ($cv->contactInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.residence-info') }}" wire:navigate>
            3. Información De Residencia
            @if ($cv->residenceInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>
    </flux:navbar>

    <flux:navbar class="flex justify-center mb-2">
        <flux:navbar.item href="{{ route('cv.basic-education-info') }}" wire:navigate>
            4. Educación Básica
            @if ($cv->basic)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.higher-education-info') }}" wire:navigate>
            5. Educación Superior
            @if ($cv->high)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.work-experience-info') }}" wire:navigate>
            6. Experiencia Laboral
            @if ($cv->work)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.language-info') }}" wire:navigate>
            7. Idiomas
            @if ($cv->lang)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>
    </flux:navbar>
</div>

<div class="mb-2 md:hidden">
    <h2 class="text-2xl font-bold text-center">Cree su hoja de vida</h2>
</div>
