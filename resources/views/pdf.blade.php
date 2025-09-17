<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => config('app.name', 'Laravel')])
</head>

<body>
@php
    if (!function_exists('language')) {
        function language($type): string
        {
            return match ($type) {
                'MB' => 'Muy Bien',
                'B' => 'Bien',
                'R' => 'Regular'
            };
        }
    }
@endphp

<div class="flex h-screen">
    <div class="w-1/3 h-full bg-gray-200 p-4">
        @if($cv->personalInfo->getFirstMediaUrl('profile'))
            {{-- Imagen De Perfil --}}
            <div class="p-2 w-60 h-60 bg-white rounded-full">
                <div class="w-56 h-56 overflow-hidden rounded-full">
                    <img src="{{ $cv->personalInfo->getFirstMediaUrl('profile') }}"
                         alt="Perfil" class="w-full h-full object-cover"/>
                </div>
            </div>
        @endif

        {{-- Sobre Mi --}}
        <div>
            <h3 class="text-gray-800 text-xl font-bold mt-10">
                Sobre Mi
            </h3>
            <hr class="p-0.5 my-1 bg-gray-500 w-40">
            <p>{{ $cv->personalInfo->description ?? '' }}</p>
        </div>

        {{-- Informacion De Contacto --}}
        <div>
            <h3 class="text-gray-800 text-xl font-bold mt-10">
                Información De Contacto
            </h3>
            <hr class="p-0.5 my-1 bg-gray-500 w-40">
            <p>Numero De Teléfono: <br> +57 {{ $cv->contactInfo->phone_number }}</p>
            <p>Correo Electrónico: {{ $cv->contactInfo->email }}</p>
        </div>
    </div>

    <div class="w-2/3 h-full p-4">
        <h1 class="text-4xl font-bold mb-2">
            {{ $cv->personalInfo->first_name }} {{ $cv->personalInfo->second_name }}
            {{ $cv->personalInfo->first_surname }} {{ $cv->personalInfo->second_surname }}
        </h1>

        @if ($cv->workExperiences->count())
            {{-- Experiencia Laboral --}}
            <h2 class="text-2xl font-bold mt-10">
                Experiencia Laboral
            </h2>
            <hr class="p-0.5 my-1 bg-gray-500 w-80">
            @foreach ($cv->workExperiences as $workExperience)
                <p>{{ $workExperience->post }} | {{ $workExperience->name }}</p>
                <p>{{ $workExperience->date_start->toDateString() }}
                    - {{ $workExperience->date_end?->toDateString() ?? 'Actualmente' }}</p>
            @endforeach
        @endif

        @if ($cv->higherEducations->count())
            {{-- Educacion Superior --}}
            <h2 class="text-2xl font-bold mt-10">
                Educación Superior
            </h2>
            <hr class="p-0.5 my-1 bg-gray-500 w-80">
            @foreach ($cv->higherEducations as $higherEducation)
                <p>{{ $higherEducation->program }}</p>
                <p>{{ $higherEducation->date_start->format('m-Y') }}
                    - {{ $higherEducation->date_end?->format('m-Y') ?? 'Actualmente' }}</p>
            @endforeach
        @endif

        @if ($cv->languageInfos->count())
            {{-- Educacion Lenguas --}}
            <h2 class="text-2xl font-bold mt-10">
                Idiomas
            </h2>
            <hr class="p-0.5 my-1 bg-gray-500 w-80">
            @foreach ($cv->languageInfos as $languageInfo)
                <p><b>{{ $languageInfo->name }}</b></p>
                <p>Lo escribo: {{ language($languageInfo->write) }}</p>
                <p>Lo hablo: {{ language($languageInfo->speak) }}</p>
                <p>Lo leo: {{ language($languageInfo->read) }}</p>
            @endforeach
        @endif
    </div>
</div>

@pageBreak

<div class="flex flex-col items-center justify-center h-screen gap-40">
    <img src="{{ $cv->personalInfo->getFirstMediaUrl('front') }}"
         class="w-3/5 h-max" alt="Cedula frente"/>

    <img src="{{ $cv->personalInfo->getFirstMediaUrl('front') }}"
         class="w-3/5 h-max" alt="Cedula atras"/>
</div>

@if ($cv->basicEducationInfo)
    @pageBreak
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $cv->basicEducationInfo->getFirstMediaUrl() }}" class="w-full">
    </div>
@endif

@forelse ($cv->higherEducations as $higherEducation)
    @pageBreak
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $higherEducation->getFirstMediaUrl() }}" class="w-full">
    </div>
@empty
@endforelse

@forelse ($cv->workExperiences as $workExperience)
    @pageBreak
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $workExperience->getFirstMediaUrl() }}" class="w-full">
    </div>
@empty
@endforelse

@forelse ($cv->languageInfos as $languageInfo)
    @pageBreak
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $languageInfo->getFirstMediaUrl() }}" class="w-full">
    </div>
@empty
@endforelse
</body>

</html>
