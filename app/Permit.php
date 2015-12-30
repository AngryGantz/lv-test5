<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function setRolesAttribute($roles)
    {
        $this->roles()->detach();
        if ( ! $roles) return;
        if ( ! $this->exists) $this->save();
        $this->roles()->attach($roles);
    }

}
