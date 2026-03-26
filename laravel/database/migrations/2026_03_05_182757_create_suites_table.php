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
        Schema::create('suites', function (Blueprint $table) {
            $table->id();
            $table->string('type_suite');
            $table->decimal("amount_per_hour", 8, 2);
            $table->timestamps();
        });

        Schema::create('suite_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suite_id')->constrained('suites')->onDelete('cascade');
            
            $table->string('room_number');
            $table->enum('status', ['FREE', 'OCCUPIED', 'CLEANING', 'MAINTENANCE', 'BOOKED'])->default('FREE');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suite_units');
        Schema::dropIfExists('suites');
    }
};
