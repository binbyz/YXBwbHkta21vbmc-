<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KmongProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DISPLAY_SHOW = 1;
    const DISPLAY_SHOWOFF = 2;
}
