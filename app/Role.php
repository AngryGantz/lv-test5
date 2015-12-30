<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    public function permits()
    {
        return $this->belongsToMany('App\Permit');
    }

    public function setPermitsAttribute($permits)
    {
        $this->permits()->detach();
        if ( ! $permits) return;
        if ( ! $this->exists) $this->save();
        $this->permits()->attach($permits);
    }

}
