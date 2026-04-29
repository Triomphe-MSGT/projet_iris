<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            // Le propriétaire actuel (Utilisateur Polyvalent)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->text('description');
            $table->decimal('price_cfa', 15, 2);
            $table->string('location')->default('Dschang');
            $table->string('coordinates')->nullable(); // Pour la géolocalisation
            $table->string('status')->default('disponible'); // disponible, en_attente, vendu
            
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};