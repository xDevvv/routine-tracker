<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focus_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('routine_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->dateTime('started_at');

            $table->dateTime('ended_at')
                ->nullable();

            $table->dateTime('paused_at')
                ->nullable();

            $table->unsignedInteger('planned_minutes');

            $table->unsignedInteger('actual_minutes')
                ->default(0);

            $table->unsignedInteger('paused_minutes')
                ->default(0);

            $table->enum('status', [
                'running',
                'completed',
                'stopped',
            ])->default('running');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focus_sessions');
    }
};
