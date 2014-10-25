<?php 
require_once('transaction.php');
$transaction  = new Transaction();
//create new customer
$create_customer = $transaction->createCustomer(array('card' => 'js return token', 
                                                      'description' => 'This is our new customer'));
//get all customer
$customers = $transaction->getCustomers();
//get one customer with customer id received when create a customer

$cutomer_id = 'cus_4rgO0oJ6bvqW9G';
$customer = $transaction->retrieveCustomer($cutomer_id);
//$customer_id = $customers['data'][0]['id'];
$file = $customer_id.'.txt';
if(!file_exists($file)){
  file_put_contents('customers/'.$file, $transaction->jsonEncodeDecode("encode", $customer));	
}
print '<pre>';
print_r($customers);

?>
