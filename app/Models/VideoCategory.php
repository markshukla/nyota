<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;
    protected $table = 'video_category';
    protected $fillable = ['name','image','type'];
    
    public function premiumposts()
    {
        return $this->hasMany("App\Models\Video", "category_id", "id")->where('status','0')->where('premium','1')->limit(20);
    }
}
