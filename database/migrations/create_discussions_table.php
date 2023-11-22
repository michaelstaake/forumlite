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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('member');
            $table->longtext('title');
            $table->string('slug');
            $table->longtext('content');
            $table->integer('views')->default(0);
            $table->boolean('is_locked')->default(FALSE);
            $table->boolean('is_hidden')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
