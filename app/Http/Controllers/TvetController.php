<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class TvetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $departments = [
            [
                'name' => 'Welding',
                'slug' => 'welding',
                'description' => 'Master professional welding techniques and metal fabrication skills. Learn arc welding, gas welding, safety practices, and equipment operation essential for construction and manufacturing industries.',
                'icon' => 'welding',
                'color' => 'red',
                'duration' => 'Short Course',
                'certification' => 'RTB Certified',
                'features' => [
                    'Arc and gas welding techniques',
                    'Metal fabrication skills',
                    'Safety and equipment operation',
                    'Industry-standard practices',
                ],
            ],
            [
                'name' => 'Hairdressing',
                'slug' => 'hairdressing',
                'description' => 'Develop professional hairdressing and beauty skills. Learn hair cutting, styling, coloring, and salon management to start your own business or work in the beauty industry.',
                'icon' => 'scissors',
                'color' => 'rose',
                'duration' => 'Short Course',
                'certification' => 'RTB Certified',
                'features' => [
                    'Hair cutting and styling',
                    'Professional coloring techniques',
                    'Customer service skills',
                    'Salon business management',
                ],
            ],
            [
                'name' => 'Tailoring',
                'slug' => 'tailoring',
                'description' => 'Master the art of tailoring and garment construction. Learn pattern making, sewing techniques, and fashion design to create quality clothing and start your own tailoring business.',
                'icon' => 'needle',
                'color' => 'blue',
                'duration' => 'Short Course',
                'certification' => 'RTB Certified',
                'features' => [
                    'Pattern making and design',
                    'Professional sewing techniques',
                    'Garment construction',
                    'Business and entrepreneurship skills',
                ],
            ],
            [
                'name' => 'Multimedia',
                'slug' => 'multimedia',
                'description' => 'Gain essential multimedia and digital skills. Learn graphic design, video editing, photography, and digital content creation for careers in the creative and technology sectors.',
                'icon' => 'camera',
                'color' => 'amber',
                'duration' => 'Short Course',
                'certification' => 'RTB Certified',
                'features' => [
                    'Graphic design fundamentals',
                    'Video editing and production',
                    'Photography and imaging',
                    'Digital content creation',
                ],
            ],
            [
                'name' => 'Masonry',
                'slug' => 'masonry',
                'description' => 'Learn professional masonry and construction skills. Master bricklaying, concrete work, building techniques, and safety practices for a career in the construction industry.',
                'icon' => 'brick',
                'color' => 'gray',
                'duration' => 'Short Course',
                'certification' => 'RTB Certified',
                'features' => [
                    'Bricklaying and blockwork',
                    'Concrete mixing and pouring',
                    'Construction safety practices',
                    'Building code compliance',
                ],
            ],
        ];

        $stats = [
            [
                'value' => '2,500+',
                'label' => 'Graduates',
            ],
            [
                'value' => '85%',
                'label' => 'Employment Rate',
            ],
            [
                'value' => '450+',
                'label' => 'Active Students',
            ],
            [
                'value' => '30+',
                'label' => 'Partner Organizations',
            ],
        ];

        return view('tvet-training', [
            'departments' => $departments,
            'stats' => $stats,
        ]);
    }
}
