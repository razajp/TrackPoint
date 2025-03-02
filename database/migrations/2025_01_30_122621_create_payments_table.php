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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained(); // Assuming customers table exists
            $table->string('type');
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->string('cheque_no')->nullable();
            $table->string('bank')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('clear_date')->nullable();
            $table->string('slip_no')->nullable();
            $table->string('party')->nullable();
            $table->string('t_id')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
