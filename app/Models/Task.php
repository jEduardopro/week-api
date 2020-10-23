<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ["id", "user_id", "proyect_id", "name", "description", "due_date", "responsable_id", "priority", "status"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proyect()
    {
        return $this->belongsTo(Proyect::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
