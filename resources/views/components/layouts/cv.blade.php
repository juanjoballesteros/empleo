<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <div class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0">
        <x-app-logo/>
    </div>

    <flux:spacer/>

    <!-- Desktop User Menu -->
    <flux:dropdown position="top" align="end">
        <flux:profile
            class="cursor-pointer"
            :avatar:name="auth()->user()->name"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog"
                                wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
              class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle icon="x-mark"/>

    <flux:navlist variant="outline">
        <flux:navlist.item href="{{ route('cv.personal-info') }}" wire:navigate>
            Información Personal
            @if ($cv->personalInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.contact-info') }}" wire:navigate>
            Información De Contacto
            @if ($cv->contactInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.residence-info') }}" wire:navigate>
            Información De Residencia
            @if ($cv->residenceInfo?->check)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.basic-education-info') }}" wire:navigate>
            Educación Básica
            @if ($cv->basic)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.higher-education-info') }}" wire:navigate>
            Educación Superior
            @if ($cv->high)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.work-experience-info') }}" wire:navigate>
            Experiencia Laboral
            @if ($cv->work)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>

        <flux:navlist.item href="{{ route('cv.language-info') }}" wire:navigate>
            Idiomas
            @if ($cv->lang)
                <flux:badge icon="check" color="green" size="sm" class="pr-0 pl-1"/>
            @endif
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

<flux:main container>
    {{ $slot }}
</flux:main>

@fluxScripts
</body>
</html>
