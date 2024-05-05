<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTamplateCategory extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $table = 'video_tamplate_category';
    
    public function videos()
    {
        return $this->hasMany("App\Models\VideoTamplate", "category_id", "id");
    }
    
}
