<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned()->nullable('false');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('condition_id')->unsigned()->nullable('false');
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->string('name')->nullable('false');
            $table->integer('price')->nullable('false');
            $table->string('image')->nullable('false');
            $table->text('description')->nullable('false');
            $table->boolean('is_sold_out')->nullable('false');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
