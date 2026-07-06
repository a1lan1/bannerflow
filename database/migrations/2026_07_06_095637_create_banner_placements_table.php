<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_placements', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('rotation_strategy')->default('weighted');
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('max_banners')->default(1);
            $table->timestamps();
        });

        Schema::create('banner_placement_banner', function (Blueprint $table): void {
            $table->foreignUlid('banner_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid('placement_id')
                ->constrained('banner_placements')
                ->cascadeOnDelete();

            $table->primary([
                'banner_id',
                'placement_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_placement_banner');
        Schema::dropIfExists('banner_placements');
    }
};
