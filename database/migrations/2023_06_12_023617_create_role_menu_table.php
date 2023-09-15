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
        Schema::create('role_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('id_role')->unsigned();
            $table->string('as_role')->nullable();
            $table->integer('id_menu')->unsigned();
            $table->string('as_menu')->nullable();
            $table->integer('sort')->nullable();
            $table->boolean('select')->default('f');
            $table->boolean('insert')->default('f');
            $table->boolean('update')->default('f');
            $table->boolean('delete')->default('f');
            $table->boolean('import')->default('f');
            $table->boolean('export')->default('f');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_menu');
    }
};
