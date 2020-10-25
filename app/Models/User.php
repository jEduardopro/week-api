<?php

namespace App\Models;

use App\Notifications\SendEmailForResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "department_id", "name", "email", "password", "slug", "image"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "password", "remember_token",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SendEmailForResetPassword($token));
    }

    public function proyects()
    {
        return $this->hasMany(Proyect::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasksAssign()
    {
        return $this->hasMany(Task::class, 'responsable_id');
    }

    public function subtasks()
    {
        return $this->hasManyThrough(Subtask::class, Task::class);
    }

    public function subtasksAssign()
    {
        return $this->hasMany(Subtask::class, 'responsable_id');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, "documentable");
    }

    public function allTasks()
    {
        $tasks = $this->tasks()->select("id", "user_id", "proyect_id", "name", "description", "due_date", "responsable_id", "priority", "status")->get();
        $tasksAssign = $this->tasksAssign()->select("id", "user_id", "proyect_id", "name", "description", "due_date", "responsable_id", "priority", "status");
        $subtasksAssign = $this->subtasksAssign()->select("id", "task_id", "name", "description", "due_date", "responsable_id", "priority", "status")->with('task')->get();
        $tasksMerged = $tasks->merge($tasksAssign);
        return $subtasksAssign->merge($tasksMerged);
    }
}
