<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('pack')->nullable();
            $table->string('count')->nullable();
            $table->string('sum_pack')->nullable();
            $table->string('sum_count')->nullable();
            $table->string('sum');
            $table->integer('merchant_id')->nullable();
            $table->string('type');
            $table->date('date');
            $table->double('price',8,2)->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
