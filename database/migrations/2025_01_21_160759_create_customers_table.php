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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('person_name');
            $table->string('phone')->unique();
            $table->string('city');
            $table->string('address')->nullable();
            $table->string('image')->default('default_customer.png');
            $table->string('status')->default('active');
            $table->unique(['customer', 'city']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
