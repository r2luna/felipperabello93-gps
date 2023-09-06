<div class="relative py-20 mb-20  bg-white dark:bg-gray-900">
    <div class="container mx-auto">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="inline-flex w-full">
            <div class="flex items-center justify-start pb-4 w-full">
                <div class="relative ml-4 pt-4">
            <button onclick="openModal()" wire:click="openModal()" id="dropdownRadioButton"

            class="inline-flex items-center  text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
            type="button">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2.5" version="1.1" id="Capa_1"
                xmlns="http://www.w3.org/2000/svg" viewBox="-5 -5 60.00 60.00" fill="currentColor">
                <g>
                    <circle style="fill:;" cx="25" cy="25" r="25"></circle>
                    <line
                        style="fill:none;stroke:#FFFFFF;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                        x1="25" y1="13" x2="25" y2="38"></line>
                    <line
                        style="fill:none;stroke:#FFFFFF;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                        x1="37.5" y1="25" x2="12.5" y2="25"></line>
                </g>
            </svg>
            Novo Usuário
        </button>
                </div>
            </div>
        <div class="flex items-center justify-end pb-4  w-full">
            <div class="relative mr-4 pt-4">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pt-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="search" wire:model="search"
                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    placeholder="Pesquisar">
            </div>
        </div>
</div>
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400 mt-2">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3">
                            CPF
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Telefone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Prestador
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acesso
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ativo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($lista as $row)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $row->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $row->nome }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $row->cpf }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $row->telefone }}
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($row->prestador))
                                {{ $row->prestador->nome }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $row->role }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($row->sn_ativo == 'S')
                                    <span class="text-green-500 font-semibold"> Sim </span>
                                @else
                                    <span class="text-red-500 font-semibold"> Não</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">

                                <button wire:click="edit({{ $row->id }})" onclick="openModal()"
                                    class="inline-flex items-center font-medium text-gray-600 dark:text-gray-500 hover:underline">

                                    <x-icones.editar class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-2.5"
                                        fill="currentcolor" />
                                    Editar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{ $lista->links() }}
            </div>
        </div>
    </div>
</div>
