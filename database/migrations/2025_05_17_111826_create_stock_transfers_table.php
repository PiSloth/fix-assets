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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->unsignedBigInteger('original_assembly_id')->constrained();
            $table->unsignedBigInteger('transfered_assembly_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('remark')->nullable();
            $table->foreign('original_assembly_id')->references('id')->on('assemblies')->onDelete('cascade');
            $table->foreign('transfered_assembly_id')->references('id')->on('assemblies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
