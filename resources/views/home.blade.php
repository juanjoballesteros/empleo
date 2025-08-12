<x-layouts.app>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                alt="People working" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight sm:text-6xl">
                    Mejorando el futuro laboral de Colombia
                </h1>
                <p class="mt-6 max-w-3xl mx-auto text-xl text-blue-100">
                    Conectamos talento colombiano con oportunidades formales de empleo para mejorar la calidad de vida y
                    contribuir al desarrollo del país.
                </p>
                <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                    <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
                        <a href="{{ route('select') }}"
                           class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 sm:px-8">
                            Registrarse
                        </a>
                        <a href="{{ route('login') }}"
                           class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 sm:px-8">
                            Iniciar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Beneficios</h2>
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">
                    De la informalidad a la formalidad
                </p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                    Transformamos el panorama laboral colombiano con oportunidades que mejoran la calidad de vida.
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <span
                                        class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Empleos Formales</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Accede a oportunidades laborales con todos los beneficios legales, seguridad social
                                    y estabilidad.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <span
                                        class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Herramientas
                                    Profesionales</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Crea tu hoja de vida digital, gestiona tus aplicaciones y mejora tu perfil
                                    profesional.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <span
                                        class="inline-flex items-center justify-center p-3 bg-indigo-500 rounded-md shadow-lg">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </span>
                                </div>
                                <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Empresas
                                    Verificadas</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Conectamos con empresas comprometidas con el desarrollo económico y social de
                                    Colombia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resume Creation Section -->
    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div class="relative">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Crea tu Hoja de Vida en minutos
                    </h2>
                    <p class="mt-4 text-lg text-gray-500">
                        Nuestra plataforma te permite crear una hoja de vida profesional de manera rápida y sencilla,
                        simplemente completando un formulario intuitivo.
                    </p>

                    <dl class="mt-10 space-y-10">
                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Proceso Paso a Paso</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Te guiamos a través de un proceso estructurado para completar cada sección de tu hoja de
                                vida: información personal, educación, experiencia laboral y habilidades.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Formato Profesional</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Generamos automáticamente un documento con diseño profesional que puedes descargar,
                                compartir o usar directamente en nuestra plataforma.
                            </dd>
                        </div>

                        <div class="relative">
                            <dt>
                                <div
                                    class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Mayor Visibilidad</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                Tu hoja de vida optimizada será visible para empresas que buscan talento como el tuyo,
                                aumentando tus posibilidades de conseguir empleo.
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-10 lg:mt-0 relative">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg overflow-hidden">
                        <img class="w-full"
                             src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                             alt="Persona completando un formulario">
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('select') }}"
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Crea tu hoja de vida ahora
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Sections -->
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
            <div class="relative">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Para Candidatos</h2>
                <p class="mt-4 text-lg text-gray-500">
                    Encuentra oportunidades laborales que se ajusten a tus habilidades y aspiraciones profesionales.
                </p>

                <dl class="mt-10 space-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Búsqueda Inteligente</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Filtra ofertas por ubicación, salario, sector y más para encontrar el trabajo ideal.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Perfil Destacado</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Destaca tus habilidades y experiencia para atraer a los mejores empleadores.
                        </dd>
                    </div>
                </dl>

                <div class="mt-10">
                    <a href="{{ route('register.candidate') }}"
                       class="text-base font-medium text-indigo-600 hover:text-indigo-500">
                        Regístrate como candidato <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="mt-12 lg:mt-0">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Para Empresas</h2>
                <p class="mt-4 text-lg text-gray-500">
                    Encuentre el talento colombiano que su empresa necesita para crecer y prosperar.
                </p>

                <dl class="mt-10 space-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Talento Calificado</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Acceda a una amplia base de candidatos con las habilidades que su empresa necesita.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Contratación Segura</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Herramientas para gestionar el proceso de contratación de manera eficiente y segura.
                        </dd>
                    </div>
                </dl>

                <div class="mt-10">
                    <a href="{{ route('register.company') }}"
                       class="text-base font-medium text-indigo-600 hover:text-indigo-500">
                        Regístrate como empresa <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="bg-indigo-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Impulsando el empleo formal en Colombia
                </h2>
                <p class="mt-3 text-xl text-indigo-200 sm:mt-4">
                    Nuestro compromiso es mejorar la calidad de vida de los colombianos a través de oportunidades
                    laborales dignas.
                </p>
            </div>
            <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                <div class="flex flex-col">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                        Ofertas de Empleo
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        +5,000
                    </dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                        Candidatos Registrados
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        +25,000
                    </dd>
                </div>
                <div class="flex flex-col mt-10 sm:mt-0">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                        Empresas Asociadas
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        +1,200
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Testimonial Section -->
    <div class="bg-white py-16 lg:py-24">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative py-8 px-8 bg-indigo-600 rounded-xl shadow-2xl overflow-hidden lg:px-16 lg:grid lg:grid-cols-2 lg:gap-x-8">
                <div class="relative lg:col-span-1">
                    <blockquote class="mt-8">
                        <div class="relative text-lg font-medium text-white md:flex-grow">
                            <svg
                                class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-indigo-400"
                                fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                <path
                                    d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                            </svg>
                            <p class="relative">
                                Gracias a esta plataforma encontré un empleo formal después de años en la informalidad.
                                Ahora tengo seguridad social y un salario digno para mi familia.
                            </p>
                        </div>

                        <footer class="mt-4">
                            <p class="text-base font-semibold text-indigo-200">Carolina Ramírez, Bogotá</p>
                        </footer>
                    </blockquote>
                </div>
                <div class="relative lg:col-span-1">
                    <blockquote class="mt-8">
                        <div class="relative text-lg font-medium text-white md:flex-grow">
                            <svg
                                class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-indigo-400"
                                fill="currentColor" viewBox="0 0 32 32">
                                <path
                                    d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                            </svg>
                            <p class="relative">
                                Como empresa, hemos encontrado talento excepcional a través de esta plataforma. El
                                proceso de contratación es sencillo y los candidatos están bien calificados.
                            </p>
                        </div>
                        <footer class="mt-4">
                            <p class="text-base font-semibold text-indigo-200">Juan Martínez, Director de RRHH</p>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <span class="block">¿Listo para mejorar tu futuro laboral?</span>
                <span class="block text-indigo-600">Únete hoy a nuestra plataforma.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('select') }}"
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Comenzar ahora
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
