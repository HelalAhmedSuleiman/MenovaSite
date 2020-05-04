<?php

namespace App\Models;

use Dot\Languages\Models\Language;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Dot\Users\Models\User as Model;

class User extends Model
{
    use Notifiable;

    public function languages(){
        return $this->belongsToMany(Language::class, 'users_languages','user_id', 'language_id');
    }

    function scopeProvider($query, $provider){
        $query->where("provider", $provider);
    }
}
