<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
	public function seller(){
        	return $this->belongsTo(SellerProfile::class, 'seller_id');
    	}
	public function category(){
        	return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    	}
	
}
