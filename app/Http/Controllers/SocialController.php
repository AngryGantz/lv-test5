<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Redirect;

class SocialController extends Controller
{
    public function supervisor($provider)
    {
        $socUser = \Socialite::driver($provider)->user();
        dd($socUser);
        $email=$socUser->getEmail();
        if(! $email){
            $errors = "Социальная сеть не дала ваш Email. Скорее всего вы не прошли верификацию в данной сети.";
            return Redirect::to('register')
                ->withErrors($errors);
        }
        if ($user = Sentinel::findByCredentials(array('email' => $email)))
        {
            Sentinel::authenticate($user);
        }
        $name = $socUser->getNickname();
        if (! $name) $name = $socUser->getName();

    }
}
