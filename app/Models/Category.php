<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    
    public function premiumposts()
    {
        return $this->hasMany("App\Models\Posts", "category_id", "id")->where('status','0')->where('premium','1')->limit(20);
    }
}
