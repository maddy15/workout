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
        'name', 'email', 'password','level_id'
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

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class)->withPivot(['progress']);
    }

    public function programProgress($name)
    {
        return $this->programs->where('name',$name)->first();
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class)->withPivot(['workout_date']);
    }
}
