<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sounds", function(Blueprint $table){
        	$table->integer("userId")->length(10)->unsigned();
        	$table->increments("soundId");
        	$table->timestamps();
        	$table->text("data");
        	$table->integer("upCount")->length(10)->unsigned();
        	// $table->foreign("userId")->references("userId")
        	// 	->on("users")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("sounds");
    }
}
