<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('campaign_id')
                ->nullable()
                ->constrained('banner_campaigns')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('link');
            $table->string('target')->default('_blank');
            $table->string('alt')->nullable();
            $table->string('status')->index();
            $table->unsignedInteger('priority')->default(0)->index();
            $table->unsignedInteger('weight')->default(100);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('max_impressions')->nullable();
            $table->unsignedBigInteger('max_clicks')->nullable();
            $table->unsignedInteger('daily_impressions_limit')->nullable();
            $table->unsignedInteger('daily_clicks_limit')->nullable();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
