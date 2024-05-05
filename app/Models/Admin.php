<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Session;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    
    
    public static function isPermission($for){
        
        $user = Admin::find(Session::get('userid'));
        $permission = json_decode($user->permissions,true);
        
        return $permission[$for];
    }
    
}
