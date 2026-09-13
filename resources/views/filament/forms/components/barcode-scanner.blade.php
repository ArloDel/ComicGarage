<div class="p-4 bg-gray-50 border border-gray-200 rounded-xl dark:bg-gray-900 dark:border-gray-700">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <div x-data="{
        html5QrCode: null,
        isScanning: false,
        
        async startScanner() {
            this.isScanning = true;
            this.html5QrCode = new Html5Qrcode('reader');
            const config = { fps: 10, qrbox: { width: 250, height: 150 } };
            
            try {
                await this.html5QrCode.start(
                    { facingMode: 'environment' }, 
                    config, 
                    (decodedText) => {
                        // Mengisi field isbn di form Filament
                        $wire.set('data.isbn', decodedText);
                        this.stopScanner();
                        
                        // Opsional: Bunyi beep atau alert
                        alert('Barcode Terdeteksi: ' + decodedText);
                    }
                );
            } catch (err) {
                console.error('Gagal akses kamera', err);
                this.isScanning = false;
            }
        },

        async stopScanner() {
            if (this.html5QrCode) {
                await this.html5QrCode.stop();
                await this.html5QrCode.clear();
            }
            this.isScanning = false;
        }
    }" class="text-center">
        
        <div id="reader" x-show="isScanning" class="mx-auto rounded-lg overflow-hidden border-2 border-primary-500 mb-4" style="max-width: 500px;"></div>

        <div class="flex justify-center gap-3">
            <template x-if="!isScanning">
                <button type="button" x-on:click="startScanner()" class="flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-500 transition">
                    <x-heroicon-m-camera class="w-5 h-5"/>
                    Scan Barcode Komik
                </button>
            </template>

            <template x-if="isScanning">
                <button type="button" x-on:click="stopScanner()" class="px-4 py-2 bg-danger-600 text-white rounded-lg hover:bg-danger-500 transition">
                    Berhenti
                </button>
            </template>
        </div>
    </div>
</div>