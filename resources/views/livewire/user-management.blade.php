<div>
    @if (!$showModal)
    <div class="relative flex flex-col w-full min-w-0 mb-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
            <div class="flex flex-wrap -mx-3">
                <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                    <h6 class="mb-0">Gestion des Utilisateurs</h6>
                </div>
                <div class="flex-none w-1/2 max-w-full px-3 text-right">
                    <button wire:click="create"
                        class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-fuchsia leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                        Ajouter un utilisateur
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <!-- Search bar -->
                <div class="p-4">
                    <input wire:model="search" type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300"
                        placeholder="Rechercher un utilisateur...">
                </div>

                <!-- Table -->
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Nom</th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Email</th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Téléphone</th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Localisation</th>
                            <th
                                class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 leading-normal text-sm">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->email }}</p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->phone ?? '-' }}</p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->location ?? '-' }}</p>
                                </td>
                                <td
                                    class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent flex gap-2">
                                    <button wire:click="edit({{ $user->id }})"
                                        class="font-semibold leading-tight text-xs rounded-lg bg-gradient-fuchsia px-4 py-2 text-white">
                                        Éditer
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button wire:click="delete({{ $user->id }})"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                            class="font-semibold leading-tight text-xs rounded-lg bg-gradient-to-tl from-red-600 to-red-400 px-4 py-2 text-white">
                                            Supprimer
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
        
    @else
        
 
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border"
            id="basic-info">
            <div class="pt-6 pl-6 pr-6 mb-0 rounded-t-2xl">
                <h5 class="dark:text-white">  {{ $editMode ? 'Modifier l\'utilisateur' : 'Ajouter un utilisateur' }}</h5>
                
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
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" wire:model="name" id="name"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="email" id="email"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('email')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ $editMode ? 'Nouveau mot de passe (laisser vide pour ne pas changer)' : 'Mot de passe' }}
                            </label>
                            <input type="password" wire:model="password" id="password"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" wire:model="phone" id="phone"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('phone')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Localisation</label>
                            <input type="text" wire:model="location" id="location"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('location')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div  class="mb-4">
                            <label for="about" class="block text-sm font-medium text-gray-700">À propos</label>
                            <textarea wire:model="about" id="about" rows="3"
                                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            @error('about')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
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
</div> 