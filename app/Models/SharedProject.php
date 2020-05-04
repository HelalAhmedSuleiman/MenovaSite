<?php

namespace App\Models;

use Dot\Industries\Models\Industry;
use Dot\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class SharedProject extends Model
{
    protected $table = 'shared_projects';

    public function industry(){
       return $this->belongsTo(Industry::class);
    }

    public function media(){
        return $this->belongsToMany(Media::class, 'shared_projects_media', 'project_id', 'media_id');
    }

    public function freelancer(){
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
