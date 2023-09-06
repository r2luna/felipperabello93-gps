<div>
        <div class="py-12" wire:ignore>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                        <div class="text-gray-500" id="acc"></div>
                        <input wire:model="retorno">
                    </div>
                    <button class="bg-blue-500 text-red-500" wire:click="getGps">Retorno</button>
                </div>
            </div>
        </div>
        @vite(['resources/js/gps.js'])
</div>
