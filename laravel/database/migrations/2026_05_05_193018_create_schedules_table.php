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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('suite_id')->constrained()->onDelete('cascade');
            $table->foreignId('suite_unit_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->string('status')->default(\App\Enums\ScheduleStatusEnum::PENDING->value);
            $table->decimal('total_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
