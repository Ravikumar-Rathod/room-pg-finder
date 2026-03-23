<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('full_address')->nullable();
            $table->decimal('rent', 8, 2);
            $table->enum('room_type', ['single', 'sharing']);
            $table->boolean('wifi')->default(false);
            $table->boolean('ac')->default(false);
            $table->boolean('food')->default(false);
            $table->string('image')->nullable();
            $table->float('rating')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};