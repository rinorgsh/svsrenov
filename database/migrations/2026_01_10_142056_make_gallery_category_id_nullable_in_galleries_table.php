<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['gallery_category_id']);

            // Modifier la colonne pour la rendre nullable
            $table->unsignedBigInteger('gallery_category_id')->nullable()->change();

            // Recréer la contrainte de clé étrangère avec nullable
            $table->foreign('gallery_category_id')
                  ->references('id')
                  ->on('gallery_categories')
                  ->onDelete('set null');
        });

        // Rendre aussi le titre nullable
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['gallery_category_id']);

            // Remettre la colonne en NON nullable
            $table->unsignedBigInteger('gallery_category_id')->nullable(false)->change();

            // Recréer la contrainte de clé étrangère
            $table->foreign('gallery_category_id')
                  ->references('id')
                  ->on('gallery_categories')
                  ->onDelete('cascade');
        });

        // Remettre le titre en NON nullable
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
    }
};
