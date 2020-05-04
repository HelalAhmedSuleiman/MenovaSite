<?php

namespace App\Models;

use App\Models\User;
use Dot\I18n\Models\Place;
use Dot\Industries\Models\Industry;
use Dot\Media\Models\Media;

class Freelancer extends User
{
    protected $table = "freelancers";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function cv()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function location()
    {
        return $this->belongsTo(Place::class);
    }

    public function shared_projects()
    {
        return $this->hasMany(SharedProject::class, 'freelancer_id');
    }

}
