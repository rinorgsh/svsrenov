<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Jean Dupont',
                'client_company' => 'Entreprise ABC',
                'comment_fr' => 'Excellent travail ! L\'équipe de SVS RENOV a rénové la façade de mon immeuble avec un professionnalisme remarquable. Le résultat est magnifique et les délais ont été respectés.',
                'comment_nl' => 'Uitstekend werk! Het SVS RENOV team heeft de gevel van mijn gebouw gerenoveerd met opmerkelijk professionalisme. Het resultaat is prachtig en de deadlines werden gerespecteerd.',
                'rating' => 5,
                'order' => 1,
                'is_published' => true,
            ],
            [
                'client_name' => 'Marie Lambert',
                'client_company' => null,
                'comment_fr' => 'Je recommande vivement SVS RENOV. Ils ont été très à l\'écoute de mes besoins et ont proposé des solutions adaptées à mon budget. La qualité du travail est impeccable.',
                'comment_nl' => 'Ik beveel SVS RENOV ten zeerste aan. Ze luisterden goed naar mijn behoeften en stelden oplossingen voor die bij mijn budget pasten. De kwaliteit van het werk is onberispelijk.',
                'rating' => 5,
                'order' => 2,
                'is_published' => true,
            ],
            [
                'client_name' => 'Pierre Janssens',
                'client_company' => 'Syndic Pro',
                'comment_fr' => 'Service professionnel et soigné. L\'isolation de notre bâtiment a été réalisée dans les règles de l\'art. Nous sommes très satisfaits du résultat et des économies d\'énergie réalisées.',
                'comment_nl' => 'Professionele en zorgvuldige service. De isolatie van ons gebouw werd vakkundig uitgevoerd. We zijn zeer tevreden met het resultaat en de gerealiseerde energiebesparingen.',
                'rating' => 5,
                'order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            \App\Models\Testimonial::create($testimonial);
        }
    }
}
