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
        Schema::create('assemblies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->foreignId('user_id')->constrained();
            $table->binary('image')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assemblies');
    }
};
