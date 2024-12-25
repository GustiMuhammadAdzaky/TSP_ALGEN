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
        Schema::create('destinasis', function (Blueprint $table) {
            $table->id();
            $table->string('destination_code')->nullable()->unique();
            $table->string('name', 50);
            $table->string('description', 250);
            $table->float('lat');
            $table->float('lng');
            $table->string('img');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasis');
    }
};
