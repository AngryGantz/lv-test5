<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Redirect;
use Storage;
use CurlHttp;

class SocialController extends Controller
{
    public function supervisor($provider)
    {
        $socUser = \Socialite::driver($provider)->user();
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
        $name = $socUser->getNickname();
        if (! $name) $name = $socUser->getName();
        $arrUser = [
            'email'    => $email,
            'password' => str_random(16),
            'first_name' => $name,
        ];
        dd('sadsad');
        $user = Sentinel::registerAndActivate($arrUser);
        $socAvatarUrl = $socUser->getAvatar();
        if( $socAvatarUrl ) $response = CurlHttp::get($socAvatarUrl);
        $avatar = $response->content();
        if(isset($avatar)) Storage::put('avatars/'.$user->id.'.jpg', $response->content());
    }
}
