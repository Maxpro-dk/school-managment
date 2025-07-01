<div>
    @if (!$showModal)
    <!-- table 1 -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Les Emplois du temps</h6>
                </div>
                <div class="my-auto ml-auto pr-6">
                    <button wire:click="create" type="button"
                        class="inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                        +&nbsp; Nouveau Créneau
                    </button>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Classe</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Matière</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Professeur</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Horaire</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-size-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Salle</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 leading-normal text-size-sm">{{ $schedule->class->name }}</h6>
                                                <p class="mb-0 leading-tight text-size-xs text-slate-400">{{ $schedule->class->level }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 font-semibold leading-tight text-size-xs">{{ $schedule->subject->name }}</p>
                                        <p class="mb-0 leading-tight text-size-xs text-slate-400">Coef. {{ $schedule->coefficient }}</p>
                                    </td>
                                    <td class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-lime px-3.6-em text-size-xs-em rounded-1.8 py-2.2-em inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                            {{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}
                                        </span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="font-semibold leading-tight text-size-xs text-slate-400">
                                            {{ ucfirst($schedule->day) }}<br>
                                            {{ Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="font-semibold leading-tight text-size-xs text-slate-400">
                                            {{ $schedule->room }}
                                        </span>
                                    </td>
                                    <td class="p-2 align-middle text-center bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <a href="javascript:;" wire:click="edit({{ $schedule->id }})" class="mx-3"
                                            data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="delete({{ $schedule->id }})"
                                            data-bs-toggle="tooltip" data-bs-original-title="Supprimer">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4">
                        {{ $schedules->links() }}
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
                    <h5 class="dark:text-white">{{ $editMode ? 'Modifier le créneau' : 'Ajouter un créneau' }}</h5>
                    <div class="my-auto ml-auto lg:mt-0">
                        <div class="my-auto ml-auto">
                            <a href="#" wire:click="closeModal"
                                class="float-right inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                                Retour à la liste
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6 pt-0">
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="class_id" class="block mb-2 text-sm font-bold text-gray-700">Classe</label>
                                <select wire:model="class_id" id="class_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionner une classe</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->level }})</option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="subject_id" class="block mb-2 text-sm font-bold text-gray-700">Matière</label>
                                <select wire:model="subject_id" id="subject_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionner une matière</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="teacher_id" class="block mb-2 text-sm font-bold text-gray-700">Professeur</label>
                            <select wire:model="teacher_id" id="teacher_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un professeur</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="day" class="block mb-2 text-sm font-bold text-gray-700">Jour</label>
                                <select wire:model="day" id="day"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionner un jour</option>
                                    @foreach($days as $dayOption)
                                        <option value="{{ $dayOption }}">{{ ucfirst($dayOption) }}</option>
                                    @endforeach
                                </select>
                                @error('day') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="coefficient" class="block mb-2 text-sm font-bold text-gray-700">Coefficient</label>
                                <input type="number" wire:model="coefficient" id="coefficient" min="1" max="4"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('coefficient') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="start_time" class="block mb-2 text-sm font-bold text-gray-700">Heure de début</label>
                                <input type="time" wire:model="start_time" id="start_time"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_time') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="end_time" class="block mb-2 text-sm font-bold text-gray-700">Heure de fin</label>
                                <input type="time" wire:model="end_time" id="end_time"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('end_time') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="room" class="block mb-2 text-sm font-bold text-gray-700">Salle</label>
                            <input type="text" wire:model="room" id="room"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('room') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit"
                                class="inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                                {{ $editMode ? 'Modifier' : 'Ajouter' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div> 