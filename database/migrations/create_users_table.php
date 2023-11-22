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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->boolean('is_admin')->default(FALSE);
            $table->boolean('is_banned')->default(FALSE);
            $table->string('group')->default('member');
            $table->string('timezone')->nullable();
            $table->string('theme')->nullable();
            $table->string('avatar')->nullable();
            $table->string('signature')->nullable();
            $table->string('about_me')->nullable();
            $table->string('location')->nullable();
            $table->integer('karma')->default(0);
            $table->boolean('wants_emails_my_discussions')->default(TRUE)->nullable();;
            $table->boolean('wants_emails_watched_discussions')->default(TRUE)->nullable();;
            $table->string('language')->default('en-us');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_active')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
