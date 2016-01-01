<?php

use Illuminate\Database\Seeder;
use Sentinel;
use Activation;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=Sentinel::register(array(
            'email'    => 'admin@admin.com',
            'password' => 'adminadmin',
        ));
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Администратор',
            'slug' => 'admin',
        ]);
        $role->users()->attach($user);
    }
}
