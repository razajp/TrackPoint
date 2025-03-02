<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->integer('article_no')->unique();
            $table->date('date');
            $table->integer('quantity')->unsigned();
            $table->integer('sold_quantity')->unsigned()->default(0);
            $table->integer('extra_pcs')->unsigned()->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('size_id');
            $table->string('fabric_type')->nullable();
            $table->decimal('sales_rate', 11, 2);
            $table->json('rates_array');
            $table->string('image')->default('no_image_icon.png');
            $table->timestamps(); // Created at & Updated at
            
            $table->foreign('category_id')->references('id')->on('setups')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('setups')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('setups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
