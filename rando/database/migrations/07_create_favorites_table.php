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
        Schema::create('favorites', function (Blueprint $table) {
            // Clés étrangères
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();

            // Clé primaire composite
            $table->primary(['user_id', 'place_id']);

            // Champs supplémentaires
            $table->boolean('is_favorite')->default(true); // Favori ou non
            $table->unsignedTinyInteger('rating')->nullable(); // Note de 1 à 5
            $table->text('comment')->nullable(); // Commentaire de l’utilisateur

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
