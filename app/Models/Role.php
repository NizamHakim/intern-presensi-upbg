<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    protected $fillable = ['nama'];

    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['nama']
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['id']
        );
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles')->withTimestamps();
    }

    public function usersLoggedAs()
    {
        return $this->hasMany(User::class);
    }
}
