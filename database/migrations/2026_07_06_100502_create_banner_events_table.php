<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_events', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('banner_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid('placement_id')
                ->constrained('banner_placements')
                ->cascadeOnDelete();
            $table->foreignUlid('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('type')->index();
            $table->string('session_id')->nullable()->index();
            $table->ipAddress('ip')->nullable();
            $table->string('country', 2)->nullable()->index();
            $table->string('device')->nullable()->index();
            $table->boolean('is_mobile')->nullable()->index();
            $table->string('browser')->nullable()->index();
            $table->string('operating_system')->nullable()->index();
            $table->string('user_agent')->nullable();
            $table->string('locale', 10)->nullable()->index();
            $table->string('timezone')->nullable();
            $table->string('screen')->nullable();
            $table->text('referer')->nullable();
            $table->string('utm_source')->nullable()->index();
            $table->string('utm_medium')->nullable()->index();
            $table->string('utm_campaign')->nullable()->index();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index([
                'banner_id',
                'placement_id',
                'type',
                'created_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_events');
    }
};
