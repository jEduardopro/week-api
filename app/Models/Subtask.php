<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = ["task_id", "name", "description", "due_date", "responsable_id", "priority", "status"];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
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
