<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicCategory extends Model
{
    use HasFactory;
    
    use HasFactory;
    protected $table = 'music_category';
    protected $fillable = ['name'];
    
    public function musics()
    {
        return $this->hasMany("App\Models\Music", "category_id", "id")->where('status','0');
    }
}
