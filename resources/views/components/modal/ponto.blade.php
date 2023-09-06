<!-- Main modal -->
<div>
    <div id="modal" tabindex="-1" aria-hidden="true" wire:key="ModalTabelaCategoria" wire:ignore.self
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" onclick="closeModal()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Cadastrar Empresa</h3>
                    <form class="space-y-6" wire:submit.prevent="create">
                        <div>
                            <input type="text" wire:model="idItem" hidden>
                            <label class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                            <input type="text" wire:model="nome"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            @error('nome')
                                <div>
                                    <span class="text-red-500">{{ $message }}</span>
                                </div>
                            @enderror
                            <label class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">CNPJ</label>
                            <input type="text" wire:model="cnpj"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            @error('cnpj')
                                <div>
                                    <span class="text-red-500">{{ $message }}</span>
                                </div>
                            @enderror
                            <label class="block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-white">Endereço</label>
                            <input type="text" wire:model="endereco"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            @error('endereco')
                                <div>
                                    <span class="text-red-500">{{ $message }}</span>
                                </div>
                            @enderror
                            <label
                                class="block mb-2 mt-2 text-sm font-medium text-gray-900 dark:text-white">Ativo</label>
                            <select wire:model="sn_ativo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                <option selected value="S">Sim</option>
                                <option value="N">Não</option>
                            </select>
                            @error('sn_ativo')
                            <div>
                                <span class="text-red-500">{{ $message }}</span>
                            </div>
                         @enderror
                        </div>
                        <div class="flex justify-between">
                            <div class="w-full p-2">
                                <button type="submit"
                                    class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Salvar</button>
                            </div>
                            <div class="w-full p-2">
                                <button type="button" onclick="closeModal()"
                                    class="w-full  text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
