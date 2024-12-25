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
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'nama',
        'email',
        'no_hp',
        'password',
        'profile_picture',
        'current_role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['nama'] . ' (' . $attributes['nik'] . ')'
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['id']
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
        return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps();
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
