<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    protected $table = "sounds";
    public $primaryKey = "soundId";

    public function user()
    {
    	return $this->belongsTo('App\User', 'userId', 'userId');
    }
}


?>
