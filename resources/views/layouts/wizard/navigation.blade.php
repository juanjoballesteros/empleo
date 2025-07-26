<div class="max-md:hidden" xmlns:flux="http://www.w3.org/1999/html">
    <flux:navbar class="flex justify-center">
        <flux:navbar.item href="{{ route('cv.create.personal-info') }}" wire:navigate>
            Información Personal
            @if ($cv->personalInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.birth-info') }}" wire:navigate>
            Información De Nacimiento
            @if ($cv->birthInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.contact-info') }}" wire:navigate>
            Información De Contacto
            @if ($cv->contactInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.residence-info') }}" wire:navigate>
            Información De Residencia
            @if ($cv->residenceInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>
    </flux:navbar>

    <flux:navbar class="flex justify-center mb-2">
        <flux:navbar.item href="{{ route('cv.create.basic-education-info') }}" wire:navigate>
            Educación Básica
            @if ($cv->basicEducationInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.higher-education-info') }}" wire:navigate>
            Educación Superior
            @if ($cv->higherEducations->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.work-experience-info') }}" wire:navigate>
            Experiencia Laboral
            @if ($cv->workExperiences->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>

        <flux:navbar.item href="{{ route('cv.create.language-info') }}" wire:navigate>
            Idiomas
            @if ($cv->languageInfos->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navbar.item>
    </flux:navbar>
</div>

<div class="mb-4 md:hidden">
    <flux:navlist>
        <flux:navlist.item href="{{ route('cv.create.personal-info') }}" wire:navigate>
            Información Personal
            @if ($cv->personalInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.birth-info') }}" wire:navigate>
            Información De Nacimiento
            @if ($cv->birthInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.contact-info') }}" wire:navigate>
            Información De Contacto
            @if ($cv->contactInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.residence-info') }}" wire:navigate>
            Información De Residencia
            @if ($cv->residenceInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.basic-education-info') }}" wire:navigate>
            Educación Básica
            @if ($cv->basicEducationInfo?->check)
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.higher-education-info') }}" wire:navigate>
            Educación Superior
            @if ($cv->higherEducations->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.work-experience-info') }}" wire:navigate>
            Experiencia Laboral
            @if ($cv->workExperiences->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.create.language-info') }}" wire:navigate>
            Idiomas
            @if ($cv->languageInfos->count())
                <flux:badge icon="check" color="green" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>
    </flux:navlist>
</div>
