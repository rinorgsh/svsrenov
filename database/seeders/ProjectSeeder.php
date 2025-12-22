<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Service;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all services
        $services = Service::all();

        if ($services->isEmpty()) {
            $this->command->warn('No services found. Please run ServiceSeeder first.');
            return;
        }

        // Sample projects
        $projects = [
            [
                'service_id' => $services->where('slug', 'nettoyage')->first()?->id ?? 1,
                'title_fr' => 'Nettoyage de Façade - Immeuble Résidentiel Bruxelles',
                'title_nl' => 'Gevelreiniging - Residentieel Gebouw Brussel',
                'description_fr' => 'Nettoyage complet d\'une façade en brique avec hydrogommage, redonnant tout son éclat à ce bâtiment historique.',
                'description_nl' => 'Volledige reiniging van een bakstenen gevel met hydrogommage, waardoor dit historische gebouw weer in volle glorie straalt.',
                'location' => 'Bruxelles',
                'completion_date' => '2024-06-15',
                'is_featured' => true,
                'is_published' => true,
                'order' => 1,
            ],
            [
                'service_id' => $services->where('slug', 'peinture')->first()?->id ?? 2,
                'title_fr' => 'Ravalement de Façade - Maison Unifamiliale Liège',
                'title_nl' => 'Gevelschilderwerk - Eengezinswoning Luik',
                'description_fr' => 'Peinture complète de façade avec préparation professionnelle et finition impeccable.',
                'description_nl' => 'Volledige gevelschildering met professionele voorbereiding en onberispelijke afwerking.',
                'location' => 'Liège',
                'completion_date' => '2024-08-20',
                'is_featured' => true,
                'is_published' => true,
                'order' => 2,
            ],
            [
                'service_id' => $services->where('slug', 'reparation')->first()?->id ?? 3,
                'title_fr' => 'Réparation de Façade - Commerce Anvers',
                'title_nl' => 'Gevelreparatie - Winkel Antwerpen',
                'description_fr' => 'Réparation complète des fissures et restauration de la façade d\'un commerce en centre-ville.',
                'description_nl' => 'Volledige reparatie van scheuren en restauratie van de gevel van een winkel in het stadscentrum.',
                'location' => 'Anvers',
                'completion_date' => '2024-05-10',
                'is_featured' => true,
                'is_published' => true,
                'order' => 3,
            ],
            [
                'service_id' => $services->where('slug', 'protection')->first()?->id ?? 4,
                'title_fr' => 'Hydrofugation de Façade - Immeuble de Bureaux Namur',
                'title_nl' => 'Gevelhydrofugering - Kantoorgebouw Namen',
                'description_fr' => 'Application d\'un traitement hydrofuge pour protéger durablement la façade contre l\'humidité.',
                'description_nl' => 'Toepassing van een waterafstotende behandeling om de gevel duurzaam te beschermen tegen vocht.',
                'location' => 'Namur',
                'completion_date' => '2024-07-05',
                'is_featured' => true,
                'is_published' => true,
                'order' => 4,
            ],
            [
                'service_id' => $services->where('slug', 'nettoyage')->first()?->id ?? 1,
                'title_fr' => 'Sablage de Façade - Maison de Maître Gand',
                'title_nl' => 'Gevelzandstraling - Herenhuis Gent',
                'description_fr' => 'Sablage professionnel pour retirer la peinture ancienne et révéler la beauté de la brique originale.',
                'description_nl' => 'Professioneel zandstralen om oude verf te verwijderen en de schoonheid van de originele baksteen te onthullen.',
                'location' => 'Gand',
                'completion_date' => '2024-09-12',
                'is_featured' => true,
                'is_published' => true,
                'order' => 5,
            ],
            [
                'service_id' => $services->where('slug', 'peinture')->first()?->id ?? 2,
                'title_fr' => 'Peinture de Façade - Copropriété Charleroi',
                'title_nl' => 'Gevelschilderwerk - Mede-eigendom Charleroi',
                'description_fr' => 'Rénovation complète de la façade d\'un immeuble de 4 étages avec peinture haute qualité.',
                'description_nl' => 'Volledige renovatie van de gevel van een gebouw van 4 verdiepingen met hoogwaardige verf.',
                'location' => 'Charleroi',
                'completion_date' => '2024-04-25',
                'is_featured' => true,
                'is_published' => true,
                'order' => 6,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        $this->command->info('Projects seeded successfully! Total: ' . count($projects));
    }
}
