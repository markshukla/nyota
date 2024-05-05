<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $table = 'posts';
    protected $fillable = ['title','category_id','item_url','thumb_url','language','type'];

    public function section()
    {
        return $this->hasOne("App\Models\Section", "id", "section_id");
    }
}
