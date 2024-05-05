<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $fillable = ['title','section_id','item_url','thumb_url','premium','language'];
    
    protected $table = "greeting_posts";
}
