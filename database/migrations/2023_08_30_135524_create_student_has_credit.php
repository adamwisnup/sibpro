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
        Schema::create('student_has_credit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('credit_id')->nullable();
            $table->enum('status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->decimal('credit_price', 10, 2)->default(0);
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('credit_id')->references('id')->on('credits')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_has_credit');
    }
};
