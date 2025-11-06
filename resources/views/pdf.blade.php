<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *, ::before, ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        /* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */
        *, ::after, ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after, ::before {
            --tw-content: ''
        }

        :host, html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b, strong {
            font-weight: bolder
        }

        code, kbd, pre, samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub, sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button, input, optgroup, select, textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button, select {
            text-transform: none
        }

        button, input:where([type=button]), input:where([type=reset]), input:where([type=submit]) {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button, ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote, dd, dl, figure, h1, h2, h3, h4, h5, h6, hr, p, pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu, ol, ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder, textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button], button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio, canvas, embed, iframe, img, object, svg, video {
            display: block;
            vertical-align: middle
        }

        img, video {
            max-width: 100%;
            height: auto
        }

        [hidden]:where(:not([hidden=until-found])) {
            display: none
        }

        .my-1 {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem
        }

        .mb-2 {
            margin-bottom: 0.5rem
        }

        .mt-10 {
            margin-top: 2.5rem
        }

        .flex {
            display: flex
        }

        .table {
            display: table
        }

        .table-cell {
            display: table-cell
        }

        .h-screen {
            height: 100vh
        }

        .h-56 {
            height: 14rem
        }

        .h-max {
            height: max-content
        }

        .w-1\/3 {
            width: 33.333333%
        }

        .w-2\/3 {
            width: 66.666667%
        }

        .w-3\/5 {
            width: 60%
        }

        .w-40 {
            width: 10rem
        }

        .w-56 {
            width: 14rem
        }

        .w-80 {
            width: 20rem
        }

        .w-full {
            width: 100%
        }

        .flex-col {
            flex-direction: column
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .gap-40 {
            gap: 10rem
        }

        .overflow-hidden {
            overflow: hidden
        }

        .rounded-full {
            border-radius: 9999px
        }

        .bg-gray-200 {
            --tw-bg-opacity: 1;
            background-color: rgb(229 231 235 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(107 114 128 / var(--tw-bg-opacity, 1))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
        }

        .object-cover {
            object-fit: cover
        }

        .p-0\.5 {
            padding: 0.125rem
        }

        .p-2 {
            padding: 0.5rem
        }

        .p-4 {
            padding: 1rem
        }

        .align-top {
            vertical-align: top
        }

        .align-middle {
            vertical-align: middle
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .font-bold {
            font-weight: 700
        }

        .text-gray-800 {
            --tw-text-opacity: 1;
            color: rgb(31 41 55 / var(--tw-text-opacity, 1))
        }
    </style>

    <style>
        html {
            margin: 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body class="h-screen">
<div class="table w-full">
    <div class="table-cell w-1/3 bg-gray-200 p-4" style="height: 97%">
        @if($cv->personalInfo->getFirstMediaPath('profile'))
            {{-- Imagen De Perfil --}}
            <div class="p-2 bg-white rounded-full">
                <div class="overflow-hidden rounded-full">
                    <img src="{{ $cv->personalInfo->getFirstMediaPath('profile') }}"
                         alt="Perfil" class="w-56 h-56 object-cover"/>
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

    <div class="table-cell align-top w-2/3 p-4">
        <h1 class="text-4xl font-bold mb-2">
            {{ $cv->personalInfo->first_name }} {{ $cv->personalInfo->second_name }}
            {{ $cv->personalInfo->first_surname }} {{ $cv->personalInfo->second_surname }}
        </h1>

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
    </div>
</div>

<div style="height: 100vh; text-align: center; padding-top: 10rem;">
    <img src="{{ $cv->personalInfo->getFirstMediaPath('front') }}"
         style="width: 60%; height: max-content;"
         alt="Documento frente"/>

    <div style="margin-top: 10rem;">
        <img src="{{ $cv->personalInfo->getFirstMediaPath('back') }}"
             style="width: 60%; height: max-content;"
             alt="Documento trasera"/>
    </div>
</div>

@if ($cv->basicEducationInfo)
    <div class="page-break"></div>
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $cv->basicEducationInfo->getFirstMediaUrl() }}" class="w-full">
    </div>
@endif

@foreach ($cv->higherEducations as $higherEducation)
    <div class="page-break"></div>
    <div class="h-screen flex flex-col justify-center align-middle">
        <img src="{{ $higherEducation->getFirstMediaPath() }}" class="w-full" alt="{{ $higherEducation->program }}">
    </div>
@endforeach

@foreach ($cv->workExperiences as $workExperience)
    <div class="page-break"></div>
    <div class="h-screen flex flex-col justify-center">
        <img src="{{ $workExperience->getFirstMediaPath() }}" class="w-full">
    </div>
@endforeach
</body>

</html>
