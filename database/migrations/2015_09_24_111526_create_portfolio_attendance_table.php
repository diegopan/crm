<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portfolio_id')->unsigned();
            $table->foreign('portfolio_id')->references('id')->on('portfolios');
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
        Schema::drop('portfolio_attendances');
    }
}
