<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{
    use HasFactory;
    protected $table = "user_bussiness";
    
    public function category()
    {
        return $this->hasOne("App\Models\Category", "id", "category_id");
    }
}
