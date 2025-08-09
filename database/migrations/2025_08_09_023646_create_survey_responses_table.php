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
            $t->foreignId('survey_id')->constrained()->cascadeOnDelete()->index();
            $t->foreignId('survey_question_id')->constrained()->cascadeOnDelete();
            $t->json('answer_json');
            $t->timestamps();
            $t->unique(['survey_id','survey_question_id']);
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
