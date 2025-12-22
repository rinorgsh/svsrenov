<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrer les images des projets
        $projects = DB::table('projects')->whereNotNull('image_before')->orWhereNotNull('image_after')->get();

        foreach ($projects as $project) {
            $updates = [];

            // Migrer image_before
            if ($project->image_before && str_starts_with($project->image_before, '/image/projects/')) {
                $oldPath = public_path($project->image_before);
                if (file_exists($oldPath)) {
                    $newPath = str_replace('/image/projects/', 'projects/', $project->image_before);

                    // Créer le dossier dans storage si nécessaire
                    $directory = dirname($newPath);
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }

                    // Copier le fichier
                    Storage::disk('public')->put($newPath, file_get_contents($oldPath));

                    $updates['image_before'] = '/storage/' . $newPath;
                }
            }

            // Migrer image_after
            if ($project->image_after && str_starts_with($project->image_after, '/image/projects/')) {
                $oldPath = public_path($project->image_after);
                if (file_exists($oldPath)) {
                    $newPath = str_replace('/image/projects/', 'projects/', $project->image_after);

                    // Créer le dossier dans storage si nécessaire
                    $directory = dirname($newPath);
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }

                    // Copier le fichier
                    Storage::disk('public')->put($newPath, file_get_contents($oldPath));

                    $updates['image_after'] = '/storage/' . $newPath;
                }
            }

            // Mettre à jour la base de données
            if (!empty($updates)) {
                DB::table('projects')->where('id', $project->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionnel: revenir en arrière
        $projects = DB::table('projects')->whereNotNull('image_before')->orWhereNotNull('image_after')->get();

        foreach ($projects as $project) {
            $updates = [];

            if ($project->image_before && str_starts_with($project->image_before, '/storage/projects/')) {
                $updates['image_before'] = str_replace('/storage/projects/', '/image/projects/', $project->image_before);
            }

            if ($project->image_after && str_starts_with($project->image_after, '/storage/projects/')) {
                $updates['image_after'] = str_replace('/storage/projects/', '/image/projects/', $project->image_after);
            }

            if (!empty($updates)) {
                DB::table('projects')->where('id', $project->id)->update($updates);
            }
        }
    }
};
