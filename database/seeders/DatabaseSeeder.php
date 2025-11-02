<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create sample projects
        Project::factory()->featured()->create([
            'title' => 'Clean Water Initiative',
            'description' => 'Providing clean and safe drinking water to rural communities across Rwanda.',
            'content' => 'This comprehensive water project aims to install water pumps, purification systems, and educate communities about water hygiene. We work directly with local leaders to ensure sustainable maintenance and community ownership of the water systems.',
            'location' => 'Kigali, Rwanda',
            'beneficiaries_count' => 2500,
            'budget' => 75000.00,
        ]);

        Project::factory()->published()->create([
            'title' => 'Women Empowerment Program',
            'description' => 'Supporting women entrepreneurs through microfinance and business training.',
            'content' => 'Our women empowerment program provides microloans, business training, and mentorship to help women start and grow their businesses. We focus on sustainable income generation and financial independence.',
            'location' => 'Musanze, Rwanda',
            'beneficiaries_count' => 150,
            'budget' => 25000.00,
        ]);

        Project::factory()->published()->create([
            'title' => 'Education Support Initiative',
            'description' => 'Improving access to quality education for children in underserved communities.',
            'content' => 'This education project focuses on building classrooms, providing school supplies, and training teachers. We believe education is the foundation for breaking the cycle of poverty.',
            'location' => 'Huye, Rwanda',
            'beneficiaries_count' => 800,
            'budget' => 45000.00,
        ]);

        Project::factory()->published()->create([
            'title' => 'Healthcare Access Program',
            'description' => 'Expanding healthcare services to remote rural areas.',
            'content' => 'Our healthcare program establishes mobile clinics, trains community health workers, and provides essential medical supplies to ensure everyone has access to basic healthcare services.',
            'location' => 'Nyagatare, Rwanda',
            'beneficiaries_count' => 1200,
            'budget' => 60000.00,
        ]);

        // Create additional sample projects
        Project::factory()->published()->count(8)->create();
        Project::factory()->draft()->count(3)->create();
        Project::factory()->featured()->count(2)->create();
    }
}
