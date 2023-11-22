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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('parent')->nullable();
            $table->string('section');
            $table->string('name');
            $table->LongText('description')->nullable();
            $table->string('slug');
            $table->string('order');
            $table->boolean('is_readonly')->default(FALSE);
            $table->boolean('is_hidden')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
