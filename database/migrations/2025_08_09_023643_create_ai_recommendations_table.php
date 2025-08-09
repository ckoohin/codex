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
        Schema::create('ai_recommendations', function (Blueprint $t) {
            $t->id();
            // Use explicit FK name to avoid duplicate name issues
            $t->unsignedBigInteger('survey_id');
            $t->unique('survey_id');
            $t->string('model');
            $t->char('prompt_hash',64);
            $t->json('ai_raw_json')->nullable();
            $t->json('top_major_ids_json')->nullable();
            $t->longText('explanation_md')->nullable();
            $t->json('score_breakdown_json')->nullable();
            $t->timestamps();
            $t->foreign('survey_id', 'fk_ai_recommendations_survey')
                ->references('id')->on('surveys')
                ->cascadeOnDelete();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
    }
};
