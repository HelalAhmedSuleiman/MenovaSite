<?php
/**
 * Created by PhpStorm.
 * User: abdallah
 * Date: 22/04/20
 * Time: 19:29
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\SharedProject;
use App\Models\User;
use Dot\Media\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public $data = array();

    protected $guard = 'frontend';

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (Auth::guard($this->guard)->check()) {
                return redirect("/");
            } else {
                return $next($request);
            }

        })->except(["logout"]);
    }

    public function login(Request $request)
    {
        if ($request->method() == "POST") {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $email = $request->get('email');
            $password = $request->get('password');
            $error = new MessageBag();
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (!fauth()->attempt(['email' => $email, 'password' => $password], $request->filled('remember_me'))) {
                    $error->add('invalid', trans('validation.invalid_login'));
                    return redirect()->back()->withErrors($error->messages())->withInput($request->all());
                }
            } else {
                if (!fauth()->attempt(['username' => $email, 'password' => $email,], $request->filled('remember_me'))) {
                    $error->add('invalid', trans('validation.invalid_login'));
                    return redirect()->back()->withErrors($error->messages())->withInput($request->all());
                }
            }
            return redirect()->route('index');
        }
        return view('login');
    }

    public function register(Request $request)
    {
        if ($request->method() == 'POST') {
            $rules = [
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:3',
                'username' => 'required|min:3|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6|max:255',
            ];
            if ($request->get('user_type') == 2) {
                $rules += [
                    'hourly_rate' => 'number',
                    'cv.mimes' => 'jpg,png,jpeg,doc,docx,pdf',
                    'project.name' => 'required_if:share_project,==,1',
                    'project.description' => 'required_if:share_project,==,1|min:10',
                    'project.media.*.mimes' => 'jpg,png,jpeg,doc,docx,pdf',
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $user = new User();

            //if facebook register
            if (session()->has("provider_auth")) {
                if (session()->get("provider_auth")["provider"] == "facebook") {
                    $user_data = session()->get("provider_auth")["user"];
                    $user->provider = "facebook";
                    $user->provider_id = $user_data->id;
                    $user->email = $user_data->email;
                    $user->username = $user_data->id;
                    $user->first_name = explode(' ', $user_data->user["name"])[0];
                    $user->last_name = explode(' ', $user_data->user["name"])[1];
                    if (!$request->file('avatar')) {
                        $photo = new Media();
                        $avatar_link = '';
                        if (isset($user_data->avatar_original)) {
                            $avatar_link = $user_data->avatar_original;
                        } else if (isset($user_data->avatar)) {
                            $avatar_link = $user_data->avatar;
                        }
                        $photo_id = $photo->saveLink($avatar_link, "frontend")->id;
                        $user->photo_id = $photo_id;
                    }
                }
            } else {
                $user->email = $request->get('email');
                $user->username = $request->get('username');
                $user->first_name = $request->get('first_name');
                $user->last_name = $request->get('last_name');
            }
            $user->password = $request->get('password');
            $user->role_id = 2;
            $user->backend = 0;
            $user->status = 0;
            $user->code = Str::random('8');
            $user->type = $request->get('type', 2);
            if ($request->file('avatar')) {
                $media = new Media();
                $user->photo_id = $media->saveFile($request->file('avatar'));
            }
            $user->save();
            $id = $user->id;
            switch ($request->get('user_type', 2)) {
                case 2:
                    return AuthFreelancer::register($request, $id);
                default:
                    return AuthFreelancer::register($request, $id);
            }

        }
        return view('register');
    }

    public function facebook()
    {
        $row = Socialite::driver('facebook')->user();
        $user = User::provider("facebook")->where('provider_id', $row->id)->first();
        if (!$user) {
            session()->put('provider_auth', ["provider" => "facebook", "user" => $row]);
            return redirect()->route('user.register');
        }
        fauth()->login($user);
        return redirect()->route('index');
    }

    public function facebookLogin(){
        return Socialite::driver('facebook')->redirect();
    }

    public function logout()
    {
        fauth()->logout();
        return redirect()->route('index');
    }

}