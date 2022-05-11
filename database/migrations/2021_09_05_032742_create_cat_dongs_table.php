<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatDongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_dongs', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('date');
            $table->integer('weigh');
            $table->integer('price');
            $table->integer('xuongxe')->nullable();
            $table->integer('congthem')->nullable();
            $table->integer('trudi')->nullable();
            $table->integer('ung')->nullable();
            $table->integer('totalmomey');
            $table->string('status','2')->default('1');
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
        Schema::dropIfExists('cat_dongs');
    }
}
