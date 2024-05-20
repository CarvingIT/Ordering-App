<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_profile', function (Blueprint $table) {
            	$table->id();
	    	$table->string('business_name')->nullable();
		$table->string('address')->nullable();
		$table->string('description')->nullable();
		$table->string('business_email')->nullable();
		$table->string('business_phone')->nullable();
		$table->unsignedBigInteger('user_id')->nullable();
		$table->foreign('user_id')->references('id')->on('users');
            	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_profile');
    }
}
