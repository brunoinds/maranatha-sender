<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'roles'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];
    public function isAdmin(): bool
    {
        return $this->username === 'admin';
    }

    public function roles(): array{
        if ($this->username === 'admin'){
            return ['admin'];
        }else{
            return [];
        }
    }
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles());
    }
    public function addRole(string $role): void
    {
        
    }
    public function removeRole(string $role): void
    {
        
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function isOfficial(): bool
    {
        return str_contains($this->email, '@maranatha');
    }
}
