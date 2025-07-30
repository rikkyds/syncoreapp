<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Technical Skills' => [
                'PHP Programming',
                'Laravel Framework',
                'JavaScript',
                'React.js',
                'Vue.js',
                'Node.js',
                'Python',
                'Java',
                'C#',
                'SQL',
                'MySQL',
                'PostgreSQL',
                'MongoDB',
                'Git Version Control',
                'Docker',
                'AWS',
                'Azure',
                'Google Cloud Platform'
            ],
            'Soft Skills' => [
                'Communication',
                'Leadership',
                'Team Work',
                'Problem Solving',
                'Critical Thinking',
                'Time Management',
                'Project Management',
                'Presentation Skills',
                'Negotiation',
                'Customer Service',
                'Adaptability',
                'Creativity',
                'Decision Making'
            ],
            'Language Skills' => [
                'English',
                'Mandarin',
                'Japanese',
                'Korean',
                'Arabic',
                'Spanish',
                'French',
                'German',
                'Dutch',
                'Italian'
            ],
            'Computer Skills' => [
                'Microsoft Office',
                'Microsoft Excel',
                'Microsoft PowerPoint',
                'Microsoft Word',
                'Google Workspace',
                'Adobe Photoshop',
                'Adobe Illustrator',
                'Adobe InDesign',
                'AutoCAD',
                'Figma',
                'Sketch'
            ],
            'Management Skills' => [
                'Strategic Planning',
                'Budget Management',
                'Risk Management',
                'Quality Management',
                'Change Management',
                'Performance Management',
                'Conflict Resolution',
                'Staff Development',
                'Process Improvement',
                'Vendor Management'
            ]
        ];

        foreach ($skills as $categoryName => $skillList) {
            $category = SkillCategory::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($skillList as $skillName) {
                    Skill::create([
                        'name' => $skillName,
                        'skill_category_id' => $category->id
                    ]);
                }
            }
        }
    }
}
