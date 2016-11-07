<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    public $primaryKey = "userId";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sound()
    {
        return $this->hasMany("App\Sound", "userId", "userId");
    }

    public function favourites()
    {
        return $this->belongsToMany(Sound::class, 'sound_likes', 'userId', 'soundId')
            ->withTimestamps();
    }

    public function hasFavourited($soundId)
    {
        $result = $this->favourites()->find($soundId);
        
        if(is_null($result))
        {
            return false;
        }
        
        return true;
    }
}
