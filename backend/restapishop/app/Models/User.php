<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// ⬇️ Dùng Authenticatable của MongoDB (KHÔNG dùng Illuminate\Foundation\Auth\User)
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPasswordTrait;

    // ===== Mongo settings =====
    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'github_id',
        'google_id',
        'auth_type',
        'is_admin',
        'email_verified_at',
        'fcm_id',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin'          => 'bool',
        'password'          => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            // các giá trị mặc định
            $user->is_admin   = $user->is_admin ?? false;
            $user->avatar     = $user->avatar ?? 'default_avatar.jpg';
            $user->auth_type  = $user->auth_type ?? 'auth';
        });
    }

    // ===== Helpers (giữ nguyên theo file cũ) =====
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function get_fcm()
    {
        return $this->fcm_id;
    }
}
