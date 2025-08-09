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
        Schema::create('survey_options', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('survey_question_id');
            $t->string('label');
            $t->string('value');
            $t->timestamps();
            $t->foreign('survey_question_id', 'fk_survey_options_question')
              ->references('id')->on('survey_questions')
              ->cascadeOnDelete();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_options');
    }
};
