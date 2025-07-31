<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email', // Add email to fillable fields
    ];

    /**
     * Get the username for authentication.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Automatically hash the password when setting it
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
