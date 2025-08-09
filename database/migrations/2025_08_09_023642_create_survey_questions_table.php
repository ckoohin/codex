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
        Schema::create('survey_questions', function (Blueprint $t) {
            $t->id();
            $t->enum('category',['interests','skills','traits','habits','career']);
            $t->text('text');
            $t->enum('type',['single','multi','scale','text']);
            $t->integer('display_order');
            $t->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
