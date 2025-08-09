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
        Schema::create('survey_responses', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('survey_id');
            $t->index('survey_id');
            $t->unsignedBigInteger('survey_question_id');
            $t->json('answer_json');
            $t->timestamps();
            $t->unique(['survey_id','survey_question_id']);

            // Explicit foreign key names to avoid duplicate auto-generated constraint names
            $t->foreign('survey_id', 'fk_survey_responses_survey')
                ->references('id')->on('surveys')
                ->cascadeOnDelete();
            $t->foreign('survey_question_id', 'fk_survey_responses_question')
                ->references('id')->on('survey_questions')
                ->cascadeOnDelete();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
