<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "description", "color"];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($proyect) {
            $proyect->color = $proyect->getRandomColor();
        });
    }

    public function getRandomColor()
    {
        $colors = collect([
            "red",
            "orange",
            "yellow darken-2",
            "light-green",
            "green",
            "green darken-3",
            "blue",
            "indigo",
            "purple",
            "pink",
            "pink darken-3",
            "pink lighten-2",
        ]);
        return $colors->random();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function subtasks()
    {
        return $this->hasManyThrough(Subtask::class, Task::class);
    }
}
