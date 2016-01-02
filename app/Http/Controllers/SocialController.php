<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;

class SocialController extends Controller
{
    public function supervisor($provider)
    {
        dd($provider->name);
        $user = \Socialite::driver($provider)->user();
        dd($user->name);
    }
}
