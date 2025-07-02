<div >
    <!-- En-tête de la classe -->
    <div class="w-full px-3 mb-6">
        
        <div class="relative flex flex-col min-w-0 break-words bg-gradient-to-r from-blue-50 to-indigo-100 shadow-soft-xl rounded-2xl bg-clip-border text-gray-800">
            <div class="flex-auto p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <svg class="w-16 h-16 text-dark opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3L1 9L12 15L21 12V17H23V9M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $schoolClass->name }}</h1>
                            <p class="text-blue-600 text-lg">{{ $schoolClass->level }} • Année {{ $schoolClass->academic_year }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold">{{ $totalStudents }}</div>
                        <div class="text-blue-100">Écoliers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="w-full px-3 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Total étudiants -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 4V6C15 7.66 13.66 9 12 9S9 7.66 9 6V4L3 7V9C3 10.66 4.34 12 6 12V21H8V12H10V21H14V12H16V21H18V12C19.66 12 21 10.66 21 9Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Écoliers</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $totalStudents }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Matières -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M12 7L13.09 10.26L17 10.27L14.18 12.78L15.27 16.04L12 13.53L8.73 16.04L9.82 12.78L7 10.27L10.91 10.26L12 7Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Matières</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $subjectsCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professeur principal -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 4C16.55 4 17 4.45 17 5V8.5L12 6.5L7 8.5V5C7 4.45 7.45 4 8 4H16M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M12 8.5L19 11.5V19H5V11.5L12 8.5Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Enseignant Principal</p>
                            <h3 class="text-lg font-bold text-gray-800">
                                @if($classTeacher)
                                    {{ $classTeacher->first_name }} {{ $classTeacher->last_name }}
                                @else
                                    Non assigné
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programme hebdomadaire -->
    <div class="w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-6">
                <div class="flex items-center mb-6">
                    <svg class="w-8 h-8 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H18V1H16V3H8V1H6V3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M19 19H5V8H19V19M7 10H12V15H7"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800">Programme Hebdomadaire</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($weekDays as $dayKey => $dayName)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20M12.5 7H11V13L16.25 16.15L17 14.92L12.5 12.25V7Z"/>
                                </svg>
                                {{ $dayName }}
                            </h3>
                            
                            @if($weeklySchedule->has($dayKey))
                                <div class="space-y-3">
                                    @foreach($weeklySchedule[$dayKey] as $schedule)
                                        <div class="bg-white rounded-lg p-3 border-l-4 border-indigo-500 shadow-sm">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-semibold text-gray-800 text-sm">{{ $schedule->subject->name }}</h4>
                                                <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </span>
                                            </div>
                                    
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2M12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20M12.5 7H11V13L16.25 16.15L17 14.92L12.5 12.25V7Z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Aucun cours</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des écoliers -->
   <livewire:students :currentClassId="$classId" />

    <!-- Liste des matières -->
</div>