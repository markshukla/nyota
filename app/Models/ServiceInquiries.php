<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInquiries extends Model
{
    use HasFactory;
    protected $table = 'service_inquiries';
    
    public function service()
    {
        return $this->hasOne("App\Models\Services", "id", "service_id");
    }
    
    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }
}
