<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        $heroes = [
            [
                'page' => 'home',
                'title_fr' => 'Votre façade, Notre mission',
                'title_nl' => 'Uw gevel, Onze missie',
                'subtitle_fr' => 'Excellence en rénovation de façades',
                'subtitle_nl' => 'Uitmuntendheid in gevelrenovatie',
                'is_active' => true,
            ],
            [
                'page' => 'about',
                'title_fr' => 'À propos de SVS RENOV',
                'title_nl' => 'Over SVS RENOV',
                'subtitle_fr' => 'Notre histoire, notre expertise',
                'subtitle_nl' => 'Ons verhaal, onze expertise',
                'is_active' => true,
            ],
            [
                'page' => 'services',
                'title_fr' => 'Nos Services',
                'title_nl' => 'Onze Diensten',
                'subtitle_fr' => 'Des solutions complètes pour vos façades',
                'subtitle_nl' => 'Volledige oplossingen voor uw gevels',
                'is_active' => true,
            ],
            [
                'page' => 'portfolio',
                'title_fr' => 'Portfolio',
                'title_nl' => 'Portfolio',
                'subtitle_fr' => 'Découvrez nos réalisations',
                'subtitle_nl' => 'Ontdek onze realisaties',
                'is_active' => true,
            ],
            [
                'page' => 'contact',
                'title_fr' => 'Contact',
                'title_nl' => 'Contact',
                'subtitle_fr' => 'Parlons de votre projet',
                'subtitle_nl' => 'Laten we praten over uw project',
                'is_active' => true,
            ],
            [
                'page' => 'gallery',
                'title_fr' => 'Galerie',
                'title_nl' => 'Galerij',
                'subtitle_fr' => 'Photos et vidéos de nos chantiers',
                'subtitle_nl' => 'Foto\'s en video\'s van onze werven',
                'is_active' => true,
            ],
        ];

        foreach ($heroes as $hero) {
            Hero::updateOrCreate(
                ['page' => $hero['page']],
                $hero
            );
        }
    }
}
