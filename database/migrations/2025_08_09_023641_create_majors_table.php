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
        Schema::create('majors', function (Blueprint $t) {
            $t->id();
            $t->string('code',50)->unique();
            $t->string('name');
            $t->text('description')->nullable();
            $t->json('tags')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
