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
        Schema::create('ownership_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ownby_id')->nullable()->constrained();
            $table->unsignedBigInteger('transferto_id')->nullable()->constrained();
            $table->unsignedBigInteger('changer_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('assembly_id')->constrained();
            $table->unsignedBigInteger('original_assembly_id')->constrained();
            $table->unsignedBigInteger('transfered_assembly_id')->constrained();
            $table->string('reason');

            $table->foreign('original_assembly_id')->references('id')->on('assemblies')->onDelete('cascade');
            $table->foreign('transfered_assembly_id')->references('id')->on('assemblies')->onDelete('cascade');
            $table->foreign('ownby_id')->references('id')->on('users');
            $table->foreign('transferto_id')->references('id')->on('users');
            $table->foreign('changer_id')->references('id')->on('users');
            $table->$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownership_changes');
    }
};
