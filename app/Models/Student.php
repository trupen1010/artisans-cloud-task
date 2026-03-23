<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['teacher_id', 'parent_id', 'name', 'email', 'phone', 'status'])]
#[Hidden(['created_at', 'updated_at', 'deleted_at'])]
class Student extends Model
{
    use SoftDeletes;

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }
}
