<div class="flex flex-wrap -mx-3">
    <!-- Statistiques -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-wrap -mx-3">
                    <!-- Étudiants -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <p class="mb-0 font-sans font-semibold leading-normal text-size-sm">Étudiants</p>
                                            <h5 class="mb-0 font-bold">{{ $totalStudents }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-fuchsia">
                                            <i class="fas fa-user-graduate text-size-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professeurs -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <p class="mb-0 font-sans font-semibold leading-normal text-size-sm">Professeurs</p>
                                            <h5 class="mb-0 font-bold">{{ $totalTeachers }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-fuchsia">
                                            <i class="fas fa-chalkboard-teacher text-size-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <p class="mb-0 font-sans font-semibold leading-normal text-size-sm">Classes</p>
                                            <h5 class="mb-0 font-bold">{{ $totalClasses }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-fuchsia">
                                            <i class="fas fa-school text-size-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Matières -->
                    <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <p class="mb-0 font-sans font-semibold leading-normal text-size-sm">Matières</p>
                                            <h5 class="mb-0 font-bold">{{ $totalSubjects }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-fuchsia">
                                            <i class="fas fa-book text-size-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Emploi du temps -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <h6 class="mb-4">Cours d'aujourd'hui ({{ now()->locale('fr')->dayName }})</h6>
                @if($upcomingSchedules->isEmpty())
                    <p class="text-center text-gray-500">Aucun cours prévu pour aujourd'hui</p>
                @else
                    <div class="flex gap-4">
                        @foreach($upcomingSchedules as $schedule)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl w-2/5 mx-4">
                            <div class="w-12 h-12 rounded-lg bg-gradient-fuchsia flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 text-sm">{{ $schedule->subject->name }}</h6>
                                <div class="text-xs text-gray-600">
                                    <p>{{ Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>
                                    <p>{{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}</p>
                                    <p>{{ $schedule->class->name }} | {{ $schedule->room }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Classes les plus nombreuses -->
            <div class=" mt-4 relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class="mb-4">Classes les plus nombreuses</h6>
                    @foreach($classesWithMostStudents as $class)
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-fuchsia flex items-center justify-center mr-4">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="flex-grow">
                            <h6 class="mb-1 text-sm">{{ $class->name }}</h6>
                            <div class="flex items-center">
                                <div class="flex-grow">
                                    <div class="h-1 bg-gray-200 rounded">
                                        <div class="h-1 rounded bg-gradient-fuchsia" style="width: {{ ($class->students_count / $totalStudents) * 100 }}%"></div>
                                    </div>
                                </div>
                                <span class="ml-2 text-xs text-gray-600">{{ $class->students_count }} étudiants</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Professeurs avec le plus de matières -->
            <div class="mt-4 relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class="mb-4">Professeurs avec le plus de matières</h6>
                    @foreach($teachersWithMostSubjects as $teacher)
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-fuchsia flex items-center justify-center mr-4">
                            <i class="fas fa-user-tie text-white"></i>
                        </div>
                        <div class="flex-grow">
                            <h6 class="mb-1 text-sm">{{ $teacher->first_name }} {{ $teacher->last_name }}</h6>
                            <div class="flex items-center">
                                <div class="flex-grow">
                                    <div class="h-1 bg-gray-200 rounded">
                                        <div class="h-1 rounded bg-gradient-fuchsia" style="width: {{ ($teacher->subjects_count / $totalSubjects) * 100 }}%"></div>
                                    </div>
                                </div>
                                <span class="ml-2 text-xs text-gray-600">{{ $teacher->subjects_count }} matières</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>