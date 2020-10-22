<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ["id", "name", "original_name", "documentable_id", "documentable_type"];

    public function documentable()
    {
        return $this->morphTo();
    }
}
