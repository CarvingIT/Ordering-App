<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;
	protected $table='seller_profiles';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
	
}
