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
        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id');
            $t->index('user_id');
            $t->string('action');
            $t->json('payload_json')->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->foreign('user_id', 'fk_audit_logs_user')
              ->references('id')->on('users')
              ->cascadeOnDelete();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
