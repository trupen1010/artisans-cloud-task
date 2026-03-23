<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['teacher_id', 'name', 'email', 'phone', 'status'])]
#[Hidden(['created_at', 'updated_at', 'deleted_at'])]
class ParentModel extends Model
{
    use SoftDeletes;

    protected $table = 'parents';

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
