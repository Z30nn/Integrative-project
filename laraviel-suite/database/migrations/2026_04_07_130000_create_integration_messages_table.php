<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('integration_messages')) {
            Schema::create('integration_messages', function (Blueprint $table) {
                $table->id();
                $table->string('message_key')->unique();
                $table->string('topic');
                $table->string('event_type');
                $table->string('aggregate_type')->nullable();
                $table->string('aggregate_id')->nullable();
                $table->json('payload');
                $table->enum('status', ['pending', 'processing', 'processed', 'failed', 'dead_letter'])
                    ->default('pending')
                    ->index();
                $table->unsignedInteger('attempts')->default(0);
                $table->unsignedInteger('max_attempts')->default(5);
                $table->timestamp('available_at')->nullable()->index();
                $table->timestamp('processed_at')->nullable();
                $table->timestamp('dead_letter_at')->nullable();
                $table->text('last_error')->nullable();
                $table->timestamps();

                $table->index(['topic', 'event_type']);
                $table->index(['aggregate_type', 'aggregate_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_messages');
    }
};
