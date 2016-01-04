<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Redirect;
use Storage;
use CurlHttp;
use Socialite;

class SocialController extends Controller
{
    public function supervisor($provider)
    {
        $socUser = Socialite::driver($provider)->user();
        $email=$socUser->getEmail();
        if(! $email){
            $errors = "Социальная сеть не дала ваш Email. Скорее всего вы не прошли верификацию в данной сети.";
            return Redirect::to('register')
                ->withErrors($errors);
        }
        if ($user = Sentinel::findByCredentials(array('email' => $email)))
        {
            Sentinel::authenticate($user);
            return Redirect::intended('/');
        }
        $name = $socUser->getName();
        if (! $name) $name = $socUser->getNickname();
        $arrUser = [
            'email'    => $email,
            'password' => str_random(16),
            'first_name' => $name,
        ];
        $user = Sentinel::registerAndActivate($arrUser);
        Sentinel::authenticate($user);
        $socAvatarUrl = $socUser->getAvatar();
        if( $socAvatarUrl ) $response = CurlHttp::get($socAvatarUrl);
        $avatar = $response->content();
        if(isset($avatar)) Storage::put('avatars/'.$user->id.'.jpg', $response->content());
        return Redirect::intended('/');
    }
}
