<?php 
require_once('Stripe.php');
/**
 * Set your secret key: remember to change this to your live secret key in production
 * See your keys here https://dashboard.stripe.com/account
 */
Stripe::setApiKey("sk_test_IVz2yKMYX8BE2HjvFyXEpbXQ");
// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$dir = "webhook_events/".date('Y-m-d')."/";
$file = $dir.time()."_event.txt";

if(is_dir($dir)){
  file_put_contents($file, $input);
}
else {
   
     if(mkdir($dir, 0755)){
		file_put_contents($file, $input);   
	 }
}

/**
 * When retrieve the created files you need to json decode 
 */
$event_json = json_decode($input);

http_response_code(200); // PHP 5.4 or greater
?>
