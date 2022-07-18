<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductslistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productslist', function (Blueprint $table) {
            $table->id();
            $table->string('body_html');
            $table->string('title');
            $table->string('handle');
            $table->enum('status', ['Active', 'Is_Active']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productslist');
    }
}
