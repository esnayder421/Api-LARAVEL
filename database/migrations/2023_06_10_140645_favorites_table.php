<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('favorites', function (Blueprint $table)
    {
        $table->bigIncrements('id');
        $table->string('refApi')->nullable();
        $table->unsignedBigInteger('idUser');
        $table->foreign('idUser')->references('id')->on('users');
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
        //
    }
}
