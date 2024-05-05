<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    
    public static function getValue($field){
        $v = Setting::where('field',$field)->first();
        return $v->value;
    }
    
    public static function setValue($field,$value){
        $v = Setting::where('field',$field)->first();
        $v->value = $value;
        $v->save();
    }
}
