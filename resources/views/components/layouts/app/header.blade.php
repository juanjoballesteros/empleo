<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
       wire:navigate>
        <x-app-logo/>
    </a>

    @guest
        <flux:spacer/>

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item href="{{ route('login') }}" wire:navigate>
                {{ __('Log In') }}
            </flux:navbar.item>

            <flux:navbar.item href="{{ route('select') }}" wire:navigate>
                {{ __('Register') }}
            </flux:navbar.item>
        </flux:navbar>
    @endguest

    @auth
        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="layout-grid" href="{{ route('dashboard') }}" wire:navigate>
                {{ __('Dashboard') }}
            </flux:navbar.item>

            @if(auth()->user()->userable instanceof App\Models\Company)
                <flux:navbar.item href="{{ route('company.offers.index') }}" wire:navigate>
                    Ofertas De Empleo
                </flux:navbar.item>
            @endif

            @if(auth()->user()->userable instanceof App\Models\Candidate)
                <flux:navbar.item href="{{ route('cv.pdf') }}" target="_blank">
                    Ver Mi Hoja De Vida
                </flux:navbar.item>

                <flux:navbar.item href="{{ route('cv.personal-info') }}" wire:navigate>
                    Editar Mi Hoja De Vida
                </flux:navbar.item>

                <flux:navbar.item href="{{ route('cv.documents') }}" wire:navigate>
                    Carpeta Digital
                </flux:navbar.item>

                <flux:navbar.item href="{{ route('offers.index') }}" wire:navigate>
                    Buscar Ofertas De Empleo
                </flux:navbar.item>
            @endif
        </flux:navbar>

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
    @endauth
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
              class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        @guest
            <flux:navlist.item href="{{ route('login') }}" wire:navigate>
                {{ __('Log In') }}
            </flux:navlist.item>

            <flux:navlist.item href="{{ route('select') }}" wire:navigate>
                {{ __('Register') }}
            </flux:navlist.item>
        @endguest

        @auth
            <flux:navlist.item icon="layout-grid" :href="route('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </flux:navlist.item>

            @if(auth()->user()->userable instanceof App\Models\Company)
                <flux:navlist.item href="{{ route('company.offers.index') }}" wire:navigate>
                    Ofertas De Empleo
                </flux:navlist.item>
            @endif

            @if(auth()->user()->userable instanceof App\Models\Candidate)
                <flux:navlist.item href="{{ route('cv.pdf') }}" target="_blank">
                    Ver Mi Hoja De Vida
                </flux:navlist.item>

                <flux:navlist.item href="{{ route('cv.personal-info') }}" wire:navigate>
                    Editar Mi Hoja De Vida
                </flux:navlist.item>

                <flux:navlist.item href="{{ route('cv.documents') }}" wire:navigate>
                    Carpeta Digital
                </flux:navlist.item>

                <flux:navlist.item href="{{ route('offers.index') }}" wire:navigate>
                    Buscar Ofertas De Empleo
                </flux:navlist.item>
            @endif
        @endauth
    </flux:navlist>
</flux:sidebar>

{{ $slot }}

@fluxScripts
</body>
</html>
