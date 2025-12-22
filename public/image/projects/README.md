# Images des Projets - SVS RENOV

## 📸 Structure des Images

Les projets nécessitent des images AVANT/APRÈS pour montrer vos réalisations.

## 🗂️ Organisation

Créez un dossier pour chaque projet dans `/public/image/projects/`:

```
/public/image/projects/
├── project-1/
│   ├── before.jpg
│   └── after.jpg
├── project-2/
│   ├── before.jpg
│   └── after.jpg
├── project-3/
│   ├── before.jpg
│   └── after.jpg
etc...
```

## 📋 Projets Actuels

Vous avez actuellement **6 projets** dans la base de données:

1. **Nettoyage de Façade - Bruxelles** (Service: Nettoyage)
2. **Ravalement de Façade - Liège** (Service: Peinture)
3. **Réparation de Façade - Anvers** (Service: Réparation)
4. **Hydrofugation de Façade - Namur** (Service: Protection)
5. **Sablage de Façade - Gand** (Service: Nettoyage)
6. **Peinture de Façade - Charleroi** (Service: Peinture)

## 🎨 Spécifications des Images

- **Format**: JPG ou WEBP
- **Dimensions recommandées**: 800x600px minimum
- **Qualité**: Haute résolution
- **Taille fichier**: Maximum 500KB par image
- **Composition**:
  - Image AVANT: Montrer l'état initial
  - Image APRÈS: Montrer le résultat final

## 🔧 Ajouter des Images aux Projets

### Option 1: Via Tinker (Temporaire pour tests)

```bash
php artisan tinker
```

Puis:
```php
$project = \App\Models\Project::find(1);
$project->image_before = 'projects/project-1/before.jpg';
$project->image_after = 'projects/project-1/after.jpg';
$project->save();
```

### Option 2: Mettre à jour le Seeder

Modifiez `/database/seeders/ProjectSeeder.php` et ajoutez les chemins d'images:

```php
'image_before' => 'projects/project-1/before.jpg',
'image_after' => 'projects/project-1/after.jpg',
```

Puis relancez: `php artisan db:seed --class=ProjectSeeder`

### Option 3: Interface Admin (Recommandé pour la production)

Créez une interface d'administration pour gérer vos projets et uploader les images.

## 📌 Notes Importantes

- Les images doivent être dans `/public/image/projects/`
- Les chemins dans la base de données sont relatifs à `/storage/`
- Pour l'instant, les projets s'affichent sans images (placeholders gris)
- Ajoutez vos vraies photos avant/après pour un impact maximal

## 🎯 Images Placeholder Temporaires

En attendant vos vraies photos, vous pouvez utiliser des images de démonstration:
- Téléchargez sur Unsplash.com
- Recherchez: "facade renovation before after", "building cleaning", etc.
- Renommez-les selon la structure ci-dessus
