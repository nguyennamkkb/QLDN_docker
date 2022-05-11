<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_books', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('customer');
            $table->string('totalmoney');
            $table->string('prepay');
            $table->string('paid');
            $table->json('data');
            $table->json('data1')->nullable();
            
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
        Schema::dropIfExists('payment_books');
    }
}
