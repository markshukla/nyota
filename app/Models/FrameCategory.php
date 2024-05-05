<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameCategory extends Model
{
    use HasFactory;
    protected $table = 'frame_category';
    protected $fillable = ['name'];
    
    public function frames()
    {
        return $this->hasMany("App\Models\Frame", "category_id", "id")->where('status','0');
    }
    
}
