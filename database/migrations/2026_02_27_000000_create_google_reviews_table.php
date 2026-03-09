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
        Schema::create('google_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('google_review_id')->unique();
            $table->string('author_name');
            $table->string('author_photo_url')->nullable();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->string('relative_time')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
    }
};
