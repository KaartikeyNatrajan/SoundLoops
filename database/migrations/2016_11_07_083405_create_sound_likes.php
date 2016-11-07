<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoundLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sound_likes", function(Blueprint $table){
            $table->integer("userId")->length(10)->unsigned();
            $table->integer("soundId")->length(10)->unsigned();

            $table->primary(['userId', 'soundId']);

            $table->timestamps();
            
            $table->foreign("userId")->references("userId")
                ->on("users")->onDelete("cascade")->onUpdate("cascade");
            
            $table->foreign("soundId")->references("soundId")
                ->on("sounds")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("sound_likes");
    }
}
