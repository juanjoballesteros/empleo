<div>
    <flux:modal name="camera" @close="stopCamera">
        <flux:heading size="lg">Tomar Foto</flux:heading>

        <div class="p-2">
            <video id="video" autoplay class="rounded-md m-auto h-64"></video>

            <div class="flex flex-col gap-2">
                <flux:select id="camera" label="Seleccione una camara">
                </flux:select>

                <flux:button type="button" id="snap" variant="primary" icon="camera">
                    Tomar Foto
                </flux:button>
            </div>

            <canvas id="canvas" hidden></canvas>
        </div>
    </flux:modal>

    @script
    <script type="module">
        const video = document.getElementById('video')
        const canvas = document.getElementById('canvas')
        const snapButton = document.getElementById('snap')
        const camera = document.getElementById('camera')

        $js('startCamera', () => {
            getCameraSelection().then(() => {
                play()
            })
        })

        $js('stopCamera', () => {
            stopCamera()
        })

        camera.onchange = () => {
            play()
        }

        snapButton.addEventListener('click', () => {
            const context = canvas.getContext('2d')
            context.clearRect(0, 0, canvas.width, canvas.height)

            if ($wire.file === 'document_front' || $wire.file === 'document_back') {
                canvas.width = video.videoHeight
                canvas.height = video.videoWidth

                context.translate(canvas.width / 2, canvas.height / 2)

                context.rotate(Math.PI / 2)

                context.drawImage(video, -video.videoWidth / 2, -video.videoHeight / 2, video.videoWidth, video.videoHeight)
            } else {
                canvas.width = video.videoWidth
                canvas.height = video.videoHeight

                context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
            }

            let img = dataURLToFile(canvas.toDataURL('image/png'), $wire.file + '.png')
            video.pause()
            video.srcObject.getTracks().forEach(track => track.stop())

            Livewire.find($wire.idComponent).upload($wire.file, img, () => {
                $wire.dispatch('photoTaken')
            })
            Flux.modal('camera').close()
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

        const play = () => {
            navigator.mediaDevices.getUserMedia({
                video: {
                    height: 720,
                    width: 1280,
                    deviceId: camera.value
                }
            }).then(stream => {
                video.srcObject = stream
            })
        }

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
