<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method', 10);
            $table->text('url');
            $table->string('ip', 45)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->smallInteger('status_code')->nullable();
            $table->float('duration_ms')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'status_code']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
