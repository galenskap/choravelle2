<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Pupitre;
use App\Models\Folder;
use App\Models\Song;
use App\Models\File;
use App\Models\Event;
use App\Models\Page;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎭 Création des données de test...');

        // Créer les tenants
        $this->createTenants();
        
        // Créer les utilisateurs admin
        $this->createAdminUsers();
        
        // Créer les pupitres
        $this->createPupitres();
        
        // Créer les utilisateurs factices
        $this->createFakeUsers();
        
        // Créer les dossiers de saison
        $this->createSeasonFolders();
        
        // Créer les chansons et fichiers
        $this->createSongsAndFiles();
        
        // Créer les événements
        $this->createEvents();
        
        // Créer les pages d'accueil
        $this->createHomepages();
        
        $this->command->info('✅ Données de test créées avec succès !');
    }

    private function createTenants(): void
    {
        $this->command->info('📝 Création des organisations...');
        
        Tenant::create([
            'name' => 'Dames de choeur',
            'slug' => 'damesdechoeur',
            'domain' => 'damesdechoeur.fr',
            'description' => 'Choeur féminin des Dames de choeur',
            'status' => 'active',
        ]);

        Tenant::create([
            'name' => 'Music M Choeur',
            'slug' => 'musicmchoeur',
            'domain' => 'musicmchoeur.com',
            'description' => 'Choeur mixte Music M Choeur',
            'status' => 'active',
        ]);
    }

    private function createAdminUsers(): void
    {
        $this->command->info('👥 Création des utilisateurs admin...');
        
        $adminRole = Role::where('name', 'admin')->first();
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();

        // Admin pour Dames de choeur
        $ddcAdmin = User::create([
            'name' => 'Admin Dames de Choeur',
            'email' => 'jean.deborah+ddc@gmail.com',
            'password' => Hash::make('auieauie'),
            'email_verified_at' => now(),
            'is_active' => true,
            'tenant_id' => $ddcTenant->id,
        ]);
        if ($adminRole) {
            $ddcAdmin->assignRole($adminRole);
        }

        // Admin pour Music M Choeur
        $mmcAdmin = User::create([
            'name' => 'Admin Music M Choeur',
            'email' => 'jean.deborah+mmc@gmail.com',
            'password' => Hash::make('auieauie'),
            'email_verified_at' => now(),
            'is_active' => true,
            'tenant_id' => $mmcTenant->id,
        ]);
        if ($adminRole) {
            $mmcAdmin->assignRole($adminRole);
        }
    }

    private function createPupitres(): void
    {
        $this->command->info('🎼 Création des pupitres...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();

        // Pupitres pour Dames de choeur
        $ddcPupitres = ['Alti', 'Sopranes 1', 'Sopranes 2'];
        foreach ($ddcPupitres as $pupitre) {
            Pupitre::create([
                'name' => $pupitre,
                'tenant_id' => $ddcTenant->id,
            ]);
        }

        // Pupitres pour Music M Choeur
        $mmcPupitres = ['Alti', 'Sopranes', 'Ténors', 'Basses'];
        foreach ($mmcPupitres as $pupitre) {
            Pupitre::create([
                'name' => $pupitre,
                'tenant_id' => $mmcTenant->id,
            ]);
        }
    }

    private function createFakeUsers(): void
    {
        $this->command->info('👨‍👩‍👧‍👦 Création des utilisateurs factices...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();
        
        $ddcPupitres = Pupitre::where('tenant_id', $ddcTenant->id)->get();
        $mmcPupitres = Pupitre::where('tenant_id', $mmcTenant->id)->get();
        
        $fakeNames = [
            'Marie Dupont', 'Sophie Martin', 'Claire Bernard', 'Julie Dubois', 'Camille Rousseau',
            'Emma Laurent', 'Léa Moreau', 'Chloé Simon', 'Manon Michel', 'Sarah Leroy',
            'Anaïs Garcia', 'Laura Rodriguez', 'Pauline Martinez', 'Océane Lopez', 'Inès Gonzalez',
            'Alice Perez', 'Juliette Sanchez', 'Eva Romero', 'Lola Ruiz', 'Mathilde Fernandez',
            'Pierre Durand', 'Antoine Thomas', 'Nicolas Robert', 'Alexandre Petit', 'Maxime Richard',
            'Lucas Moreau', 'Hugo Simon', 'Théo Michel', 'Louis Leroy', 'Julien Garcia',
            'Benjamin Rodriguez', 'Romain Martinez', 'Quentin Lopez', 'Adrien Gonzalez', 'Kevin Perez',
            'Florian Sanchez', 'Damien Romero', 'Jérémy Ruiz', 'Vincent Fernandez', 'Sébastien Morales'
        ];

        // Utilisateurs pour Dames de choeur
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $fakeNames[$i],
                'email' => 'ddc.user' . ($i + 1) . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'tenant_id' => $ddcTenant->id,
                'pupitre_id' => $ddcPupitres->random()->id,
            ]);
        }

        // Utilisateurs pour Music M Choeur
        for ($i = 20; $i < 40; $i++) {
            User::create([
                'name' => $fakeNames[$i],
                'email' => 'mmc.user' . ($i - 19) . '@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'tenant_id' => $mmcTenant->id,
                'pupitre_id' => $mmcPupitres->random()->id,
            ]);
        }
    }

    private function createSeasonFolders(): void
    {
        $this->command->info('📁 Création des dossiers de saison...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();

        Folder::create([
            'name' => 'Saison 2025-2026',
            'is_current' => true,
            'order' => 1,
            'tenant_id' => $ddcTenant->id,
        ]);

        Folder::create([
            'name' => 'Saison 2025-2026',
            'is_current' => true,
            'order' => 1,
            'tenant_id' => $mmcTenant->id,
        ]);
    }

    private function createSongsAndFiles(): void
    {
        $this->command->info('🎵 Création des chansons et fichiers...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();
        
        $ddcFolder = Folder::where('tenant_id', $ddcTenant->id)->first();
        $mmcFolder = Folder::where('tenant_id', $mmcTenant->id)->first();
        
        $ddcPupitres = Pupitre::where('tenant_id', $ddcTenant->id)->get();
        $mmcPupitres = Pupitre::where('tenant_id', $mmcTenant->id)->get();

        $songTitles = [
            'Ave Maria', 'Hallelujah', 'Amazing Grace', 'The Sound of Silence', 'Bridge Over Troubled Water',
            'Imagine', 'What a Wonderful World', 'Somewhere Over the Rainbow', 'Moon River', 'Edelweiss',
            'Memory', 'The Prayer', 'You Raise Me Up', 'Time to Say Goodbye', 'Nella Fantasia'
        ];

        $authors = [
            'Franz Schubert', 'Leonard Cohen', 'John Newton', 'Simon & Garfunkel', 'Paul Simon',
            'John Lennon', 'Louis Armstrong', 'Harold Arlen', 'Henry Mancini', 'Rodgers & Hammerstein',
            'Andrew Lloyd Webber', 'David Foster', 'Rolf Løvland', 'Francesco Sartori', 'Ennio Morricone'
        ];

        // Chansons pour Dames de choeur
        for ($i = 0; $i < 10; $i++) {
            $song = Song::create([
                'title' => $songTitles[$i],
                'author' => $authors[$i],
                'lyrics' => 'Paroles de la chanson ' . $songTitles[$i] . '...',
                'comment' => 'Commentaire pour ' . $songTitles[$i],
                'show_on_home' => rand(0, 1),
                'tenant_id' => $ddcTenant->id,
            ]);

            // Lier la chanson au dossier
            $ddcFolder->songs()->attach($song->id, ['order' => $i + 1]);

            // Créer 2 fichiers par chanson
            for ($j = 1; $j <= 2; $j++) {
                $file = File::create([
                    'filename' => 'files/ddc_' . $song->id . '_file_' . $j . '.pdf',
                    'title' => $song->title . ' - Partie ' . $j,
                    'song_id' => $song->id,
                    'tenant_id' => $ddcTenant->id,
                    'sort_order' => $j,
                ]);

                // Assigner aléatoirement le fichier à des pupitres
                if (rand(0, 1)) {
                    $file->pupitres()->attach($ddcPupitres->random(rand(1, 2))->pluck('id'));
                }
            }
        }

        // Chansons pour Music M Choeur
        for ($i = 5; $i < 15; $i++) {
            $songIndex = $i % count($songTitles);
            $song = Song::create([
                'title' => $songTitles[$songIndex],
                'author' => $authors[$songIndex],
                'lyrics' => 'Paroles de la chanson ' . $songTitles[$songIndex] . ' version MMC...',
                'comment' => 'Commentaire pour ' . $songTitles[$songIndex] . ' version MMC',
                'show_on_home' => rand(0, 1),
                'tenant_id' => $mmcTenant->id,
            ]);

            // Lier la chanson au dossier
            $mmcFolder->songs()->attach($song->id, ['order' => $i - 4]);

            // Créer 2 fichiers par chanson
            for ($j = 1; $j <= 2; $j++) {
                $file = File::create([
                    'filename' => 'files/mmc_' . $song->id . '_file_' . $j . '.pdf',
                    'title' => $song->title . ' - Partie ' . $j,
                    'song_id' => $song->id,
                    'tenant_id' => $mmcTenant->id,
                    'sort_order' => $j,
                ]);

                // Assigner aléatoirement le fichier à des pupitres
                if (rand(0, 1)) {
                    $file->pupitres()->attach($mmcPupitres->random(rand(1, 3))->pluck('id'));
                }
            }
        }
    }

    private function createEvents(): void
    {
        $this->command->info('📅 Création des événements...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();

        $eventTitles = [
            'Concert de Printemps', 'Répétition générale', 'Concert de Noël', 'Audition publique',
            'Festival de chorales', 'Concert caritatif', 'Représentation en plein air'
        ];

        $locations = [
            'Église Saint-Martin', 'Salle des fêtes', 'Théâtre municipal', 'Conservatoire',
            'Place du village', 'Centre culturel', 'Auditorium'
        ];

        // Événements pour Dames de choeur
        // 2 événements futurs
        for ($i = 0; $i < 2; $i++) {
            Event::create([
                'title' => $eventTitles[$i],
                'date' => Carbon::now()->addDays(rand(10, 60)),
                'time' => rand(14, 20) . ':' . (rand(0, 1) ? '00' : '30'),
                'location' => $locations[array_rand($locations)],
                'description' => 'Description de l\'événement ' . $eventTitles[$i],
                'members_only' => rand(0, 1),
                'tenant_id' => $ddcTenant->id,
            ]);
        }

        // 5 événements passés
        for ($i = 2; $i < 7; $i++) {
            Event::create([
                'title' => $eventTitles[$i % count($eventTitles)],
                'date' => Carbon::now()->subDays(rand(10, 180)),
                'time' => rand(14, 20) . ':' . (rand(0, 1) ? '00' : '30'),
                'location' => $locations[array_rand($locations)],
                'description' => 'Description de l\'événement ' . $eventTitles[$i % count($eventTitles)],
                'members_only' => rand(0, 1),
                'tenant_id' => $ddcTenant->id,
            ]);
        }

        // Événements pour Music M Choeur
        // 2 événements futurs
        for ($i = 0; $i < 2; $i++) {
            Event::create([
                'title' => $eventTitles[$i],
                'date' => Carbon::now()->addDays(rand(10, 60)),
                'time' => rand(14, 20) . ':' . (rand(0, 1) ? '00' : '30'),
                'location' => $locations[array_rand($locations)],
                'description' => 'Description de l\'événement ' . $eventTitles[$i],
                'members_only' => rand(0, 1),
                'tenant_id' => $mmcTenant->id,
            ]);
        }

        // 5 événements passés
        for ($i = 2; $i < 7; $i++) {
            Event::create([
                'title' => $eventTitles[$i % count($eventTitles)],
                'date' => Carbon::now()->subDays(rand(10, 180)),
                'time' => rand(14, 20) . ':' . (rand(0, 1) ? '00' : '30'),
                'location' => $locations[array_rand($locations)],
                'description' => 'Description de l\'événement ' . $eventTitles[$i % count($eventTitles)],
                'members_only' => rand(0, 1),
                'tenant_id' => $mmcTenant->id,
            ]);
        }
    }

    private function createHomepages(): void
    {
        $this->command->info('🏠 Création des pages d\'accueil...');
        
        $ddcTenant = Tenant::where('slug', 'damesdechoeur')->first();
        $mmcTenant = Tenant::where('slug', 'musicmchoeur')->first();

        Page::create([
            'slug' => 'homepage',
            'title' => 'Accueil - Dames de Choeur',
            'description' => 'Page d\'accueil du site des Dames de Choeur',
            'is_published' => true,
            'tenant_id' => $ddcTenant->id,
        ]);

        Page::create([
            'slug' => 'homepage',
            'title' => 'Accueil - Music M Choeur',
            'description' => 'Page d\'accueil du site de Music M Choeur',
            'is_published' => true,
            'tenant_id' => $mmcTenant->id,
        ]);
    }
} 