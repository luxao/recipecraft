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
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained()->restrictOnDelete();
            $table->decimal('amount', 10, 3)->nullable(); //nullable pre podľa chuti..
            $table->string('unit', 20)->nullable(); //g, ml, cup, ks ...
            $table->string('note')->nullable(); //napr. "nakrájané na kocky"
            $table->unsignedInteger('sort_order')->default(0); //pre určenie poradia ingrediencií v recepte
            $table->timestamps();
            $table->unique(['recipe_id', 'ingredient_id', 'sort_order']); //zabezpečí, že v rámci jedného receptu nebude duplicitná kombinaia ingrediencie a poradia
            $table->index(['recipe_id', 'sort_order']); //pre rychlejší načítánie ingrediencíí pre recept v spravnom poradí
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};