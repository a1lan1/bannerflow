<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_schedules', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('banner_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->unsignedTinyInteger('hour');
            $table->timestamps();

            $table->unique([
                'banner_id',
                'day_of_week',
                'hour',
            ]);

            $table->index([
                'day_of_week',
                'hour',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_schedules');
    }
};
