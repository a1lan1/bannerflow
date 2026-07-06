<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_statistics', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('banner_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid('placement_id')
                ->constrained('banner_placements')
                ->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('hour')->nullable();
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->decimal('ctr', 8, 2)->default(0);
            $table->timestamps();

            $table->unique([
                'banner_id',
                'placement_id',
                'date',
                'hour',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_statistics');
    }
};
