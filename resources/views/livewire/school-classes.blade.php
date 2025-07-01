<div>
    <!-- table 1 -->

    @if (!$showModal)
        
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6>Les classes</h6>
                    </div>
                    <div class="my-auto ml-auto pr-6">
                        <button wire:click="create" type="button"
                            class="inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                            +&nbsp; Nouvelle Classe
                        </button>
                    </div>
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Designation Classe</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Niveau</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Année Académique
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Nombre d'étudiants</th>
                                        <th
                                            class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $class)
                                        <tr>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <div class="flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/home-decor-1.jpg"
                                                            class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-size-sm h-9 w-9 rounded-xl"
                                                            alt="user1" />
                                                    </div>
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 leading-normal text-size-sm"> {{ $class->name }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <p class="mb-0 font-semibold leading-tight text-size-xs">{{ $class->level }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap shadow-transparent">
                                                <span
                                                    class="bg-gradient-lime px-3.6-em text-size-xs-em rounded-1.8 py-2.2-em inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">{{ $class->academic_year }}</span>
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <span
                                                    class="font-semibold leading-tight text-size-xs text-slate-400">{{ $class->students->count() }}</span>
                                            </td>
                                            <td
                                                class="p-2 align-middle text-center bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <a href="javascript:;" wire:click="edit({{ $class->id }})" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <a href="javascript:;" wire:click="delete({{ $class->id }})"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Supprimer">
                                                    <i class="fas fa-trash text-secondary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="px-3">
                                {{ $classes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border"
            id="basic-info">
            <div class="pt-6 pl-6 pr-6 mb-0 rounded-t-2xl">
                <h5 class="dark:text-white">{{ $editMode ? 'Modifier la Classe' : 'Nouvelle Classe' }}</h5>
                
                <div class="my-auto ml-auto lg:mt-0">
                    <div class="my-auto ml-auto">
                        <a href="#" wire:click="closeModal"
                            class="float-right inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                            Retour  à la  liste
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex-auto p-6 pt-0">

                <form wire:submit.prevent="save">
                    <div class="mt-4 ">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom de la classe</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" wire:model="name" id="name">
                    </div>
                    <div class="mt-4">
                        <label for="level" class="block text-sm font-medium text-gray-700">Niveau</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" wire:model="level" id="level">
                            <option value="">Sélectionner un niveau</option>
                            <option value="Licence 1">Licence 1</option>
                            <option value="Licence 2">Licence 2</option>
                            <option value="Licence 3">Licence 3</option>
                            <option value="Master 1">Master 1</option>
                            <option value="Master 2">Master 2</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="academic_year" class="block text-sm font-medium text-gray-700">Année Académique</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" wire:model="academic_year" id="academic_year" placeholder="2023-2024">
                    </div>
                    <div class="mt-4 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button type="submit" class="float-right inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                            {{ $editMode ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
        </div>
    </div>
    @endif


    <!-- card 2 -->

    
</div>
