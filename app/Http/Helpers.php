<?php
// Dans app/helpers.php (créer ce fichier s'il n'existe pas)
// Puis ajouter dans composer.json > autoload > files : ["app/helpers.php"]

use Illuminate\Support\Facades\Auth;

if (!function_exists('route_name')) {
    function route_name($routeName = null)
    {
        $routeName = $routeName ?: (request()->route() ? request()->route()->getName() : '');
        
        $routeNames = [
            'dashboard' => 'Tableau de bord',
            'profile' => 'Profil',
            'classes' => 'Classes',
            'subjects' => 'Matières',
            'students' => 'Étudiants',
            'teachers' => 'Enseignants',
            'schedules' => 'Emplois du temps',
            'user-profile' => 'Profil utilisateur',
            'user-management' => 'Gestion des utilisateurs',
        ];

        return $routeNames[$routeName] ?? ucfirst(str_replace('-', ' ', $routeName));
    }
}


if (!function_exists('get_greeting')) {
    function get_greeting($name = null, $includeEmoji = true)
    {
        $name = $name ?: (Auth::check() ? Auth::user()->name : 'Utilisateur');
        $hour = date('H');
        
        // Déterminer le message selon l'heure
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Bonjour';
            $emoji = $includeEmoji ? ' ☀️' : '';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'Bon après-midi';
            $emoji = $includeEmoji ? ' 🌤️' : '';
        } else {
            $greeting = 'Bonsoir';
            $emoji = $includeEmoji ? ' 🌙' : '';
        }
        
        return $greeting . ' ' . $name . $emoji . ' !';
    }
}

if (!function_exists('get_motivational_message')) {
    function get_motivational_message()
    {
        $messages = [
            'Prêt pour une nouvelle journée d\'apprentissage ?',
            'Ensemble, construisons l\'avenir de l\'éducation !',
            'Chaque jour est une nouvelle opportunité d\'apprendre.',
            'L\'éducation est la clé du succès !',
            'Faisons de cette journée un succès !',
            'Votre dévouement fait la différence.',
            'Continuons à inspirer nos étudiants !',
        ];
        
        return $messages[array_rand($messages)];
    }
}

if (!function_exists('get_user_role_message')) {
    function get_user_role_message()
    {
        if (!Auth::check()) return '';
        
        $role = Auth::user()->role ?? 'user';
        
        $roleMessages = [
            'admin' => 'Tableau de bord administrateur - Vous avez accès à tous les outils de gestion.',
            'teacher' => 'Espace enseignant - Gérez vos classes et suivez vos étudiants.',
            'student' => 'Espace étudiant - Consultez vos cours et vos notes.',
            'user' => 'Bienvenue dans votre espace personnel.',
        ];
        
        return $roleMessages[$role] ?? $roleMessages['user'];
    }
}
// Après avoir ajouté cette fonction, exécuter : composer dump-autoload