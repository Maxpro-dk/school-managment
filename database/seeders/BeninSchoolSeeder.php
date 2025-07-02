<?php
// File: database/seeders/BeninSchoolSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BeninSchoolSeeder extends Seeder
{

    public $faker;
    public function run()
    {
        $this->faker = Faker::create('fr_FR');
        
        // 1. Créer les matières
        $this->seedSubjects();
        
        // 2. Créer les enseignants
        $teacherIds = $this->seedTeachers();
        
        // 3. Créer les classes
        $classIds = $this->seedSchoolClasses($teacherIds);
        
        // 4. Créer les élèves
        $this->seedStudents( $classIds);
        
        // 5. Créer les emplois du temps
        $this->seedSchedules($classIds);
    }

    private function seedSubjects()
    {
        $subjects = [
            ['name' => 'Expression Française', 'code' => 'ES', 'description' => 'Expression française et communication'],
            ['name' => 'Éducation Scientifique et Technique', 'code' => 'EST', 'description' => 'Sciences et techniques'],
            ['name' => 'Écriture', 'code' => 'ECR', 'description' => 'Apprentissage de l\'écriture'],
            ['name' => 'Lecture', 'code' => 'LEC', 'description' => 'Apprentissage de la lecture'],
            ['name' => 'Mathématiques', 'code' => 'MATH', 'description' => 'Calcul et géométrie'],
            ['name' => 'Éducation Physique et Sportive', 'code' => 'EPS', 'description' => 'Sport et activités physiques'],
            ['name' => 'Chant et Poésie', 'code' => 'CP', 'description' => 'Expression artistique'],
            ['name' => 'Éducation Civique', 'code' => 'EC', 'description' => 'Éducation à la citoyenneté'],
            ['name' => 'Expression Orale', 'code' => 'ORAL', 'description' => 'Communication orale'],
            ['name' => 'Éducation Morale', 'code' => 'EM', 'description' => 'Valeurs morales et éthiques'],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'name' => $subject['name'],
                'code' => $subject['code'],
                'description' => $subject['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedTeachers()
    {
        $teacherIds = [];
        $beninNames = [
            'first_names' => ['Adjovi', 'Agbessi', 'Akouègnon', 'Ayaba', 'Azandossou', 'Codjo', 'Dossa', 'Fagbemi', 'Gandonou', 'Hounon', 'Kpohomou', 'Lokossou', 'Magnan', 'N\'tcha', 'Ogoudjobi', 'Pierre', 'Quenum', 'Sossou', 'Tchakondo', 'Yehouenou'],
            'last_names' => ['Adanhoume', 'Ahouansou', 'Aplogan', 'Assogba', 'Awoudo', 'Degboe', 'Djossou', 'Gbaguidi', 'Hounkponou', 'Kpadonou', 'Lawani', 'Montcho', 'Nouatin', 'Ogoubi', 'Sognigbe', 'Tchibozo', 'Yemadje', 'Zounon']
        ];

        $diplomas = [
            'Certificat de Fin d\'Études Primaires (CFEP)',
            'Brevet d\'Études du Premier Cycle (BEPC)',
            'Baccalauréat Série A',
            'Baccalauréat Série D',
            'Diplôme d\'Instituteur',
            'Certificat d\'Aptitude Pédagogique (CAP)',
            'Licence en Sciences de l\'Éducation',
            'École Normale d\'Instituteurs (ENI)'
        ];

        for ($i = 0; $i < 20; $i++) {
            $teacherId = DB::table('teachers')->insertGetId([
                'first_name' => $this->faker->randomElement($beninNames['first_names']),
                'last_name' => $this->faker->randomElement($beninNames['last_names']),
                'email' => $this->faker->unique()->safeEmail(),
                'phone' => '+229 ' . $this->faker->numerify('## ## ## ##'),
                'diploma' => $this->faker->randomElement($diplomas),
                'address' => $this->faker->address(),
                'birth_date' => $this->faker->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $teacherIds[] = $teacherId;
        }

        return $teacherIds;
    }

    private function seedSchoolClasses($teacherIds)
    {
        $levels = ['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'];
        $sections = ['A', 'B'];
        $classIds = [];

        foreach ($levels as $level) {
            foreach ($sections as $section) {
                $classId = DB::table('school_classes')->insertGetId([
                    'name' => $level . '-' . $section,
                    'level' => $level,
                    'academic_year' => '2024-2025',
                    'teacher_id' => $teacherIds[array_rand($teacherIds)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $classIds[] = $classId;
            }
        }

        return $classIds;
    }

    private function seedStudents( $classIds)
    {
        $beninNames = [
            'first_names' => ['Abiola', 'Adjoa', 'Akpene', 'Ayaba', 'Aziza', 'Codjo', 'Djenaba', 'Ebo', 'Fadila', 'Ganiyou', 'Houefa', 'Innocent', 'Koffi', 'Latifa', 'Mawuli', 'Nadia', 'Oscar', 'Patience', 'Rachida', 'Sèdjro', 'Tamara', 'Ulrich', 'Victoire', 'Wilfrid', 'Yannick', 'Zakia'],
            'last_names' => ['Adanhoume', 'Ahouansou', 'Assogba', 'Degboe', 'Djossou', 'Gbaguidi', 'Hounkponou', 'Kpadonou', 'Lawani', 'Montcho', 'Nouatin', 'Sognigbe', 'Tchibozo', 'Yemadje', 'Zounon']
        ];

        $currentYear = date('Y');
        $studentNumber = 1;

        foreach ($classIds as $classId) {
            $studentsPerClass = rand(25, 35);
            
            for ($i = 0; $i < $studentsPerClass; $i++) {
                DB::table('students')->insert([
                    'first_name' => $this->faker->randomElement($beninNames['first_names']),
                    'last_name' => $this->faker->randomElement($beninNames['last_names']),
                    'birth_date' => $this->faker->dateTimeBetween('-12 years', '-6 years')->format('Y-m-d'),
                    'gender' => $this->faker->randomElement(['M', 'F']),
                    'registration_number' => $currentYear . str_pad($studentNumber++, 4, '0', STR_PAD_LEFT),
                    'school_class_id' => $classId,
                    'tutor_name' => $this->faker->randomElement($beninNames['first_names']) . ' ' . $this->faker->randomElement($beninNames['last_names']),
                    'tutor_phone' => '+229 ' . $this->faker->numerify('## ## ## ##'),
                    'tutor_email' => $this->faker->optional(0.6)->safeEmail(),
                    'address' => $this->faker->address(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedSchedules($classIds)
    {
        $subjectIds = DB::table('subjects')->pluck('id')->toArray();
        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        
        // Créneaux horaires typiques du primaire béninois
        $timeSlots = [
            ['start' => '08:00:00', 'end' => '09:00:00'],
            ['start' => '09:00:00', 'end' => '10:00:00'],
            ['start' => '10:00:00', 'end' => '10:15:00'], // Récréation
            ['start' => '10:15:00', 'end' => '11:15:00'],
            ['start' => '11:15:00', 'end' => '12:00:00'],
            // Pause déjeuner
            ['start' => '15:00:00', 'end' => '16:00:00'],
            ['start' => '16:00:00', 'end' => '17:00:00'],
        ];

        foreach ($classIds as $classId) {
            foreach ($days as $day) {
                // Matin (8h-12h)
                $morningSubjects = $this->faker->randomElements($subjectIds, 4);
                for ($i = 0; $i < 4; $i++) {
                    if ($i == 2) continue; // Skip récréation
                    
                    DB::table('schedules')->insert([
                        'school_class_id' => $classId,
                        'subject_id' => $morningSubjects[$i],
                        'day' => $day,
                        'start_time' => $timeSlots[$i]['start'],
                        'end_time' => $timeSlots[$i]['end'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Après-midi (15h-17h) - seulement certains jours
                if (in_array($day, ['lundi', 'mardi', 'jeudi', 'vendredi'])) {
                    $afternoonSubjects = $this->faker->randomElements($subjectIds, 2);
                    for ($i = 0; $i < 2; $i++) {
                        DB::table('schedules')->insert([
                            'school_class_id' => $classId,
                            'subject_id' => $afternoonSubjects[$i],
                            'day' => $day,
                            'start_time' => $timeSlots[5 + $i]['start'],
                            'end_time' => $timeSlots[5 + $i]['end'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}