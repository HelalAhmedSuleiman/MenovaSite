<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\SharedProject;
use App\Models\User;
use Dot\Media\Models\Media;
use Illuminate\Http\Request;

class AuthFreelancer extends Controller implements IAuth
{
    static function register(Request $request, $user_id)
    {
        $freelancer = new Freelancer();
        $freelancer->user_id = $user_id;
        $freelancer->hourly_rate = $request->get('hourly_rate', null);
        $freelancer->industry_id = $request->get('industry_id', null);
        $freelancer->location_id = $request->get('location_id', null);
        $freelancer->english_level = $request->get('english_level', null);
        $freelancer->share_project = $share_project = $request->get('share_project', 0);
        $freelancer->save();
        if ($request->file('cv')) {
            $media = new Media();
            $freelancer->media_id = $media->saveFile($request->file('cv'));
        }

        //Saving project if he registered as sharing project
        if ($share_project) {
            $project_data = $request->get('project');
            $project = new SharedProject();
            $project->name = $project_data['name'];
            $project->description = $project_data['description'] ?? null;
            $project->industry_id = $project_data['industry_id'] ?? null;
            $project->freelancer_id = $freelancer->id;
            $project->save();
            if ($files = $project_data['media']) {
                foreach ($files as $file) {
                    $media = new Media();
                    $project->media()->attach($media->saveFile($file));
                }
            }
        }
        fauth()->login(User::find($user_id));
        return redirect()->route('index');
    }
}