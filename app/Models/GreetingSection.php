<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingSection extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $table = "greeting_section";
    protected $fillable = ['name'];
    
    
    public function posts()
    {
        return $this->hasMany("App\Models\Greeting", "section_id", "id");
    }
}
