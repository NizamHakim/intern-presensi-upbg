<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    protected $fillable = ['nama'];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles')->withTimestamps();
    }

    public function usersLoggedAs()
    {
        return $this->hasMany(User::class);
    }
}
