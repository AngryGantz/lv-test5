<?php

Admin::menu()->url('/')->label('Start page')->icon('fa-dashboard');

Admin::menu(Cartalyst\Sentinel\Roles\EloquentRole::class)->label('Roles')->icon('fa-dashboard');
Admin::menu(Cartalyst\Sentinel\Users\EloquentUser::class)->label('Юзеры')->icon('fa-dashboard');

