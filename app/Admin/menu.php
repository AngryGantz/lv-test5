<?php

Admin::menu()->url('/')->label('Dashboard')->icon('fa-dashboard');


Admin::menu()->label('Пользователи')->icon('fa-users')->items(function ()
{
    Admin::menu(Cartalyst\Sentinel\Users\EloquentUser::class)->label('Юзеры')->icon('fa-user');
    Admin::menu(App\Permit::class)->label('Права')->icon('fa-key');
    Admin::menu(App\Role::class)->label('Роли')->icon('fa-graduation-cap');

});