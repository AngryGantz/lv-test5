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
        $user = \Socialite::driver($provider)->user();
        $email=$user->getEmail();
        if(! $email){
            $errors = "Социальная сеть не дала ваш Email. Скорее всего вы не прошли верификацию в данной сети.";
            return Redirect::back()
                ->withInput()
                ->withErrors($errors);
        }
    }
}
