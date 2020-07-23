<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cart', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('cashier_id');
      $table->dateTime('date_time');
      $table->timestamps();

      $table->foreign('cashier_id')->references('id')->on('cashier');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('cart');
  }
}
