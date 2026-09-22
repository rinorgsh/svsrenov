<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Premiers articles du blog "Conseils".
 * php artisan db:seed --class=BlogPostSeeder
 *
 * Idempotent : met à jour les articles existants (clé = slug).
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $data) {
            $data['cover_image'] = $this->copyCover($data['cover_source'], $data['slug']);
            $data['service_id'] = Service::where('slug', $data['service_slug'])->value('id');
            $data['published_at'] = Carbon::parse($data['published_at']);
            $data['is_published'] = true;

            unset($data['cover_source'], $data['service_slug']);

            Post::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }

    /**
     * Copie une image de /public vers le disque "public" (storage/app/public/posts).
     */
    private function copyCover(string $publicPath, string $slug): ?string
    {
        $source = public_path($publicPath);

        if (! is_file($source)) {
            return null;
        }

        $target = 'posts/' . $slug . '.' . strtolower(pathinfo($source, PATHINFO_EXTENSION));
        Storage::disk('public')->put($target, file_get_contents($source));

        return $target;
    }

    private function posts(): array
    {
        return [
            [
                'slug' => 'quand-nettoyer-sa-facade',
                'service_slug' => 'nettoyage',
                'cover_source' => 'images/projects/project-11-after.jpg',
                'published_at' => '2026-09-22 08:00',
                'title_fr' => 'Quand faut-il nettoyer sa façade ?',
                'title_nl' => 'Wanneer moet u uw gevel reinigen?',
                'excerpt_fr' => 'Mousses, traces noires, joints qui s’effritent : les signes qui montrent qu’il est temps d’agir, et la meilleure saison pour le faire.',
                'excerpt_nl' => 'Mos, zwarte strepen, afbrokkelende voegen: de signalen dat het tijd is om in te grijpen, en het beste seizoen om het te doen.',
                'content_fr' => <<<'MD'
Une façade encrassée n’est pas qu’une question d’esthétique. La pollution, l’humidité et les micro-organismes attaquent lentement les matériaux. Plus on attend, plus le nettoyage devient technique… et plus la facture grimpe.

## Les signes qui ne trompent pas

- **Mousses, lichens et algues** sur les zones peu ensoleillées (souvent la façade nord).
- **Traces noires ou verdâtres** sous les appuis de fenêtre et les corniches.
- **Coulures** le long des descentes d’eau.
- **Joints qui se creusent** ou s’effritent quand on passe le doigt dessus.
- **Une teinte générale terne**, surtout visible quand on compare avec la maison voisine fraîchement rénovée.

![Façade avant nettoyage](/images/projects/project-10-before.jpg)

![La même façade après nettoyage](/images/projects/project-10-after.jpg)

## Tous les combien ?

En Belgique, avec notre climat humide, on conseille généralement un nettoyage **tous les 10 à 15 ans** pour une façade en briques ou en pierre. Une façade exposée au trafic, aux arbres ou aux vents dominants peut en demander plus souvent.

> Un contrôle visuel chaque printemps suffit à repérer les premiers signes. Mieux vaut intervenir tôt que de devoir réparer.

## La meilleure période

Le **printemps** et le **début de l’automne** sont idéaux : les températures sont douces, le gel est loin et la façade sèche rapidement après le nettoyage. On évite les périodes de gel, qui peuvent faire éclater un matériau encore gorgé d’eau.

## Et après le nettoyage ?

Une façade propre est aussi une façade « ouverte » : c’est le meilleur moment pour la **protéger** avec un hydrofuge, qui limitera l’encrassement et les infiltrations pendant de longues années.

Vous hésitez ? Nous passons gratuitement sur place pour évaluer l’état de votre façade et vous dire honnêtement ce qui est nécessaire, et ce qui peut attendre.
MD,
                'content_nl' => <<<'MD'
Een vervuilde gevel is niet alleen een kwestie van uitzicht. Vervuiling, vocht en micro-organismen tasten de materialen langzaam aan. Hoe langer u wacht, hoe technischer de reiniging wordt… en hoe hoger de factuur.

## Signalen die niet liegen

- **Mos, korstmos en algen** op weinig zonnige delen (vaak de noordgevel).
- **Zwarte of groenige strepen** onder de vensterbanken en kroonlijsten.
- **Afloopsporen** langs de regenpijpen.
- **Voegen die uithollen** of afbrokkelen als u er met uw vinger over gaat.
- **Een doffe algemene kleur**, vooral zichtbaar naast een pas gerenoveerde buurwoning.

![Gevel voor de reiniging](/images/projects/project-10-before.jpg)

![Dezelfde gevel na de reiniging](/images/projects/project-10-after.jpg)

## Hoe vaak?

In België, met ons vochtige klimaat, raden we meestal **om de 10 à 15 jaar** een reiniging aan voor een gevel in baksteen of natuursteen. Een gevel aan een drukke weg, onder bomen of in de wind kan vaker nodig zijn.

> Elke lente even kijken volstaat om de eerste signalen op te merken. Beter vroeg ingrijpen dan later moeten herstellen.

## Het beste moment

De **lente** en het **begin van de herfst** zijn ideaal: zachte temperaturen, geen vorst en de gevel droogt snel na de reiniging. Vorstperiodes vermijden we, want een materiaal vol water kan dan openbarsten.

## En na de reiniging?

Een propere gevel is ook een „open” gevel: het ideale moment om hem te **beschermen** met een waterafstotend middel, dat vervuiling en insijpeling jarenlang beperkt.

Twijfelt u? We komen gratis ter plaatse om de staat van uw gevel te beoordelen en zeggen u eerlijk wat nodig is, en wat kan wachten.
MD,
            ],
            [
                'slug' => 'hydrogommage-sablage-vapeur-quelle-technique',
                'service_slug' => 'hydro-gommage',
                'cover_source' => 'images/projects/project-14-after.jpg',
                'published_at' => '2026-09-15 08:00',
                'title_fr' => 'Hydrogommage, sablage ou vapeur : quelle technique pour votre façade ?',
                'title_nl' => 'Hydrogommage, zandstralen of stoom: welke techniek voor uw gevel?',
                'excerpt_fr' => 'Toutes les façades ne se nettoient pas de la même manière. On compare les trois grandes techniques pour vous aider à y voir clair.',
                'excerpt_nl' => 'Niet elke gevel wordt op dezelfde manier gereinigd. We vergelijken de drie grote technieken zodat u klaar ziet.',
                'content_fr' => <<<'MD'
Brique, pierre bleue, enduit, béton… Chaque support a sa sensibilité. Choisir la mauvaise technique, c’est risquer d’abîmer durablement une façade. Voici les trois méthodes que nous utilisons le plus souvent.

## L’hydrogommage : la précision

Un mélange d’eau, d’air et d’un granulat très fin est projeté à **basse pression**. Le résultat : un nettoyage en profondeur qui respecte la surface.

- Idéal pour la **brique**, la **pierre naturelle** et les **façades anciennes**.
- Retire la pollution, les salissures et une partie des anciennes peintures.
- Peu d’eau utilisée, donc séchage rapide.

![Façade en briques avant hydrogommage](/images/projects/project-14-before.jpg)

![Après hydrogommage](/images/projects/project-14-after.jpg)

## Le sablage : la puissance

Le sablage projette un abrasif plus agressif. Il est efficace sur les supports **très durs** ou pour décaper des couches épaisses (peintures, crépis dégradés).

- Adapté au **béton** et à certaines pierres dures.
- À proscrire sur les briques tendres et les parements fragiles : il ouvre les pores et accélère l’usure.

## La vapeur : la douceur

Le nettoyage à la vapeur (eau chaude à haute température, basse pression) élimine mousses, algues et salissures organiques **sans abrasif**.

- Parfait pour les **enduits**, les **façades peintes** et les surfaces délicates.
- Tue les micro-organismes, ce qui retarde leur retour.

> La bonne technique dépend du support, de son état et du type de salissure. C’est pour ça qu’on commence toujours par un essai sur une petite zone.

## En résumé

| Technique | Idéale pour | À éviter sur |
|---|---|---|
| Hydrogommage | Brique, pierre, façades anciennes | — |
| Sablage | Béton, supports très durs | Brique tendre, enduits |
| Vapeur | Enduits, peintures, mousses | Salissures incrustées |

Vous ne savez pas quelle méthode convient à votre façade ? Nous faisons le diagnostic gratuitement sur place.
MD,
                'content_nl' => <<<'MD'
Baksteen, blauwe steen, pleister, beton… Elke ondergrond heeft zijn eigen gevoeligheid. De verkeerde techniek kiezen kan een gevel blijvend beschadigen. Dit zijn de drie methodes die we het vaakst gebruiken.

## Hydrogommage: de precisie

Een mengsel van water, lucht en een heel fijn granulaat wordt onder **lage druk** gespoten. Het resultaat: een diepe reiniging die het oppervlak respecteert.

- Ideaal voor **baksteen**, **natuursteen** en **oude gevels**.
- Verwijdert vervuiling, vuil en een deel van oude verflagen.
- Weinig water, dus snelle droging.

![Bakstenen gevel voor hydrogommage](/images/projects/project-14-before.jpg)

![Na hydrogommage](/images/projects/project-14-after.jpg)

## Zandstralen: de kracht

Zandstralen gebruikt een agressiever straalmiddel. Het werkt op **heel harde** ondergronden of om dikke lagen te verwijderen (verf, beschadigde crepi).

- Geschikt voor **beton** en sommige harde steensoorten.
- Af te raden op zachte baksteen en fragiele gevelstenen: het opent de poriën en versnelt de slijtage.

## Stoom: de zachtheid

Stoomreiniging (heet water op hoge temperatuur, lage druk) verwijdert mos, algen en organisch vuil **zonder straalmiddel**.

- Perfect voor **pleisterwerk**, **geschilderde gevels** en delicate oppervlakken.
- Doodt micro-organismen, waardoor ze later terugkomen.

> De juiste techniek hangt af van de ondergrond, de staat ervan en het soort vervuiling. Daarom beginnen we altijd met een proef op een kleine zone.

## Samengevat

| Techniek | Ideaal voor | Te vermijden op |
|---|---|---|
| Hydrogommage | Baksteen, natuursteen, oude gevels | — |
| Zandstralen | Beton, heel harde ondergronden | Zachte baksteen, pleister |
| Stoom | Pleister, verf, mos | Ingebakken vuil |

Weet u niet welke methode bij uw gevel past? We stellen gratis ter plaatse een diagnose.
MD,
            ],
            [
                'slug' => 'hydrofugation-proteger-facade-humidite',
                'service_slug' => 'hydrofugation-technisil',
                'cover_source' => 'images/projects/project-12-after.jpg',
                'published_at' => '2026-09-08 08:00',
                'title_fr' => 'Hydrofugation : protéger sa façade de l’humidité',
                'title_nl' => 'Hydrofugering: uw gevel beschermen tegen vocht',
                'excerpt_fr' => 'Un traitement invisible qui empêche l’eau de pénétrer dans les murs tout en les laissant respirer. Comment ça marche, et quand le faire ?',
                'excerpt_nl' => 'Een onzichtbare behandeling die water uit de muren houdt, terwijl ze blijven ademen. Hoe werkt het, en wanneer doet u het?',
                'content_fr' => <<<'MD'
La pluie battante est l’ennemie numéro un des façades belges. L’eau qui pénètre dans la brique ou la pierre provoque, avec le temps, des taches, des mousses, des dégâts de gel… et parfois de l’humidité à l’intérieur de la maison.

## Qu’est-ce que l’hydrofugation ?

C’est l’application d’un produit **incolore** qui pénètre dans les pores du matériau. Une fois sec, il **repousse l’eau de pluie** (l’effet « perlant ») tout en laissant passer la vapeur d’eau : le mur continue de **respirer**.

![Façade en briques après nettoyage et hydrofugation](/images/projects/project-12-after.jpg)

## Les avantages

- **Moins d’infiltrations** et de risques de dégâts liés au gel.
- **Une façade qui reste propre plus longtemps** : la saleté accroche moins sur un support sec.
- **Moins de mousses et d’algues**, qui ont besoin d’humidité pour se développer.
- **Aspect inchangé** : le produit est invisible une fois appliqué.

## Quand hydrofuger ?

Le meilleur moment, c’est **juste après un nettoyage** : la façade est propre, les pores sont ouverts et le produit pénètre en profondeur. Il faut aussi que :

1. la façade soit **saine** (joints en bon état, fissures réparées) ;
2. le support soit **sec** ;
3. la météo annonce quelques jours **sans pluie ni gel**.

> Hydrofuger une façade dont les joints sont abîmés ne sert à rien : l’eau passera par les joints. On répare d’abord, on protège ensuite.

## Combien de temps ça tient ?

Selon le produit, l’exposition et le support, un bon hydrofuge protège la façade pendant de nombreuses années. Un simple test (quelques gouttes d’eau qui perlent ou non) permet de vérifier s’il est toujours actif.

Vous voulez savoir si votre façade a besoin d’être protégée ? Nous passons la voir gratuitement.
MD,
                'content_nl' => <<<'MD'
Slagregen is vijand nummer één van de Belgische gevels. Water dat in baksteen of natuursteen dringt, zorgt na verloop van tijd voor vlekken, mos, vorstschade… en soms vocht binnen in huis.

## Wat is hydrofugering?

Het aanbrengen van een **kleurloos** product dat in de poriën van het materiaal dringt. Eenmaal droog **stoot het regenwater af** (het „parel”-effect), terwijl waterdamp nog door kan: de muur blijft **ademen**.

![Bakstenen gevel na reiniging en hydrofugering](/images/projects/project-12-after.jpg)

## De voordelen

- **Minder insijpeling** en minder risico op vorstschade.
- **Een gevel die langer proper blijft**: vuil hecht minder op een droge ondergrond.
- **Minder mos en algen**, die vocht nodig hebben om te groeien.
- **Onveranderd uitzicht**: het product is onzichtbaar na het aanbrengen.

## Wanneer hydrofugeren?

Het beste moment is **meteen na een reiniging**: de gevel is proper, de poriën staan open en het product dringt diep door. Daarnaast moet:

1. de gevel **gezond** zijn (voegen in orde, barsten hersteld);
2. de ondergrond **droog** zijn;
3. het weerbericht enkele dagen **zonder regen of vorst** voorspellen.

> Een gevel met beschadigde voegen hydrofugeren heeft geen zin: het water loopt via de voegen naar binnen. Eerst herstellen, dan beschermen.

## Hoe lang houdt het?

Afhankelijk van het product, de blootstelling en de ondergrond beschermt een goed waterafstotend middel de gevel vele jaren. Een eenvoudige test (parelen enkele waterdruppels of niet?) toont of het nog werkt.

Wilt u weten of uw gevel bescherming nodig heeft? We komen gratis langs.
MD,
            ],
            [
                'slug' => 'graffitis-facade-enlever-proteger',
                'service_slug' => 'traitement-anti-graffiti',
                'cover_source' => 'images/projects/project-13-after.jpg',
                'published_at' => '2026-09-01 08:00',
                'title_fr' => 'Graffitis sur la façade : comment les enlever et s’en protéger',
                'title_nl' => 'Graffiti op de gevel: verwijderen en voorkomen',
                'excerpt_fr' => 'Un tag sur votre façade ou votre vitrine ? Les bons réflexes, les erreurs à éviter et la protection qui facilite les prochains nettoyages.',
                'excerpt_nl' => 'Een tag op uw gevel of etalage? De juiste reflexen, de fouten om te vermijden en de bescherming die de volgende reiniging makkelijk maakt.',
                'content_fr' => <<<'MD'
Un graffiti apparu pendant la nuit, c’est rageant. Surtout sur une devanture commerciale, où l’image compte. Bonne nouvelle : dans la grande majorité des cas, on peut le faire disparaître sans laisser de trace.

![Devanture taguée avant intervention](/images/projects/project-13-before.jpg)

![La même façade après nettoyage](/images/projects/project-13-after.jpg)

## Les erreurs à éviter

- **Frotter avec un solvant ménager** : il dilue la peinture et la fait pénétrer plus profondément dans la brique ou la pierre.
- **Repeindre par-dessus** avec une couleur « approchante » : la tache reste visible et attire souvent… un nouveau tag.
- **Utiliser un nettoyeur haute pression** sans connaître le support : on risque d’abîmer les joints et la surface.

## Comment on procède

1. **Identifier le support** (brique, pierre, enduit, métal, vitre) et le type de peinture.
2. **Appliquer un décapant adapté**, laissé agir le temps nécessaire.
3. **Rincer** à basse pression ou à la vapeur, pour ne pas abîmer le matériau.
4. Si besoin, **reprendre localement** les zones où une ombre persiste.

> Plus on intervient vite, plus c’est facile : une peinture fraîche n’a pas encore eu le temps de migrer dans les pores.

## La protection anti-graffiti

Après le nettoyage, on peut appliquer un **traitement anti-graffiti** invisible. Il empêche la peinture d’accrocher en profondeur : le prochain tag s’enlève beaucoup plus facilement, souvent à l’eau chaude.

Il existe deux grandes familles :

- **Protection sacrificielle** : elle part avec le graffiti et doit être réappliquée localement.
- **Protection permanente** : elle résiste à plusieurs nettoyages successifs.

Le choix dépend du support et de la fréquence des tags dans votre rue. Nous vous conseillons gratuitement.
MD,
                'content_nl' => <<<'MD'
Een graffiti die ’s nachts verschenen is, is frustrerend. Zeker op een handelspand, waar het imago telt. Goed nieuws: in de meeste gevallen kunnen we hem verwijderen zonder sporen.

![Getagde etalage voor de ingreep](/images/projects/project-13-before.jpg)

![Dezelfde gevel na de reiniging](/images/projects/project-13-after.jpg)

## Fouten om te vermijden

- **Wrijven met een huishoudelijk oplosmiddel**: het verdunt de verf en duwt ze dieper in de baksteen of natuursteen.
- **Overschilderen** met een „gelijkaardige” kleur: de vlek blijft zichtbaar en lokt vaak… een nieuwe tag uit.
- **Een hogedrukreiniger gebruiken** zonder de ondergrond te kennen: u riskeert schade aan voegen en oppervlak.

## Hoe wij te werk gaan

1. **De ondergrond bepalen** (baksteen, natuursteen, pleister, metaal, glas) en het soort verf.
2. **Een aangepast afbijtmiddel aanbrengen** en het de nodige tijd laten inwerken.
3. **Spoelen** onder lage druk of met stoom, om het materiaal niet te beschadigen.
4. Indien nodig **plaatselijk bijwerken** waar nog een schaduw zichtbaar is.

> Hoe sneller we ingrijpen, hoe makkelijker: verse verf heeft nog geen tijd gehad om in de poriën te trekken.

## Antigraffitibescherming

Na de reiniging kunnen we een onzichtbare **antigraffitibehandeling** aanbrengen. Die voorkomt dat verf diep hecht: een volgende tag verwijdert u veel makkelijker, vaak met heet water.

Er zijn twee grote soorten:

- **Opofferende bescherming**: verdwijnt samen met de graffiti en moet plaatselijk opnieuw aangebracht worden.
- **Permanente bescherming**: bestand tegen meerdere reinigingen na elkaar.

De keuze hangt af van de ondergrond en hoe vaak er in uw straat getagd wordt. We adviseren u gratis.
MD,
            ],
            [
                'slug' => 'renovation-facade-etapes-chantier',
                'service_slug' => 'echafaudage',
                'cover_source' => 'image/chantier.jpeg',
                'published_at' => '2026-08-25 08:00',
                'title_fr' => 'Rénovation de façade : les étapes d’un chantier, de l’échafaudage à la finition',
                'title_nl' => 'Gevelrenovatie: de stappen van een werf, van stelling tot afwerking',
                'excerpt_fr' => 'Visite, devis, échafaudage, nettoyage, réparations, protection : on vous explique comment se déroule concrètement la rénovation de votre façade.',
                'excerpt_nl' => 'Bezoek, offerte, stelling, reiniging, herstellingen, bescherming: we leggen uit hoe de renovatie van uw gevel concreet verloopt.',
                'content_fr' => <<<'MD'
Rénover sa façade, c’est un projet qu’on ne fait pas tous les ans. Il est normal de se demander comment ça va se passer. Voici, étape par étape, le déroulement d’un chantier chez SVS Renov.

## 1. La visite et le diagnostic

Tout commence sur place. On observe le support, l’état des joints, les fissures, les traces d’humidité, l’accès à la façade. C’est ce diagnostic qui permet de proposer **les bons travaux**, ni plus ni moins.

## 2. Le devis détaillé

Vous recevez un devis clair, poste par poste : échafaudage, nettoyage, réparations, protection… Le devis est **gratuit et sans engagement**.

## 3. Les démarches et l’échafaudage

Si l’échafaudage empiète sur le trottoir ou la voirie, une **autorisation communale** est souvent nécessaire. Ensuite, l’échafaudage est monté et sécurisé : filets, protections et accès sont vérifiés avant tout travail.

![Échafaudage et ouvriers en sécurité sur un chantier de façade](/image/echafaudage.jpg)

## 4. Le nettoyage

C’est la base de tout. Selon le support : hydrogommage, vapeur ou sablage. La façade retrouve sa teinte d’origine et révèle ses éventuels défauts.

## 5. Les réparations

Une façade propre montre tout. C’est le moment de :

- **refaire les joints** abîmés ;
- **réparer les pierres** et les éléments en béton éclatés ;
- **traiter les fissures**.

## 6. La protection et la finition

Selon vos besoins : hydrofugation, peinture, traitement anti-graffiti, peinture des châssis ou des ferronneries.

## 7. Le démontage et la réception

L’échafaudage est démonté, les abords sont nettoyés, et on fait le tour de la façade **ensemble** avant de clôturer le chantier.

> Un seul interlocuteur du début à la fin : c’est plus simple pour vous, et c’est la garantie que chaque étape est pensée pour la suivante.

Un projet en tête ? Contactez-nous pour une visite gratuite.
MD,
                'content_nl' => <<<'MD'
Uw gevel renoveren doet u niet elk jaar. Het is dus normaal dat u zich afvraagt hoe het in zijn werk gaat. Stap voor stap: zo verloopt een werf bij SVS Renov.

## 1. Het bezoek en de diagnose

Alles begint ter plaatse. We bekijken de ondergrond, de staat van de voegen, barsten, vochtsporen en de toegang tot de gevel. Op basis van die diagnose stellen we **de juiste werken** voor, niet meer en niet minder.

## 2. Een gedetailleerde offerte

U krijgt een duidelijke offerte, post per post: stelling, reiniging, herstellingen, bescherming… De offerte is **gratis en vrijblijvend**.

## 3. De formaliteiten en de stelling

Als de stelling op het voetpad of de weg komt, is vaak een **gemeentelijke toelating** nodig. Daarna wordt de stelling opgebouwd en beveiligd: netten, beschermingen en toegangen worden gecontroleerd voor er gewerkt wordt.

![Stelling en veilig werkende arbeiders op een gevelwerf](/image/echafaudage.jpg)

## 4. De reiniging

De basis van alles. Afhankelijk van de ondergrond: hydrogommage, stoom of zandstralen. De gevel krijgt zijn oorspronkelijke kleur terug en toont eventuele gebreken.

## 5. De herstellingen

Een propere gevel toont alles. Het moment om:

- beschadigde **voegen te vernieuwen**;
- **stenen** en gebarsten betonelementen **te herstellen**;
- **barsten te behandelen**.

## 6. Bescherming en afwerking

Naargelang uw noden: hydrofugering, schilderwerk, antigraffitibehandeling, schilderen van ramen of smeedwerk.

## 7. Afbraak en oplevering

De stelling wordt afgebroken, de omgeving wordt opgeruimd en we lopen **samen** rond de gevel voor we de werf afsluiten.

> Eén aanspreekpunt van begin tot einde: eenvoudiger voor u, en de garantie dat elke stap op de volgende is afgestemd.

Een project in gedachten? Contacteer ons voor een gratis bezoek.
MD,
            ],
        ];
    }
}
