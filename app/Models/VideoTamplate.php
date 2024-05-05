<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTamplate extends Model
{
    use HasFactory;
    protected $table = 'video_tamplate';
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
}
