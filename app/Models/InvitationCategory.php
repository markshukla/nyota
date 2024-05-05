<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationCategory extends Model
{
    use HasFactory;
    protected $table = "invitation_category";
    
    function invitationcards(){
        return $this->hasMany("App\Models\InvitationCard", "category_id", "id")->where('status','0')->orderBy('id','DESC');
    }
}
