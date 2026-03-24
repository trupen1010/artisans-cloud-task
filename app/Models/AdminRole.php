<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['admin_id', 'role_id'])]
class AdminRole extends Model
{
    use HasFactory;

    public $timestamps = false;
}
