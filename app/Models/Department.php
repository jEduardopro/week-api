<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ["id", "name", "slug", "about"];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function proyects()
    {
        return $this->hasManyThrough(Proyect::class, User::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, User::class);
    }
}
