<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['level_id','name'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('progress')
            ->withTimestamps();
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function scopeGetProgress($builder,$name)
    {
        return $builder->where('name',$name)->first();
    }

    public function userProgressLevel()
    {
        $program = $this->users->filter(function($value){
            return $value->pivot->user_id === auth()->user()->id;  
        });

        if($program->isEmpty()) 
        {
            return 0;
        }
        
        return $this->users->firstWhere('id',auth()->user()->id)->pivot->progress;
    }

    public function countExercise()
    {
        return $this->exercises->count();
    }

    public function getCurrentLevel()
    {
        return $this->identifyLevel($this->userProgressLevel());
    }

    public function getPercentageToNextLevel()
    {
        
        $currentLevel = $this->identifyLevel($this->userProgressLevel());

        if($currentLevel['levelId'] == 0)
        {
            return ($this->userProgressLevel() / $currentLevel['nextExperience']) * 100;
        }
        else if($currentLevel['levelId'] == 3)
        {
            return 100;
        }
        else
        {
            return (($this->userProgressLevel() - (1000 * $currentLevel['levelId'])) / ($currentLevel['nextExperience'] - (1000 * $currentLevel['levelId'])) ) * 100;
        }
        
    }

    protected function identifyLevel($progress)
    {
        switch(1)
        {
            case  $progress == 0 || $progress <= 1000:
                    return ['levelId' => 0,'levelName' => 'Beginner','nextLevelName' => 'Intermediate','nextExperience' => 1000];
                    break;
            case $progress <= 2000:
                    return ['levelId' => 1,'levelName' => 'Intermediate','nextLevelName' => 'Advance','nextExperience' => 2000];
                    break;

            case $progress <= 3000:
                    return ['levelId' => 2,'levelName' => 'Advance','nextLevelName' => 'Monster','nextExperience' => 3000];
                    break;
            default:
                    return ['levelId' => 3,'levelName' => 'Monster','nextLevelName' => 'You Reached the limit','nextExperience' => null];
                    break;
        }
    }
}
