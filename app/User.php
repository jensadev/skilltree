<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function skilltrees()
    {
        return $this->hasMany(Skilltree::class, 'owner_id')->latest('updated_at');
    }

    public function accessibleSkilltrees()
    {
        return Skilltree::where('owner_id', $this->id)
            ->latest('updated_at')
            ->get();
    }
}


/*
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            */
