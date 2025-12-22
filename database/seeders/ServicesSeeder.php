<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title_fr' => 'Échafaudages Tubulaires',
                'title_nl' => 'Buissteiger',
                'description_fr' => 'Installation complète d\'échafaudages sécurisés pour accéder à l\'ensemble de votre façade',
                'description_nl' => 'Volledige installatie van veilige steigers voor toegang tot uw volledige gevel',
                'long_description_fr' => 'Fourniture, transport aller-retour, montage et démontage complet des échafaudages pour travaux. L\'échafaudage couvrira l\'intégralité de la façade depuis le niveau rez-de-chaussée, équipé d\'échelles et planchers permettant l\'accès sécurisé à tous les éléments de façade. La stabilité est assurée par ancrages dans la façade avec pose de fixations et protection des zones d\'appuis si nécessaire. Les échafaudages sont démontés dès que leur utilité n\'est plus requise.',
                'long_description_nl' => 'Levering, heen- en terugvervoer, volledige montage en demontage van steigers voor werkzaamheden. De steiger zal de volledige gevel bedekken vanaf het gelijkvloers, uitgerust met ladders en platforms voor veilige toegang tot alle gevelelementen. Stabiliteit wordt gewaarborgd door verankering in de gevel met plaatsing van bevestigingen en bescherming van steunpunten indien nodig. Steigers worden gedemonteerd zodra ze niet meer nodig zijn.',
                'icon' => '🏗️',
                'order' => 1,
            ],
            [
                'title_fr' => 'Protection & Entoilage',
                'title_nl' => 'Bescherming & Doek',
                'description_fr' => 'Protection complète de l\'échafaudage et des châssis de fenêtres durant les travaux',
                'description_nl' => 'Volledige bescherming van steiger en raamkozijnen tijdens de werkzaamheden',
                'long_description_fr' => 'Entoilage professionnel de l\'échafaudage et protection des châssis de fenêtres à l\'aide de feuilles de polyéthylène haute résistance (0,1 micron) aux endroits des interventions de nettoyage. Application de feuilles en une seule pièce par ensemble (châssis + allège), fixées à l\'aide de bandes autocollantes. Ces protections garantissent l\'étanchéisation correcte du châssis et résistent aux pressions des appareils de nettoyage haute pression.',
                'long_description_nl' => 'Professionele doekbedekking van de steiger en bescherming van raamkozijnen met hoogwaardige polyethyleenfolies (0,1 micron) op plaatsen waar reinigingswerkzaamheden worden uitgevoerd. Toepassing van folies in één stuk per geheel (kozijn + borstweringspaneel), bevestigd met zelfklevende strips. Deze beschermingen garanderen de correcte afdichting van het kozijn en zijn bestand tegen de druk van hogedruk reinigingsapparatuur.',
                'icon' => '🛡️',
                'order' => 2,
            ],
            [
                'title_fr' => 'Nettoyage Vapeur',
                'title_nl' => 'Stoomreiniging',
                'description_fr' => 'Nettoyage délicat par vapeur saturée qui préserve la patine naturelle des matériaux',
                'description_nl' => 'Delicate reiniging met verzadigde stoom die de natuurlijke patina van materialen behoudt',
                'long_description_fr' => 'Cette technique consiste en la projection sous pression d\'une vapeur saturée humide qui permet aux matériaux de conserver leur patine naturelle. Le matériel utilisé se compose d\'une lance actionnée manuellement et alimentée par un générateur de vapeur sous pression. L\'eau est prélevée sur le circuit de distribution de l\'immeuble. Alimentation électrique : 1 prise normalisée triphasé 230V – 32A ou monophasé 380V – 25A, ou mise à disposition de notre groupe électrogène.',
                'long_description_nl' => 'Deze techniek bestaat uit het onder druk spuiten van een vochtige verzadigde stoom die de natuurlijke patina van de materialen behoudt. De gebruikte apparatuur bestaat uit een handmatig bediende lans gevoed door een stoomgenerator onder druk. Het water wordt afgenomen van het distributienet van het gebouw. Elektrische voeding: 1 genormaliseerde driefasige 230V – 32A of monofasische 380V – 25A aansluiting, of gebruik van onze generator.',
                'icon' => '💨',
                'order' => 3,
            ],
            [
                'title_fr' => 'Hydro-Gommage',
                'title_nl' => 'Hydro-Gomming',
                'description_fr' => 'Nettoyage écologique à basse pression respectant la structure des matériaux',
                'description_nl' => 'Ecologische reiniging op lage druk met respect voor de structuur van materialen',
                'long_description_fr' => 'Procédé de projection à basse pression (0,2 à 0,3 MPa soit 2 à 3 bars) combinant un jet de poudre fine et un léger rideau d\'eau pour réduire la poussière. Le résultat est soigneusement vérifié par nos opérateurs hautement qualifiés qui adaptent la pression et la distance en temps réel. Les poudres fines utilisées ne contiennent pas de silice libre, répondent aux normes sur la santé publique et sont respectueuses de l\'environnement. La forme des grains et leur finesse optimalisent le nettoyage tout en respectant la structure des matériaux et la patine du temps.',
                'long_description_nl' => 'Projectieproces op lage druk (0,2 tot 0,3 MPa of 2 tot 3 bar) dat een fijne poederstraal combineert met een licht watergordijn om stof te verminderen. Het resultaat wordt zorgvuldig gecontroleerd door onze hooggekwalificeerde operators die de druk en afstand in real-time aanpassen. De gebruikte fijne poeders bevatten geen vrije silica, voldoen aan de normen voor de volksgezondheid en zijn milieuvriendelijk. De vorm van de korrels en hun fijnheid optimaliseren de reiniging met respect voor de structuur van de materialen en de patina van de tijd.',
                'icon' => '🌊',
                'order' => 4,
            ],
            [
                'title_fr' => 'Hydrofugation TECHNISIL',
                'title_nl' => 'Hydrofugering TECHNISIL',
                'description_fr' => 'Protection hydrofuge écologique pour préserver vos façades de l\'humidité',
                'description_nl' => 'Ecologische waterafstotende bescherming om uw gevels tegen vocht te beschermen',
                'long_description_fr' => 'Application du TECHNISIL 280, un concentré en phase aqueuse formulé sur base d\'un mélange de 4 polymères (silanes, siloxanes oligomères, résine fluorée) pour l\'hydrofugation de supports poreux verticaux (béton, maçonneries, enduits, pierres naturelles ou reconstituées). Sans solvant, ininflammable, inodore, applicable sur support humide ou sec. Protection anti-poussières, anti-affiche, anti-cryptogamique et anti-salissure. Permet au matériau de garder ses propriétés d\'isolation thermique et ralentit la formation de micro-organismes (mousses, lichens).',
                'long_description_nl' => 'Toepassing van TECHNISIL 280, een concentraat in waterige fase geformuleerd op basis van een mengsel van 4 polymeren (silanen, siloxaan oligomeren, gefluoreerde hars) voor hydrofugering van verticale poreuze ondergronden (beton, metselwerk, pleisterwerk, natuursteen of kunststeen). Zonder oplosmiddel, onbrandbaar, geurloos, toepasbaar op vochtige of droge ondergrond. Bescherming tegen stof, plakbiljetten, schimmels en vuil. Laat het materiaal zijn thermische isolatie-eigenschappen behouden en vertraagt de vorming van micro-organismen (mossen, korstmossen).',
                'icon' => '💧',
                'order' => 5,
            ],
            [
                'title_fr' => 'Traitement Anti-Graffiti',
                'title_nl' => 'Anti-Graffiti Behandeling',
                'description_fr' => 'Protection invisible et réversible contre les graffitis et salissures',
                'description_nl' => 'Onzichtbare en omkeerbare bescherming tegen graffiti en vervuiling',
                'long_description_fr' => 'Application d\'une protection TECHNIFOND incolore et semi-permanente. Système réversible ne modifiant pas l\'aspect des matériaux. Non filmogène, exempte de solvant, non toxique. Protection complète anti-graffiti, anti-salissures et hydrofuge en une seule application.',
                'long_description_nl' => 'Toepassing van een kleurloze en semi-permanente TECHNIFOND bescherming. Omkeerbaar systeem dat het uitzicht van de materialen niet verandert. Niet-filmvormend, zonder oplosmiddel, niet-toxisch. Volledige anti-graffiti, anti-vuil en waterafstotende bescherming in één toepassing.',
                'icon' => '🎨',
                'order' => 6,
            ],
            [
                'title_fr' => 'Durcisseur de Pierres',
                'title_nl' => 'Steenverharder',
                'description_fr' => 'Consolidation minérale pour renforcer et protéger durablement vos pierres',
                'description_nl' => 'Minerale consolidatie om uw stenen duurzaam te versterken en te beschermen',
                'long_description_fr' => 'Application du produit SILISTONE à base de silicate d\'éthyle pur, adapté au traitement des pierres blanches calcaires. Effets curatifs par formation d\'un liant inter-granulaire minéral (silice) donnant une nouvelle cohésion superficielle. Effets préventifs grâce au liant silicieux pratiquement insensible à la pollution (pluies acides) qui améliore la durabilité des matériaux. Sans additif susceptible d\'entraîner des effets secondaires hydrophobes. Application à refus momentané avec consommation liée à la nature des matériaux.',
                'long_description_nl' => 'Toepassing van het SILISTONE product op basis van zuiver ethylsilicaat, geschikt voor de behandeling van witte kalkstenen. Curatieve effecten door vorming van een inter-granulaire minerale bindmiddel (silica) dat een nieuwe oppervlaktecohesie geeft. Preventieve effecten dankzij het silicium bindmiddel dat praktisch ongevoelig is voor vervuiling (zure regen) en de duurzaamheid van de materialen verbetert. Zonder additief dat hydrofobe bijwerkingen kan veroorzaken. Toepassing tot verzadiging met verbruik afhankelijk van de aard van de materialen.',
                'icon' => '🪨',
                'order' => 7,
            ],
            [
                'title_fr' => 'Restauration des Bétons',
                'title_nl' => 'Betonherstel',
                'description_fr' => 'Réparation professionnelle des bétons dégradés avec mortier époxy',
                'description_nl' => 'Professioneel herstel van beschadigd beton met epoxymortier',
                'long_description_fr' => 'Sondage et décapage des bétons non adhérents à l\'aide d\'une masse métallique par frappes successives. Soufflage à l\'air sec pour évacuer résidus et matières pulvérulentes. Décapage des zones dégradées (fissurées, détachées, sonnant creux ou présentant des taches de rouille) jusqu\'au béton sain. Enrobage des armatures mises à nu avec vernis à base de résine époxy. Application d\'une couche de liant époxy pour favoriser l\'adhérence, puis pose du mortier époxy de réparation et égalisation.',
                'long_description_nl' => 'Kloppen en afkrabben van niet-hechtend beton met een metalen hamer door opeenvolgende slagen. Blazen met droge lucht om residuen en poederachtige stoffen te verwijderen. Afkrabben van beschadigde zones (gescheurd, losgemaakt, hol klinkend of met roestsporen) tot het gezonde beton. Bedekking van blootgelegde wapening met vernis op basis van epoxyhars. Toepassing van een laag epoxybindmiddel om de hechting te bevorderen, vervolgens aanbrengen van epoxy herstelmortier en egalisatie.',
                'icon' => '🏢',
                'order' => 8,
            ],
            [
                'title_fr' => 'Coating Murfill Waterproofing',
                'title_nl' => 'Coating Murfill Waterproofing',
                'description_fr' => 'Revêtement semi-épais, souple et étanche avec garantie 10 ans',
                'description_nl' => 'Semi-dikke, flexibele en waterdichte coating met 10 jaar garantie',
                'long_description_fr' => 'Application d\'un revêtement de façade semi-épais, souple et étanche de la gamme Murfill Waterproofing Coating. Sa structure microporeuse permet à la surface traitée de respirer. L\'excellent pouvoir opacifiant et l\'élasticité du produit préservent votre façade de l\'usure, de la détérioration et de l\'infiltration d\'humidité. Garantie de bonne tenue de 10 ans.',
                'long_description_nl' => 'Toepassing van een semi-dikke, flexibele en waterdichte gevelcoating uit het Murfill Waterproofing Coating gamma. De microporeuze structuur laat het behandelde oppervlak ademen. Het uitstekende dekkend vermogen en de elasticiteit van het product beschermen uw gevel tegen slijtage, verslechtering en vocht infiltratie. Garantie van goede staat voor 10 jaar.',
                'icon' => '🎯',
                'order' => 9,
            ],
            [
                'title_fr' => 'Rejointoiement SEIFERT',
                'title_nl' => 'Hervoegen SEIFERT',
                'description_fr' => 'Réfection professionnelle des joints avec mortier pré-dosé de qualité',
                'description_nl' => 'Professionele voegvernieuwing met voorgedoseerde kwaliteitsmortier',
                'long_description_fr' => 'Réfection des joints en recherche à l\'aide d\'un mortier pré-dosé SEIFERT. Décapage et restauration des joints de maçonnerie défectueux par décapage et/ou meulage sur une profondeur de +/- 1,5cm. Rejointoiement au mortier de qualité SEIFERT dans le ton le plus rapprochant de celui des joints existants.',
                'long_description_nl' => 'Vernieuwing van voegen op zoek met voorgedoseerde SEIFERT mortier. Afkrabben en herstel van defecte metselwerkvoegen door afkrabben en/of slijpen op een diepte van +/- 1,5cm. Hervoegen met SEIFERT kwaliteitsmortier in de tint die het meest overeenkomt met die van de bestaande voegen.',
                'icon' => '🧱',
                'order' => 10,
            ],
            [
                'title_fr' => 'Réparation Pierres LITHOS',
                'title_nl' => 'Steenherstel LITHOS',
                'description_fr' => 'Restauration des pierres avec mortier minéral de poudre de pierre naturelle',
                'description_nl' => 'Restauratie van stenen met minerale mortel van natuursteen poeder',
                'long_description_fr' => 'Réparation et restauration des pierres dégradées à l\'aide d\'un mortier minéral LITHOS ARTE composé de poudre de pierre naturelle. Les granulats, choisis en fonction de l\'aspect recherché, sont mélangés à un liquide de gâchage spécifique pour garantir un résultat esthétique parfait et une intégration harmonieuse avec la pierre existante.',
                'long_description_nl' => 'Reparatie en restauratie van beschadigde stenen met een minerale LITHOS ARTE mortel samengesteld uit natuursteen poeder. De toeslagmaterialen, gekozen in functie van het gewenste uiterlijk, worden gemengd met een specifieke aanmaakvloeistof om een perfect esthetisch resultaat en een harmonische integratie met de bestaande steen te garanderen.',
                'icon' => '⚒️',
                'order' => 11,
            ],
            [
                'title_fr' => 'Peinture Boiseries TRIMETAL',
                'title_nl' => 'Schilderwerk Houtwerk TRIMETAL',
                'description_fr' => 'Protection et embellissement des corniche et boiseries extérieures',
                'description_nl' => 'Bescherming en verfraaiing van kroonlijsten en buitenhoutwerk',
                'long_description_fr' => 'Traitement complet des boiseries de corniche : préparation des surfaces par hydro-gommage ou ponçage, lavage, ponçage fin, puis application en deux couches d\'une peinture TRIMETAL haute qualité dans le ton de votre choix. Protection durable contre les intempéries et les UV.',
                'long_description_nl' => 'Volledige behandeling van kroonlijsthoutwerk: voorbereiding van oppervlakken door hydro-gomming of schuren, wassen, fijn schuren, vervolgens aanbrengen in twee lagen van een hoogwaardige TRIMETAL verf in de kleur van uw keuze. Duurzame bescherming tegen weer en wind en UV-straling.',
                'icon' => '🖌️',
                'order' => 12,
            ],
            [
                'title_fr' => 'Joints Souples PARABOND',
                'title_nl' => 'Soepele Voegen PARABOND',
                'description_fr' => 'Remplacement des joints avec système hybride et garantie 10 ans',
                'description_nl' => 'Vervanging van voegen met hybride systeem en 10 jaar garantie',
                'long_description_fr' => 'Renouvellement des joints souples entre pierres de parement avec découpage des joints existants et remplacement à l\'aide d\'un joint hybride PARABOND (50% silicone – 50% polyuréthane). Excellente adhérence même sur surface légèrement humide. Très bonne résistance au vieillissement et aux rayons UV. Lissage manuel des joints. Garantie de bonne tenue de 10 ans.',
                'long_description_nl' => 'Vernieuwing van soepele voegen tussen beklede stenen met uitsnijden van bestaande voegen en vervanging met een hybride PARABOND voeg (50% silicone – 50% polyurethaan). Uitstekende hechting zelfs op licht vochtige oppervlakken. Zeer goede weerstand tegen veroudering en UV-straling. Handmatig gladstrijken van voegen. Garantie van goede staat voor 10 jaar.',
                'icon' => '🔧',
                'order' => 13,
            ],
            [
                'title_fr' => 'Joints Châssis PARABOND',
                'title_nl' => 'Kozijnvoegen PARABOND',
                'description_fr' => 'Étanchéité optimale des châssis avec joints durables garantis 10 ans',
                'description_nl' => 'Optimale afdichting van kozijnen met duurzame voegen gegarandeerd 10 jaar',
                'long_description_fr' => 'Renouvellement des joints autour des châssis de fenêtres avec découpage des joints existants, dépoussiérage minutieux et pose d\'un joint souple PARABOND haute performance. Lissage manuel professionnel des joints dans le ton de votre choix. Garantie de bonne tenue de 10 ans.',
                'long_description_nl' => 'Vernieuwing van voegen rond raamkozijnen met uitsnijden van bestaande voegen, grondig ontstoffen en plaatsing van een hoogwaardige soepele PARABOND voeg. Professioneel handmatig gladstrijken van voegen in de kleur van uw keuze. Garantie van goede staat voor 10 jaar.',
                'icon' => '🪟',
                'order' => 14,
            ],
            [
                'title_fr' => 'Peinture Ferronneries',
                'title_nl' => 'Schilderwerk Smeedijzer',
                'description_fr' => 'Protection antirouille des balcons, fenêtres et portes métalliques',
                'description_nl' => 'Antiroest bescherming van balkons, ramen en metalen deuren',
                'long_description_fr' => 'Traitement complet des ferronneries (balcons, fenêtres, portes) : ponçage soigné, lavage approfondi, puis application en deux couches d\'une peinture antirouille FERRO DECOR haute performance. Protection longue durée contre la corrosion et les intempéries.',
                'long_description_nl' => 'Volledige behandeling van smeedijzerwerk (balkons, ramen, deuren): zorgvuldig schuren, grondig wassen, vervolgens aanbrengen in twee lagen van een hoogwaardige antiroestverf FERRO DECOR. Langdurige bescherming tegen corrosie en weersomstandigheden.',
                'icon' => '🔨',
                'order' => 15,
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'slug' => Str::slug($service['title_fr']),
                'icon' => $service['icon'],
                'title_fr' => $service['title_fr'],
                'title_nl' => $service['title_nl'],
                'description_fr' => $service['description_fr'],
                'description_nl' => $service['description_nl'],
                'long_description_fr' => $service['long_description_fr'],
                'long_description_nl' => $service['long_description_nl'],
                'image' => null, // Les images peuvent être ajoutées via l'admin
                'order' => $service['order'],
                'is_active' => true,
            ]);
        }
    }
}
