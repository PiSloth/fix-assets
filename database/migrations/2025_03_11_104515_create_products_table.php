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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('assembly_id')->constrained('assemblies');
            $table->string('code');
            $table->string('serial_number')->nullable();
            $table->string('description');
            $table->date('purchase_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('purchase_from')->nullable();
            $table->stirng('status')->default('active');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
