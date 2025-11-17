<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

final class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Administration',
                'description' => 'Handles all administrative functions and organizational management.',
                'email' => 'admin@foundation.org',
                'phone' => '+1-234-567-8900',
                'location' => 'Main Building, Floor 1',
                'head_of_department' => 'John Smith',
                'mission' => 'To ensure smooth operations and effective organizational management.',
                'key_responsibilities' => [
                    'Financial planning and budgeting',
                    'Human resource management',
                    'Office administration',
                    'Documentation and record keeping',
                ],
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Program Development',
                'description' => 'Designs and implements programs to achieve organizational goals.',
                'email' => 'programs@foundation.org',
                'phone' => '+1-234-567-8901',
                'location' => 'Main Building, Floor 2',
                'head_of_department' => 'Jane Doe',
                'mission' => 'To develop impactful programs that serve our community.',
                'key_responsibilities' => [
                    'Program design and planning',
                    'Implementation and monitoring',
                    'Stakeholder engagement',
                    'Impact assessment',
                ],
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Community Outreach',
                'description' => 'Engages with communities and builds partnerships.',
                'email' => 'outreach@foundation.org',
                'phone' => '+1-234-567-8902',
                'location' => 'Main Building, Floor 1',
                'head_of_department' => 'Michael Johnson',
                'mission' => 'To connect with communities and foster partnerships.',
                'key_responsibilities' => [
                    'Community engagement activities',
                    'Partnership development',
                    'Public relations',
                    'Event organization',
                ],
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Training & Development',
                'description' => 'Provides vocational and skills training to beneficiaries.',
                'email' => 'training@foundation.org',
                'phone' => '+1-234-567-8903',
                'location' => 'Training Center, Building B',
                'head_of_department' => 'Sarah Williams',
                'mission' => 'To empower individuals through quality training and skills development.',
                'key_responsibilities' => [
                    'Curriculum development',
                    'Training delivery',
                    'Instructor management',
                    'Skills assessment',
                ],
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
