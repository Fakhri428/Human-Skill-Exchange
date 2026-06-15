<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('max_skills')->nullable();
            $table->unsignedInteger('max_needs')->nullable();
            $table->unsignedInteger('max_offers')->nullable();
            $table->unsignedInteger('max_exchange_requests')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('user');
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('bio');
            $table->string('location', 120);
            $table->string('work_mode', 20)->default('online');
            $table->string('available_time', 120);
            $table->string('portfolio_url')->nullable();
            $table->string('social_url')->nullable();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('category', 100);
            $table->string('level', 20)->default('beginner');
            $table->timestamps();
        });

        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 180);
            $table->string('category', 100);
            $table->text('description');
            $table->text('exchange_offer');
            $table->timestamps();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 180);
            $table->string('type', 30);
            $table->string('category', 100);
            $table->text('description');
            $table->text('exchange_expectation');
            $table->string('available_duration', 120)->nullable();
            $table->timestamps();
        });

        Schema::create('exchange_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('offer_id')->nullable()->constrained('offers')->nullOnDelete();
            $table->foreignId('need_id')->nullable()->constrained('needs')->nullOnDelete();
            $table->text('message');
            $table->string('status', 30)->default('pending');
            $table->boolean('completed_by_from_user')->default(false);
            $table->boolean('completed_by_to_user')->default(false);
            $table->timestamps();
        });

        Schema::create('exchange_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchange_request_id')->constrained('exchange_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('progress_note');
            $table->string('file_url')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchange_request_id')->constrained('exchange_requests')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reviewed_user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->timestamps();
            $table->unique(['exchange_request_id', 'reviewer_id', 'reviewed_user_id'], 'unique_exchange_review');
        });

        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 160);
            $table->text('description');
            $table->string('file_url')->nullable();
            $table->string('project_url')->nullable();
            $table->timestamps();
        });

        Schema::create('mentoring_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 180);
            $table->text('description');
            $table->unsignedInteger('duration_minutes');
            $table->unsignedInteger('price')->default(0);
            $table->dateTime('schedule')->nullable();
            $table->string('status', 30)->default('open');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedInteger('amount');
            $table->unsignedInteger('platform_fee')->default(0);
            $table->string('status', 30)->default('pending');
            $table->string('payment_method', 80)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('mentoring_rooms');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('exchange_progress');
        Schema::dropIfExists('exchange_requests');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('needs');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('plan_id');
            $table->dropColumn('role');
        });

        Schema::dropIfExists('plans');
    }
};
