<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoCategory extends Model
{
    use HasFactory;
    protected $table = 'logo_category';
    protected $fillable = ['name'];
    
    public function logos()
    {
        return $this->hasMany("App\Models\Logos", "category_id", "id")->where('status','0');
    }
    
}
