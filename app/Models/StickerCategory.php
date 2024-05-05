<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StickerCategory extends Model
{
    use HasFactory;
    protected $table = 'stickers_category';
    protected $fillable = ['name'];
    
    public function stickers()
    {
        return $this->hasMany("App\Models\Sticker", "category_id", "id")->where('status','0');
    }
}
