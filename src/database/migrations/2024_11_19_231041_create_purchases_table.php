<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unsigned()->nullable('false');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('user_id')->unsigned()->nullable('false');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('payment')->nullable('false');
            $table->string('post_code')->nullable('false');
            $table->string('address')->nullable('false');
            $table->string('building')->nullable('false');
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
        Schema::dropIfExists('purchases');
    }
}
