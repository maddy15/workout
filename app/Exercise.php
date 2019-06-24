<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getRepetitionAttribute($value)
    {
        return (int) $value + ((int) $this->program->getCurrentLevel()['levelId'] * 2);
    }

    public function getSetAttribute($value)
    {
        return (int) $value + (int) $this->program->getCurrentLevel()['levelId'];
    }

    public function level()
    {
        return $this->program->level->id;
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['workout_date']);
    }
}
