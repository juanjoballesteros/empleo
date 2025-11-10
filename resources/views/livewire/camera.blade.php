<div wire:ignore.self id="camera-container" class="hidden">
    <div class="absolute top-0 left-0 w-full h-full bg-white">
        <h2 class="text-2xl text-center font-bold">Toma una foto</h2>

        <div x-data class="p-2 mx-auto">
            <div x-show="$store.step == 1" class="mx-auto md:max-w-lg flex flex-col gap-2">
                <div wire:ignore class="relative">
                    <video id="video" autoplay
                           class="rounded-md m-auto sm:max-h-96 aspect-video object-cover"></video>

                    <div id="card-hover"
                         class="hidden absolute top-[5%] left-[10%] w-[80%] h-[90%] border-4 border-white rounded-xl"></div>

                    <div id="document-hover"
                         class="hidden absolute top-[5%] left-[26%] aspect-[1/1.414]  h-[90%] border-4 border-white rounded-xl"></div>
                </div>

                <flux:select id="camera" label="Seleccione una camara"></flux:select>

                <flux:button type="button" id="snap" variant="primary" icon="camera">
                    Tomar Foto
                </flux:button>

                <canvas id="canvas" hidden></canvas>
            </div>

            <div x-show="$store.step == 2" x-cloak class="mx-auto md:max-w-lg flex flex-col justify-items-center gap-2">
                <h3 class="text-xl text-center">Verifica la imagen</h3>

                <img id="scanned" alt="Imagen escaneada" class="sm:max-h-96 object-contain"/>

                <flux:button type="button" wire:click="$js.uploadFile" variant="primary" color="blue" icon="camera">
                    Continuar
                </flux:button>

                <flux:button type="button" @click="$store.step = 1" wire:click="$js.startCamera">
                    Tomar otra foto
                </flux:button>
            </div>
        </div>
    </div>

    <script src="https://docs.opencv.org/4.7.0/opencv.js" async data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/gh/ColonelParrot/jscanify@master/src/jscanify.min.js"
            data-navigate-once></script>

    @script
    <script type="module">
        Alpine.store('step', 1)

        const cameraContainer = document.getElementById('camera-container')
        const cameraParent = document.getElementById('camera-parent')
        const cardHover = document.getElementById('card-hover')
        const documentHover = document.getElementById('document-hover')
        const video = document.getElementById('video')
        const canvas = document.getElementById('canvas')
        const snapButton = document.getElementById('snap')
        const camera = document.getElementById('camera')
        const scanned = document.getElementById('scanned')
        let scannedCanvas = null

        $js('startCamera', () => {
            cameraContainer.classList.remove('hidden')

            getCameraSelection().then(() => {
                play()
            })
        })

        camera.onchange = () => {
            play()
        }

        const play = () => {
            navigator.mediaDevices.getUserMedia({
                video: {
                    height: 720,
                    width: 1280,
                    deviceId: camera.value
                }
            }).then(stream => {
                video.srcObject = stream

                if ($wire.file.includes('document')) {
                    cardHover.classList.remove('hidden')

                    return;
                }

                video.classList.remove('aspect-video')
                video.classList.add('aspect-[1/1.414]')
                documentHover.classList.remove('hidden')
            })
        }

        snapButton.addEventListener('click', () => {
            const context = canvas.getContext('2d')
            context.clearRect(0, 0, canvas.width, canvas.height)

            // Dimensiones del elemento video visible
            const displayWidth = video.clientWidth
            const displayHeight = video.clientHeight

            // Dimensiones reales del stream de video
            const videoWidth = video.videoWidth
            const videoHeight = video.videoHeight

            // Calcular el ratio de aspecto
            const videoRatio = videoWidth / videoHeight
            const displayRatio = displayWidth / displayHeight

            let sourceX = 0
            let sourceY = 0
            let sourceWidth = videoWidth
            let sourceHeight = videoHeight

            // Calcular el área de recorte (simulando object-cover)
            if (videoRatio > displayRatio) {
                // El video es más ancho, se recorta a los lados
                sourceWidth = videoHeight * displayRatio
                sourceX = (videoWidth - sourceWidth) / 2
            } else {
                // El video es más alto, se recorta arriba y abajo
                sourceHeight = videoWidth / displayRatio
                sourceY = (videoHeight - sourceHeight) / 2
            }

            // Establecer el tamaño del canvas al tamaño visible
            canvas.width = displayWidth
            canvas.height = displayHeight

            // Dibujar solo la parte visible del video
            context.drawImage(
                video,
                sourceX, sourceY, sourceWidth, sourceHeight,  // área de origen (recorte)
                0, 0, displayWidth, displayHeight              // área de destino (canvas)
            )

            const scanner = new jscanify()
            scannedCanvas = scanner.extractPaper(canvas, displayWidth, displayHeight)

            scanned.src = scannedCanvas.toDataURL('image/jpeg')
            Alpine.store('step', 2)

            video.pause()
            video.srcObject.getTracks().forEach(track => track.stop())
        })

        $js('uploadFile', () => {
            const img = dataURLToFile(scannedCanvas.toDataURL('image/jpeg'), $wire.file + '.jpeg')

            Livewire.find($wire.idComponent).upload($wire.file, img, () => {
                $wire.dispatch('photoTaken')
            })
            cameraContainer.classList.add('hidden')
            Alpine.store('step', 1)
        })

        const getCameraSelection = async () => {
            const devices = await navigator.mediaDevices.enumerateDevices()
            const videoDevices = devices.filter(device => device.kind === 'videoinput').reverse()
            let i = 1
            const options = videoDevices.map(videoDevice => {
                return `<flux:select.option value="${videoDevice.deviceId}">
                            Camara ${i++} (${videoDevice.label})
                        </flux:select.option>`
            })
            camera.innerHTML = options.join()
        };

        $js('stopCamera', () => {
            stopCamera()
        })

        const stopCamera = () => {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }

            const context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            canvas.width = 0;
            canvas.height = 0;
        }

        function dataURLToFile(dataURL, fileName) {
            const byteString = atob(dataURL.split(',')[1]);
            const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            const blob = new Blob([ab], {type: mimeString});
            return new File([blob], fileName, {type: mimeString});
        }
    </script>
    @endscript
</div>
