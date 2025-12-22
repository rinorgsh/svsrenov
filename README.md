# SVS RENOV - Site Web Professionnel

Site web professionnel bilingue (FR/NL) pour SVS RENOV, entreprise de nettoyage et rénovation de façades en Belgique.

## 🚀 Stack Technique

- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 (Composition API)
- **Bridge**: Inertia.js
- **Styling**: Tailwind CSS
- **Base de données**: MySQL/SQLite
- **Authentification**: Laravel Breeze

## 🎨 Identité de Marque

- **Nom**: SVS RENOV
- **Slogan FR**: "Votre façade, Notre mission"
- **Slogan NL**: "Uw gevel, Onze missie"
- **Couleurs**:
  - Rouge brique: `#A0402C` (couleur principale)
  - Noir: `#1A1A1A` (textes et contrastes)
  - Blanc: `#FFFFFF` (fond et clarté)
  - Gris clair: `#F5F5F5` (fond secondaire)

## 📋 Services Proposés

1. **Échafaudage**: Installation d'échafaudages sécurisés
2. **Nettoyage**: Sablage et hydrogommage de façades
3. **Réparation**: Réparation de façades abîmées
4. **Peinture**: Peinture professionnelle de façades
5. **Protection**: Protection anti-humidité et anti-graffitis

## ⚙️ Installation

### Prérequis

- PHP 8.2+
- Composer
- Node.js 18+
- npm ou yarn
- MySQL ou SQLite

### Étapes d'installation

1. **Cloner le projet** (si depuis un repository)
   ```bash
   cd SVSRenov
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances Node.js**
   ```bash
   npm install --legacy-peer-deps
   ```

4. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurer la base de données** dans le fichier `.env`
   ```env
   DB_CONNECTION=sqlite
   # ou pour MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=svsrenov
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

6. **Créer la base de données SQLite** (si vous utilisez SQLite)
   ```bash
   touch database/database.sqlite
   ```

7. **Exécuter les migrations**
   ```bash
   php artisan migrate
   ```

8. **Peupler la base avec les services**
   ```bash
   php artisan db:seed --class=ServiceSeeder
   ```

9. **Créer le lien symbolique pour le stockage**
   ```bash
   php artisan storage:link
   ```

10. **Compiler les assets**
    ```bash
    npm run build
    # ou pour le développement:
    npm run dev
    ```

## 🏃 Démarrage

### En développement

Terminal 1 - Serveur Laravel:
```bash
php artisan serve
```

Terminal 2 - Compilation des assets:
```bash
npm run dev
```

Accédez au site sur: `http://localhost:8000`

## 🌐 Fonctionnalités

### Frontend Public
- ✅ Page d'accueil avec hero section
- ✅ Page Services (5 services)
- ✅ Page Portfolio (projets avant/après)
- ✅ Page Contact avec formulaire
- ✅ Switch de langue FR/NL
- ✅ Design responsive mobile-first
- ✅ Navigation sticky
- ✅ Footer complet

### Backend
- ✅ Modèles: Service, Project, Testimonial, ContactRequest
- ✅ Migrations complètes
- ✅ Seeders pour les services
- ✅ Contrôleurs frontend
- ✅ Système de traduction bilingue
- ✅ Middleware de localisation

### Interface d'Administration
- 🔜 CRUD complet pour Services
- 🔜 CRUD complet pour Projects
- 🔜 CRUD complet pour Testimonials
- 🔜 Gestion des demandes de contact

## 📁 Structure du Projet

```
SVSRenov/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── ServiceController.php
│   │   │   │   ├── ProjectController.php
│   │   │   │   └── ContactController.php
│   │   │   └── LanguageController.php
│   │   └── Middleware/
│   │       ├── SetLocale.php
│   │       └── HandleInertiaRequests.php
│   └── Models/
│       ├── Service.php
│       ├── Project.php
│       ├── Testimonial.php
│       └── ContactRequest.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── ServiceSeeder.php
├── lang/
│   ├── fr/
│   │   └── messages.php
│   └── nl/
│       └── messages.php
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   │   └── Frontend/
│   │   │       ├── Header.vue
│   │   │       ├── Footer.vue
│   │   │       └── LanguageSwitcher.vue
│   │   ├── Composables/
│   │   │   └── useTranslations.js
│   │   ├── Layouts/
│   │   │   └── FrontendLayout.vue
│   │   ├── Pages/
│   │   │   └── Frontend/
│   │   │       ├── Home.vue
│   │   │       ├── Services.vue
│   │   │       ├── Portfolio.vue
│   │   │       └── Contact.vue
│   │   └── i18n.js
│   └── views/
│       └── app.blade.php
└── routes/
    └── web.php
```

## 🎯 Routes Principales

- `/` - Page d'accueil
- `/services` - Liste des services
- `/services/{slug}` - Détail d'un service
- `/portfolio` - Portfolio (projets avant/après)
- `/contact` - Formulaire de contact
- `POST /language/{locale}` - Switch de langue (fr/nl)

## 🔧 Commandes Artisan Utiles

```bash
# Créer un utilisateur admin
php artisan tinker
>>> \App\Models\User::factory()->create(['email' => 'admin@svsrenov.be'])

# Rafraîchir la base de données
php artisan migrate:fresh --seed

# Vider le cache
php artisan optimize:clear
```

## 📱 Responsive Design

Le site est optimisé mobile-first avec Tailwind CSS:
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

## 🌍 Internationalisation

Le site supporte deux langues:
- **Français (FR)** - langue par défaut
- **Néerlandais (NL)**

Les traductions sont gérées par:
- Backend: fichiers PHP dans `lang/{locale}/messages.php`
- Frontend: composable `useTranslations()` avec Inertia

## 📧 Contact

- **Email**: info@svsrenov.be
- **Téléphone**: +32 123 456 789
- **Localisation**: Belgique

## 📄 Licence

Projet propriétaire - SVS RENOV © 2025

---

**Développé avec Laravel 11, Vue.js 3 et Inertia.js**
