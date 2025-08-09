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
        Schema::create('scores', function (Blueprint $t) {
            $t->id();
            // Explicit FK names to avoid duplicate auto-named constraints on some MySQL/MariaDB setups
            $t->unsignedBigInteger('survey_id');
            $t->index('survey_id');
            $t->unsignedBigInteger('subject_id');
            $t->decimal('score_decimal',5,2);
            $t->timestamps();
            $t->unique(['survey_id','subject_id']);

            $t->foreign('survey_id', 'fk_scores_survey')
                ->references('id')->on('surveys')
                ->cascadeOnDelete();
            $t->foreign('subject_id', 'fk_scores_subject')
                ->references('id')->on('subjects')
                ->cascadeOnDelete();
          });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
