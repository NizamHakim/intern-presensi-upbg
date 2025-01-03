<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nik',
        'nama',
        'nama_panggilan',
        'email',
        'no_hp',
        'password',
        'profile_picture',
        'current_role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function profilePicture(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $value ? asset('storage/' . $value) : 'https://eu.ui-avatars.com/api/?bold=true&color=0866b7&name=' . urlencode($attributes['nama']);
            },
        );
    }

    public function scopePengajar(Builder $query): void
    {
        $query->whereHas('roles', fn(Builder $query) => $query->where('role_id', 3));
    }

    public function scopePengawas(Builder $query): void
    {
        $query->whereHas('roles', fn(Builder $query) => $query->where('role_id', 5));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps()->orderBy('role_id');
    }

    public function currentRole()
    {
        return $this->belongsTo(Role::class);
    }

    public function mengajarKelas()
    {
        return $this->belongsToMany(Kelas::class, 'pengajar_kelas')->withTimestamps();
    }

    public function mengajarPertemuan()
    {
        return $this->hasMany(PertemuanKelas::class, 'pengajar_id');
    }

    public function mengawasiTes()
    {
        return $this->belongsToMany(Tes::class, 'pengawas_tes')->withTimestamps();
    }
}
