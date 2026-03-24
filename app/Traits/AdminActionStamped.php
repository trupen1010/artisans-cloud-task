<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

trait AdminActionStamped
{
    protected static function bootAdminActionStamped(): void
    {
        // Automatically set `created_by` when a record is created
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->id;
            }
        });

        // Automatically set `updated_by` when a record is updated
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->id;
            }
        });

        // Automatically set `deleted_by` when a record is soft-deleted
        static::deleting(function ($model) {
            if (Auth::check() && $model->isSoftDeleting()) {
                $model->deleted_by = Auth::user()->id;
                $model->saveQuietly();
            }
        });
    }

    public function isSoftDeleting(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive($this));
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updated_by;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deleted_by ?? null;
    }
}
