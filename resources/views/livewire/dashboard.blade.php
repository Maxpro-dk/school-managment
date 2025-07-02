<div class="flex flex-wrap -mx-3">
    <div class="mb-4 p-6 bg-gradient-to-r from-blue-50 to-indigo-100 w-full">
        <h5 class="text-2xl font-bold text-gray-800">
            Tableau de Bord
        </h5>
        <p class="text-gray-600 mt-2 text-sm">
           {{ get_greeting()}}
        </p>
    </div>
    
    <!-- Statistiques -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-wrap -mx-3">
                    <!-- Écoliers -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Écoliers</p>
                                            <h5 class="mb-0 font-bold">{{ $totalStudents }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500">
                                            <i class="fas fa-user-graduate text-lg relative top-3.5 text-white"></i>
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
                                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Enseignants </p>
                                            <h5 class="mb-0 font-bold">{{ $totalTeachers }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500">
                                            <i class="fas fa-chalkboard-teacher text-lg relative top-3.5 text-white"></i>
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
                                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Classes</p>
                                            <h5 class="mb-0 font-bold">{{ $totalClasses }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500">
                                            <i class="fas fa-school text-lg relative top-3.5 text-white"></i>
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
                                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Matières</p>
                                            <h5 class="mb-0 font-bold">{{ $totalSubjects }}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500">
                                            <i class="fas fa-book text-lg relative top-3.5 text-white"></i>
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
    

    <!-- Statistiques détaillées par classe -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="p-0">
                    <h6 class="mb-4 text-lg font-bold text-gray-800">Répartition par Classes</h6>
                    
                    @foreach(['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'] as $level)
                        @if( $studentsPerClass?->get($level)->count() > 0)
                            <div class="mb-6">
                                <!-- En-tête du niveau -->
                                <div class="flex items-center mb-3 p-3 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border-l-4 border-indigo-500">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500 text-white font-bold text-sm mr-3">
                                        {{ $level }}
                                    </div>
                                    <div>
                                        <h6 class="font-semibold text-gray-800 mb-1">Niveau {{ $level }}</h6>
                                        <p class="text-xs text-gray-600">
                                            {{ $studentsPerClass->get($level)->count() }} {{ $studentsPerClass->get($level)->count() > 1 ? 'classes' : 'classe' }} - 
                                            {{ $studentsPerClass->get($level)->sum('student_count') }} {{ $studentsPerClass->get($level)->sum('student_count') > 1 ? 'élèves' : 'élève' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Liste des classes du niveau -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ml-4">
                                    @foreach($studentsPerClass->get($level) as $class)
                                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center">
                                                    <a href="{{route('class-details', $class->id) }}" class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold mr-3">
                                                        {{ substr($class->name, -1) }}
                                                    </a>
                                                    <div>
                                                        <h6 class="font-semibold text-gray-800 text-sm">{{ $class->name }}</h6>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $class->student_count }} élèves
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Informations sur l'enseignant -->
                                            <div class="flex items-center text-xs text-gray-600 mt-2 gap-2">
                                                <i class="fas fa-user-tie mr-2 text-gray-400"></i>
                                                <span class="font-bold me-2">Enseignants : </span>
                                                @if($class->teacher)

                                                    <span class="font-medium"> {{ $class->teacher->first_name }} {{ $class->teacher->last_name }}</span>
                                                @else
                                                    <span class="italic text-gray-500">Aucun enseignant assigné</span>
                                                @endif
                                            </div>

                                            <!-- Barre de progression basée sur la capacité -->
                                            <div class="mt-3">
                                                @php
                                                    $capacity = 35; // Capacité max par classe
                                                    $percentage = min(($class->student_count / $capacity) * 100, 100);
                                                    $colorClass = $percentage < 70 ? 'bg-green-500' : ($percentage < 90 ? 'bg-yellow-500' : 'bg-red-500');
                                                @endphp
                                                <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                                    <span>Taux de remplissage</span>
                                                    <span>{{ number_format($percentage, 1) }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="h-2 rounded-full {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé par niveau -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <h6 class="mb-4 text-lg font-bold text-gray-800">Résumé par Niveau</h6>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">Niveau</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center">Classes</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center">Total Élèves</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center">Moyenne/Classe</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'] as $level)
                                @php
                                    $levelClasses = $studentsPerClass->get($level) ?? collect();
                                    $totalStudents = $levelClasses->sum('student_count');
                                    $classCount = $levelClasses->count();
                                    $average = $classCount > 0 ? round($totalStudents / $classCount, 1) : 0;
                                @endphp
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold mr-3">
                                                {{ $level }}
                                            </div>
                                            <span class="font-semibold">{{ $level }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $classCount }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $totalStudents }}</td>
                                    <td class="px-6 py-4 text-center">{{ $average }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($average < 25)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Sous-peuplé
                                            </span>
                                        @elseif($average > 32)
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <i class="fas fa-users mr-1"></i>Surpeuplé
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Optimal
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>