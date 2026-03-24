<?php

namespace App\Models;

use App\Traits\AdminActionStamped;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['teacher_id', 'parent_id', 'name', 'email', 'phone', 'status', 'created_by', 'updated_by'])]
#[Hidden(['deleted_at'])]
class Student extends Model
{
    use AdminActionStamped;
    use HasFactory;
    use SoftDeletes;

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
