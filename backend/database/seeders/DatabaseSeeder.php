<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Importar Seeder
use App\Models\Answer;
use App\Models\Course;
use App\Models\Division;
use App\Models\Group;
use App\Models\Question;

use Laravel\Prompts\FormStep;

use function Laravel\Prompts\form;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()

    {
        // Llama a otros seeders si es necesario
        $this->call([
            CourseSeeder::class,
            SubjectSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            DivisionSeeder::class,
            GroupSeeder::class,
            GroupDivisionSeeder::class,
            GroupUserSeeder::class,
            GroupSubjectSeeder::class,
            GroupCourseSeeder::class,
            FormSeeder::class,   // Crear formularios primero
            QuestionSeeder::class, // Crear preguntas después
            OptionSeeder::class,   // Opciones relacionadas a preguntas
            AnswerSeeder::class,
            RespostesSeeder::class,
            ResultatsSeeder::class;

            CourseUserSeeder::class,
            CourseDivisionSeeder::class,
        ]);
    }
}
