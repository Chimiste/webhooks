<?php
require_once('Stripe.php');

class Transaction{
	
	 private $api_key;
	
   /**
	* @Transaction::Transaction()
	* @return:void
	*/ 
     public function Transaction(){
		  $this->api_key = "sk_test_IVz2yKMYX8BE2HjvFyXEpbXQ"; 
	 }
   /**
	* @Transaction::jsonEncodeDecode()
	* @params:$option
	* @params:$data
	* @return
	*/
	 public  function jsonEncodeDecode($option, $data){
		  
		  switch($option){
			  
			  case "encode":
			    $json =  json_encode($data);
			  break;
			  case "decode":
			    $json =  json_decode($data);
			  break;
		  }
		  
		  return $json;
	   }
   /**
	* @Transaction::createCharge()
	* @params:$card_infos
	* @params:$capture
	* @return
	*/ 
	  public  function createCharge($payment_infos){
		  
		  $data = array();
		  
		  $data['amount'] = $payment_infos['amount'];
		  $data['currency'] = $payment_infos['currency'];
		  $data['card'] = $payment_infos['token'];
		  $data['description'] = $payment_infos['description'];
		  $data['metadata'] = $payment_infos['metadata'];

		  try{

			  Stripe::setApiKey($this->api_key);
			  $charge = Stripe_Charge::create($data); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $charge = $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			 $charge =  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			 $charge =  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $charge = $this->handlingCardError($e);
		  }
		  
		  return $charge;
	   }
   /**
	* @Transaction::getCustomers()
	* @params:$customer_info
	* @return:$customer
	*/ 
	  public  function createCustomer($customer_info){

          $data = array();
		  $data['card'] = $customer_info['card'];
		  $data['description'] = $customer_info['description'];
		  
		  try{

			  Stripe::setApiKey($this->api_key);
			  $customer = Stripe_Customer::create($data); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $customer = $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $customer =  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $customer =  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $customer = $this->handlingCardError($e);
		  }
		  
		  return $customer;
	   }
   /**
	* @Transaction::getCustomers()
	* @params:
	* @return:$customer
	*/ 
	  public  function getCustomers(){

		  try{

			  Stripe::setApiKey($this->api_key);
			  $customers = Stripe_Customer::all(); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $customers = $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $customers =  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $customers =  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $customers = $this->handlingCardError($e);
		  }
		  
		  return $customers;
	   }
   /**
	* @Transaction::retrieveCustomer()
	* @params:$customer_id
	* @return:$customer
	*/ 
	  public  function retrieveCustomer($customer_id){
		  
		  $data = array();

		  try{

			  Stripe::setApiKey($this->api_key);
			  $customer = Stripe_Customer::retrieve($customer_id); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $customer = $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $customer =  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $customer =  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $customer = $this->handlingCardError($e);
		  }
		  
		  return $customer;
	   }
   /**
	* @Transaction::captureCharge()
	* @params:$infos
	* @return
	*/ 
	public function captureCharge($infos){

		  if(!empty($infos['amount'])){
			
			$data = array();
		    $data['id'] = $infos['id'];  
		    $data['amount'] = $infos['amount'];
		  }
		  else $data = $infos['id'];
		  
		  try{

			  Stripe::setApiKey($this->api_key);
			  $ch = Stripe_Charge::retrieve($data); 
		      $ch->capture();
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $this->handlingCardError($e);
		  }
		  
		  return $ch;
	}
  /**
	* @Transaction::getCharges()
	* @params:
	* @return
	*/ 
	public function getCharges(){
		try{

			  Stripe::setApiKey($this->api_key);
			  $ch = Stripe_Charge::all(); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $this->handlingCardError($e);
		  }
		  
		  return $ch;
	}
	/**
	* @Transaction::getTransactionDetails()
	* @params:$txn_id
	* @return
	*/ 
	public function getTransactionDetails($txn_id){
		try{

			  Stripe::setApiKey($this->api_key);
			  $ch = Stripe_Charge::retrieve($txn_id); 
		  
		  } catch (Stripe_ApiConnectionError $e) {
              $this->handlingApiConnectionError($e);
		  } catch (Stripe_InvalidRequestError $e) {
			  $this->handlingInvalidRequestError($e);
		  } catch (Stripe_ApiError $e) {
			  $this->handlingApiError($e);
		  } catch (Stripe_CardError $e) {
			  $this->handlingCardError($e);
		  }
		  
		  return $ch;
	}
	 /**
	  * @Transaction::handlingCardError()
	  * @params:$e
	  * @return
	  */ 
	   private function handlingCardError($e){
		  $e_json = $e->getJsonBody();
          $error = $e_json['error'];
		  
          return  $error['message'];
	   }
	 /**
	  * @Transaction::handlingApiConnectionError()
	  * @params:$e
	  * @return
	  */ 
	   private function handlingApiConnectionError($e){
		  $this->requestStripeTransaction($this->card_infos_second, $this->payment_infos_second, $this->capture_second);
	   }
	 /**
	  * @Transaction::handlingInvalidRequestError()
	  * @params:$e
	  * @return
	  */ 
	   private function handlingInvalidRequestError($e){
		   return $e;//invalid request error(programmer fix)
	   }
	 /**
	  * @Transaction::handlingApiError()
	  * @params:$e
	  * @return
	  */ 
	   private function handlingApiError($e){
		  return "Server maybe down."; //$e
	   }
}
?>
