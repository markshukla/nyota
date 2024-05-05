<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $table = 'section';
    protected $fillable = ['title'];
    
    public function posts()
    {
        return $this->hasMany("App\Models\Posts", "section_id", "id");
    }
     
}
