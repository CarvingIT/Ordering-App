<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSellerRequest extends Model
{
    use HasFactory;
	protected $table="user_seller_requests";

	 public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }



/// Class ends
}
