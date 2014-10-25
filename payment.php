<?php
 if($_POST){
       require_once('transaction.php');
	   $transaction  = new Transaction();
	   $data = array(
	           'token' => $_POST['stripeToken'],
			   'currency' => 'USD',
			   'amount' => 1.5*100,
			   'description' => "This is our stripe webhooks testing",
			   'metadata' => array("email"=> "chamssoudinebacar@yahoo.fr","custom1" => "custom 1", "custom2" => "custom 2")
			   
	   );
	   
	   $charge = $transaction->createCharge($data);
	   
	   print '<pre>';
	   print_r($charge);
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WebHooks</title>
 <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
 
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('pk_test_dEvIkxtTcWpDcdV985iDRIV7');
 
var stripeResponseHandler = function(status, response) {
var $form = $('#payment-form');
 
if (response.error) {
// Show the errors on the form
$form.find('.payment-errors').text(response.error.message);
$form.find('button').prop('disabled', false);
} else {
// token contains id, last4, and card type
var token = response.id;
// Insert the token into the form so it gets submitted to the server
$form.append($('<input type="hidden" name="stripeToken" />').val(token));
// and re-submit
$form.get(0).submit();
}
};
 
jQuery(function($) {
$('#payment-form').submit(function(e) {
var $form = $(this);
 
// Disable the submit button to prevent repeated clicks
$form.find('button').prop('disabled', true);
 
Stripe.card.createToken($form, stripeResponseHandler);
 
// Prevent the form from submitting with the default action
return false;
});
});
</script>
</head>

<body>
 <form action="" method="POST" id="payment-form">
<span class="payment-errors"></span>
 
<div class="form-row">
<label>
<span>Card Number</span>
<input type="text" size="20" data-stripe="number"/>
</label>
</div>
 
<div class="form-row">
<label>
<span>CVC</span>
<input type="text" size="4" data-stripe="cvc"/>
</label>
</div>
 
<div class="form-row">
<label>
<span>Expiration (MM/YYYY)</span>
<input type="text" size="2" data-stripe="exp-month"/>
</label>
<span> / </span>
<input type="text" size="4" data-stripe="exp-year"/>
</div>
 
<button type="submit">Submit Payment</button>
</form>
</body>
</html>



