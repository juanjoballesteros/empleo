<div>
    @include('layouts.wizard.navigation')

    <div wire:show="!show" class="flex flex-col gap-4 items-center max-w-lg m-auto mt-4">
        <h3 class="text-lg text-center">¿Usted Sabe Un Idioma Diferente Al Español Que: Hable, Lea y Escriba?</h3>
        
        <flux:button variant="primary" color="blue" wire:click="show = true" class="w-full">Sí</flux:button>

        <flux:separator text="o"/>

        <flux:button wire:click="check" class="w-full">
            No
        </flux:button>
    </div>

    <div wire:show="show" wire:cloak>
        <h4 class="text-lg text-center mb-2">7. Idiomas</h4>

        <form wire:submit="store"
              class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-gray-2/50 rounded-sm p-4 mb-2">
            <flux:select wire:model="name" label="Idioma diferente al español que: hable, lea y escriba*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="Afrikáans">Afrikáans</flux:select.option>
                <flux:select.option value="Albanés">Albanés</flux:select.option>
                <flux:select.option value="Amárico">Amárico</flux:select.option>
                <flux:select.option value="Árabe">Árabe</flux:select.option>
                <flux:select.option value="Armenio">Armenio</flux:select.option>
                <flux:select.option value="Azerbaiyano">Azerbaiyano</flux:select.option>
                <flux:select.option value="Bascuence">Bascuence</flux:select.option>
                <flux:select.option value="Bielorruso">Bielorruso</flux:select.option>
                <flux:select.option value="Bengalí">Bengalí</flux:select.option>
                <flux:select.option value="Bosnio">Bosnio</flux:select.option>
                <flux:select.option value="Búlgaro">Búlgaro</flux:select.option>
                <flux:select.option value="Catalán">Catalán</flux:select.option>
                <flux:select.option value="Cebuano">Cebuano</flux:select.option>
                <flux:select.option value="Chewa">Chewa</flux:select.option>
                <flux:select.option value="Chino">Chino</flux:select.option>
                <flux:select.option value="Corso">Corso</flux:select.option>
                <flux:select.option value="Croata">Croata</flux:select.option>
                <flux:select.option value="Checo">Checo</flux:select.option>
                <flux:select.option value="Danés">Danés</flux:select.option>
                <flux:select.option value="Neerlandés">Neerlandés</flux:select.option>
                <flux:select.option value="Inglés">Inglés</flux:select.option>
                <flux:select.option value="Esperanto">Esperanto</flux:select.option>
                <flux:select.option value="Estonio">Estonio</flux:select.option>
                <flux:select.option value="Finés">Finés</flux:select.option>
                <flux:select.option value="Francés">Francés</flux:select.option>
                <flux:select.option value="Frisón">Frisón</flux:select.option>
                <flux:select.option value="Gallego">Gallego</flux:select.option>
                <flux:select.option value="Georgiano">Georgiano</flux:select.option>
                <flux:select.option value="Alemán">Alemán</flux:select.option>
                <flux:select.option value="Griego">Griego</flux:select.option>
                <flux:select.option value="Guyaratí">Guyaratí</flux:select.option>
                <flux:select.option value="Criollo haitiano">Criollo haitiano</flux:select.option>
                <flux:select.option value="Hausa">Hausa</flux:select.option>
                <flux:select.option value="Hawaiano">Hawaiano</flux:select.option>
                <flux:select.option value="Hebreo">Hebreo</flux:select.option>
                <flux:select.option value="Hindi">Hindi</flux:select.option>
                <flux:select.option value="Hmong">Hmong</flux:select.option>
                <flux:select.option value="Húngaro">Húngaro</flux:select.option>
                <flux:select.option value="Islandés">Islandés</flux:select.option>
                <flux:select.option value="Igbo">Igbo</flux:select.option>
                <flux:select.option value="Indonesio">Indonesio</flux:select.option>
                <flux:select.option value="Irlandés">Irlandés</flux:select.option>
                <flux:select.option value="Italiano">Italiano</flux:select.option>
                <flux:select.option value="Japonés">Japonés</flux:select.option>
                <flux:select.option value="Javanés">Javanés</flux:select.option>
                <flux:select.option value="Canarés">Canarés</flux:select.option>
                <flux:select.option value="Kazajo">Kazajo</flux:select.option>
                <flux:select.option value="Jemer">Jemer</flux:select.option>
                <flux:select.option value="Kinyarwanda">Kinyarwanda</flux:select.option>
                <flux:select.option value="Coreano">Coreano</flux:select.option>
                <flux:select.option value="Kurdo">Kurdo</flux:select.option>
                <flux:select.option value="Kirguís">Kirguís</flux:select.option>
                <flux:select.option value="Laosiano">Laosiano</flux:select.option>
                <flux:select.option value="Latín">Latín</flux:select.option>
                <flux:select.option value="Letón">Letón</flux:select.option>
                <flux:select.option value="Lituano">Lituano</flux:select.option>
                <flux:select.option value="Luxemburgués">Luxemburgués</flux:select.option>
                <flux:select.option value="Macedonio">Macedonio</flux:select.option>
                <flux:select.option value="Malgache">Malgache</flux:select.option>
                <flux:select.option value="Malayo">Malayo</flux:select.option>
                <flux:select.option value="Malabar">Malabar</flux:select.option>
                <flux:select.option value="Maltés">Maltés</flux:select.option>
                <flux:select.option value="Maorí">Maorí</flux:select.option>
                <flux:select.option value="Maratí">Maratí</flux:select.option>
                <flux:select.option value="Mongol">Mongol</flux:select.option>
                <flux:select.option value="Birmano">Birmano</flux:select.option>
                <flux:select.option value="Nepalí">Nepalí</flux:select.option>
                <flux:select.option value="Noruego">Noruego</flux:select.option>
                <flux:select.option value="Oriya">Oriya</flux:select.option>
                <flux:select.option value="Pastún">Pastún</flux:select.option>
                <flux:select.option value="Persa">Persa</flux:select.option>
                <flux:select.option value="Polaco">Polaco</flux:select.option>
                <flux:select.option value="Portugués">Portugués</flux:select.option>
                <flux:select.option value="Punjabi">Punjabi</flux:select.option>
                <flux:select.option value="Rumano">Rumano</flux:select.option>
                <flux:select.option value="Ruso">Ruso</flux:select.option>
                <flux:select.option value="Samoano">Samoano</flux:select.option>
                <flux:select.option value="Gaélico escocés">Gaélico escocés</flux:select.option>
                <flux:select.option value="Serbio">Serbio</flux:select.option>
                <flux:select.option value="Sesotho">Sesotho</flux:select.option>
                <flux:select.option value="Shona">Shona</flux:select.option>
                <flux:select.option value="Sindhi">Sindhi</flux:select.option>
                <flux:select.option value="Cingalés">Cingalés</flux:select.option>
                <flux:select.option value="Eslovaco">Eslovaco</flux:select.option>
                <flux:select.option value="Esloveno">Esloveno</flux:select.option>
                <flux:select.option value="Somalí">Somalí</flux:select.option>
                <flux:select.option value="Sundanés">Sundanés</flux:select.option>
                <flux:select.option value="Suajili">Suajili</flux:select.option>
                <flux:select.option value="Sueco">Sueco</flux:select.option>
                <flux:select.option value="Tagalo">Tagalo</flux:select.option>
                <flux:select.option value="Tayiko">Tayiko</flux:select.option>
                <flux:select.option value="Tamil">Tamil</flux:select.option>
                <flux:select.option value="Tártaro">Tártaro</flux:select.option>
                <flux:select.option value="Telugu">Telugu</flux:select.option>
                <flux:select.option value="Tailandés">Tailandés</flux:select.option>
                <flux:select.option value="Turco">Turco</flux:select.option>
                <flux:select.option value="Turcomano">Turcomano</flux:select.option>
                <flux:select.option value="Ucraniano">Ucraniano</flux:select.option>
                <flux:select.option value="Urdu">Urdu</flux:select.option>
                <flux:select.option value="Uigur">Uigur</flux:select.option>
                <flux:select.option value="Uzbeko">Uzbeko</flux:select.option>
                <flux:select.option value="Vietnamita">Vietnamita</flux:select.option>
                <flux:select.option value="Galés">Galés</flux:select.option>
                <flux:select.option value="Xhosa">Xhosa</flux:select.option>
                <flux:select.option value="Yidis">Yidis</flux:select.option>
                <flux:select.option value="Yoruba">Yoruba</flux:select.option>
                <flux:select.option value="Zulú">Zulú</flux:select.option>
            </flux:select>

            <flux:select wire:model="speak" label="Lo Habla*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="MB">Muy Bien</flux:select.option>
                <flux:select.option value="B">Bien</flux:select.option>
                <flux:select.option value="R">Regular</flux:select.option>
            </flux:select>

            <flux:select wire:model="read" label="Lo Lee*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="MB">Muy Bien</flux:select.option>
                <flux:select.option value="B">Bien</flux:select.option>
                <flux:select.option value="R">Regular</flux:select.option>
            </flux:select>

            <flux:select wire:model="write" label="Lo Escribe*" required>
                <flux:select.option value="">Seleccionar...</flux:select.option>
                <flux:select.option value="MB">Muy Bien</flux:select.option>
                <flux:select.option value="B">Bien</flux:select.option>
                <flux:select.option value="R">Regular</flux:select.option>
            </flux:select>

            <div class="md:col-span-2">
                @if($certificate)
                    <div class="flex flex-col gap-4">
                        <div class="h-32 bg-gray-100 w-full rounded-lg">
                            <img src="{{ $certificate->temporaryUrl() }}" alt="Certificación"
                                 class="h-32 object-contain m-auto">
                        </div>

                        <flux:button wire:click="$set('certification', null)">
                            Cambiar Certificado
                        </flux:button>
                    </div>
                @else
                    <div x-data="{ uploading: false, progress: 0 }"
                         x-on:livewire-upload-start="uploading = true"
                         x-on:livewire-upload-finish="uploading = false"
                         x-on:livewire-upload-cancel="uploading = false"
                         x-on:livewire-upload-error="uploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="flex flex-col md:flex-row gap-2">
                            <div @click="$dispatch('openCamera', { id: $wire.id, file: 'certificate' })"
                                 class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                                <flux:icon.camera class="size-8 text-gray-500"/>

                                <p class="text-gray-500">Toma Una Foto Del Certificado</p>
                            </div>

                            <label
                                class="flex flex-col items-center cursor-pointer w-full max-h-24 border-2 border-gray-200 rounded-lg p-4">
                                <flux:icon.arrow-up-on-square class="size-8 text-gray-500"/>

                                <p class="text-gray-500">Sube Tu Certificado</p>

                                <input type="file" wire:model="certificate" name="file" class="hidden" accept="image/*">

                                <flux:error name="file"/>
                            </label>
                        </div>

                        <span wire:loading wire:target="certificate" class="text-sm">Cargando...</span>
                        <div x-show="uploading" x-cloak class="w-full bg-gray-200 rounded-full h-2 my-2">
                            <div x-bind:style="'width: ' + progress"
                                 class="bg-blue-600 h-full rounded-full transition-all duration-300 ease-out"></div>
                        </div>
                    </div>
                @endif
            </div>

            <flux:button type="submit" variant="primary" class="w-full md:col-span-2">Añadir</flux:button>

            <livewire:camera/>
        </form>

        @if($languagesInfos->count())
            <div class="border border-gray-300 rounded-md overflow-x-auto my-2">
                <table class="table-auto min-w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-300">
                    <tr>
                        <th class="p-2">Idioma</th>
                        <th class="p-2">Lo Habla</th>
                        <th class="p-2">Lo Lee</th>
                        <th class="p-2">Lo Escribe</th>
                        <th class="p-2">Certificado</th>
                        <th class="p-2">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($languagesInfos as $languageInfo)
                        <tr>
                            <td class="p-2">{{ $languageInfo->name }}</td>
                            <td class="p-2">{{ $languageInfo->speak }}</td>
                            <td class="p-2">{{ $languageInfo->read }}</td>
                            <td class="p-2">{{ $languageInfo->write }}</td>
                            <td class="p-2">
                                <flux:button href="{{ $languageInfo->getFirstMediaUrl() }}"
                                             target="_blank" icon="photo" size="sm">
                                    Ver Certificado
                                </flux:button>
                            </td>
                            <td class="p-2">
                                <flux:button.group>
                                    <flux:button
                                        wire:click="$dispatch('edit', { languageInfo: {{ $languageInfo->id }} })"
                                        size="sm" icon="pencil">
                                        Editar
                                    </flux:button>

                                    <flux:button wire:click="delete({{ $languageInfo->id }})" variant="danger"
                                                 icon="trash"
                                                 size="sm">
                                        Eliminar
                                    </flux:button>
                                </flux:button.group>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <flux:callout variant="warning" icon="exclamation-circle" heading="No ha agregado información"/>
        @endif

        <livewire:cv.steps.language.edit/>

        <div class="flex justify-end">
            <flux:button wire:click="navigate" variant="primary">
                Ver PDF
            </flux:button>
        </div>
    </div>
</div>
