<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use App\Mail\sendGrid;
use App\Models\Taxonomy;
use App\Models\Product;
use App\Models\User;
use App\Models\SellerProfile;


class MailController extends Controller
{
	public function sendMail(Request $request)
        {
        	//echo env('APP_ENV'); exit;
        	$app_env = config('app.env');
	        $cc = 'ketan404@gmail.com,shraddha404@gmail.com';
	        $cc = explode(",",$cc);
	        $input = ['subject'=>'We are testing', 'message' => 'This is a test!'];
	        try{
       		         Mail::to('shraddha404@gmail.com')->cc($cc)->bcc('shraddha@carvingit.com')->send(new sendGrid($input));
       		         Session::flash('alert-success', 'Email sent successfully!');
       		  }
         	catch(\Exception $e){
               		 echo $e->getMessage();
                	Session::flash('alert-danger', $e->getMessage());
         	}
        	return redirect('/dashboard');
        } #functions ends.

	public function notifyAdmin(Request $request){
	$product_id = '';
	$product_name = 'General Query';
	if(!empty($request->prod_id)){
	$product_id = $request->prod_id;
	$product_details = Product::find($product_id);
	$product_name = $product_details->product_name;
	}
	else{
	$product_name = "General Query";
	}
	
	$product_contact_person = [
			"Farming"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Utpad-production"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Terrace Garden"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Urja-power"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Sant sampark"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Marketing"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Goshala"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Go chikitsa"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Panchgvya chikitsa"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Go pariksha"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Nidhi-donation"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Go katha"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Woman interest"=>"kolhapurjilhagausevaofficial@gmail.com",
                        "Other"=>"kolhapurjilhagausevaofficial@gmail.com"
		];

	// Notify Admin about the new Contact Us form message

        $app_env = config('app.env');
        $cc = 'shraddha404@gmail.com';
        $cc = explode(",",$cc);
	$product_contact_email = $product_contact_person[$request->topic];
	//echo $product_name;
	//echo $product_contact_email; exit;

        $message_body = "There is a new message from the contact us form.
        \r\nHere is the message -
	\r\nQuery for the Topic - ".$request->topic."
	\r\nProduct Name - ".$product_name."
        \r\nPerson Name - ".$request->name."
        \r\nEmail Address - ".$request->email."
        \r\nVillege/City - ".$request->city."
        \r\nDistrict - ".$request->district."
        \r\nMessage - ".$request->message;

        $input = ['subject'=>'New Message to GoSeva Team from Contact Us form!', 'message' => $message_body];
        try{
                if($app_env == 'production'){
                        Mail::to('info@carvingit.com')->send(new sendGrid($input));
                }
                if($app_env == 'dev'){
                        Mail::to('info@carvingit.com')->send(new sendGrid($input));
                }
                else if($app_env == 'local'){
                        //Mail::to('shraddha404@gmail.com')->send(new sendGrid($input));
                        Mail::to($product_contact_email)->send(new sendGrid($input));
                }
                Session::flash('alert-success', 'Message has been sent to the GoSeva Team successfully!');
         }
         catch(\Exception $e){
                echo $e->getMessage();
                Session::flash('alert-danger', $e->getMessage());
         }
	return redirect('/product-query?prod_id='.$product_id);
	}

//End of the class
}// End of the class
