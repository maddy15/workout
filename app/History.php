<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['user_id','program_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function scopeLatestFirst($query,$order = 'asc')
    {
        return $query->orderBy('created_at',$order);
    }

    public function scopeOwnedByUser($query)
    {
        return $query->where('user_id',auth()->user()->id);
    }
}
