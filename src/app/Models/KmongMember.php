<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KmongMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected array $fillable = [
        'email',
        'password',
        'display_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $hidden = [
        'password',
    ];
}
