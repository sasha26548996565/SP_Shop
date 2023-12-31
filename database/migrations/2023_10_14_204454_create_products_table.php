<?php

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text');
            $table->fullText(['title', 'text']);
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('price');
            $table->integer('quantity');
            $table->boolean('on_home_page');
            $table->integer('sorting');

            $table->foreignIdFor(Brand::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('products');
        }
    }
};
