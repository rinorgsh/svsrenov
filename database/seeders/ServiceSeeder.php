<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'slug' => 'echafaudage',
                'icon' => 'scaffolding',
                'title_fr' => 'Échafaudage',
                'title_nl' => 'Steigers',
                'description_fr' => 'Placement et installation d\'échafaudages sécurisés pour tous vos travaux en hauteur',
                'description_nl' => 'Plaatsing en installatie van veilige steigers voor al uw werken op hoogte',
                'long_description_fr' => 'Nous assurons la mise en place d\'échafaudages professionnels et sécurisés pour tous vos projets de rénovation de façades. Notre équipe expérimentée garantit une installation conforme aux normes de sécurité les plus strictes.',
                'long_description_nl' => 'Wij zorgen voor de plaatsing van professionele en veilige steigers voor al uw gevelrenovatieprojecten. Ons ervaren team garandeert een installatie die voldoet aan de strengste veiligheidsnormen.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'nettoyage',
                'icon' => 'cleaning',
                'title_fr' => 'Nettoyage',
                'title_nl' => 'Reiniging',
                'description_fr' => 'Sablage et hydrogommage professionnels pour redonner vie à vos façades',
                'description_nl' => 'Professioneel zandstralen en hydrogommage om uw gevels nieuw leven in te blazen',
                'long_description_fr' => 'Nos techniques de sablage et d\'hydrogommage permettent un nettoyage en profondeur de vos façades tout en préservant les matériaux. Nous éliminons efficacement les salissures, graffitis et traces d\'humidité.',
                'long_description_nl' => 'Onze zandstraal- en hydrogommagetechnieken zorgen voor een grondige reiniging van uw gevels met behoud van de materialen. Wij verwijderen effectief vuil, graffiti en vochtsporen.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'reparation',
                'icon' => 'repair',
                'title_fr' => 'Réparation',
                'title_nl' => 'Herstelling',
                'description_fr' => 'Réparation experte de façades abîmées, fissures et dégradations',
                'description_nl' => 'Deskundige herstelling van beschadigde gevels, scheuren en degradaties',
                'long_description_fr' => 'Nous intervenons pour réparer tous types de dégradations de façades : fissures, joints détériorés, briques endommagées. Notre expertise garantit des réparations durables et esthétiques.',
                'long_description_nl' => 'Wij komen tussenbeide om alle soorten beschadigingen aan gevels te herstellen: scheuren, beschadigde voegen, beschadigde bakstenen. Onze expertise garandeert duurzame en esthetische herstellingen.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'peinture',
                'icon' => 'painting',
                'title_fr' => 'Peinture',
                'title_nl' => 'Schilderwerk',
                'description_fr' => 'Peinture professionnelle de façades avec des produits de haute qualité',
                'description_nl' => 'Professioneel schilderwerk voor gevels met hoogwaardige producten',
                'long_description_fr' => 'Application de peintures de façade de haute qualité, adaptées aux conditions climatiques belges. Nous assurons une préparation minutieuse des surfaces pour un résultat durable et impeccable.',
                'long_description_nl' => 'Toepassing van hoogwaardige gevelverf, aangepast aan de Belgische klimaatomstandigheden. Wij zorgen voor een grondige voorbereiding van de oppervlakken voor een duurzaam en onberispelijk resultaat.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'slug' => 'protection',
                'icon' => 'protection',
                'title_fr' => 'Protection',
                'title_nl' => 'Bescherming',
                'description_fr' => 'Traitement anti-humidité et protection anti-graffitis durables',
                'description_nl' => 'Duurzame anti-vocht behandeling en anti-graffiti bescherming',
                'long_description_fr' => 'Application de traitements hydrofuges et anti-graffitis pour protéger durablement vos façades. Nos solutions préventives garantissent une protection optimale contre l\'humidité et les dégradations.',
                'long_description_nl' => 'Toepassing van waterafstotende en anti-graffiti behandelingen om uw gevels duurzaam te beschermen. Onze preventieve oplossingen garanderen optimale bescherming tegen vocht en degradatie.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
