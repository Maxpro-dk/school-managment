<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
       

        // Création d'un utilisateur administrateur
        User::create([
            'name' => 'Chedrack',
            'email' => 'admin@ecole.bj',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            BeninSchoolSeeder::class,
        ]);
    
    }
}