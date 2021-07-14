<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class OrderController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}



			//checkout

			public function checkout(){


			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
			// $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');
			$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
			$this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean');
			$this->form_validation->set_rules('qty', 'quantity', 'required|xss_clean');
			$this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean');

			// $this->form_validation->set_rules('payment_type', 'address_id', 'required|xss_clean');


			if($this->form_validation->run()== TRUE)
			{
			//$app_authentication_code=$this->input->post('app_authentication_code');
			$user_id=$this->input->post('user_id');
			// $category_id=$this->input->post('category_id');
			$product_id[]=$this->input->post('product_id');
			$type_id[]=$this->input->post('type_id');
			$qty[]=$this->input->post('qty');
			$address_id=$this->input->post('address_id');
			// $seller_id[]=$this->input->post('seller_id');

			// $pass=md5($passw);

			// if($this->form_validation->run()== TRUE)
			// {

			$ip = $this->input->ip_address();
		date_default_timezone_set("Asia/Calcutta");
			$cur_date=date("Y-m-d H:i:s");


			// product_id array
			$s1=str_replace("[", "",$product_id);
			$s2=str_replace("]", "",$s1);
			$myArrayProductId = explode(',', $s2[0]);
			//print_r($myArrayProductId);

			// type_id array
			$s3=str_replace("[", "",$type_id);
			$s4=str_replace("]", "",$s3);
			$myArrayTypeId = explode(',', $s4[0]);
			//print_r($myArrayTypeId);

			// qty array
			$s5=str_replace("[", "",$qty);
			$s6=str_replace("]", "",$s5);
			$myArrayQty = explode(',', $s6[0]);
			//print_r($myArrayQty);

			// seller_id array
			// $s7=str_replace("[", "",$seller_id);
			// $s8=str_replace("]", "",$s7);
			// $myArraySellerId = explode(',', $s8[0]);
			//print_r($myArraySellerId);






							  $cc1= count($myArrayProductId);

			// $usr_id = $user_data->id;

			// $type_weight=0;
			// $final_amount=[];
			// $total_type_wght=0;
			// $total_type_mrp=0;

			for ($i=0; $i < $cc1; $i++) {

			$p1= $myArrayProductId[$i];
			$p2= $myArrayQty[$i];
			$p3= $myArrayTypeId[$i];
			// $p4= $myArraySellerId[$i];





			// foreach ($product_inventory_data->result() as $inventory) {
			//
			// }


			if($i == 0){
			$ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			$cur_date=date("Y-m-d H:i:s");

			$data_insert1 = array(
				// 'total_products'=>$cc1,
							'total_amount'=>0,
							// 'sub_total'=>0,
							'address_id'=>0,
							'payment_type'=>0,
							'user_id'=>$user_id,
							// 'seller_id'=>$p4,
							'payment_status'=>0,
							'order_status'=>0,
							'delivery_slot_id'=>0,
							'delivery_date'=>0,
							'delivery_status'=>0,
							'delivery_charge'=>0,

						'last_update_date'=>$cur_date,
							'ip' =>$ip,
							'date'=>$cur_date

							);




			$last_id=$this->base_model->insert_table("tbl_order1",$data_insert1,1) ;

			}











			}




			// INSERT INTO DATABASE
			for ($i=0; $i < $cc1; $i++) {

			$p1=$myArrayProductId[$i];
			$p2=$myArrayQty[$i];
			$p3=$myArrayTypeId[$i];
			// $p1=$product_id[$i];
			//



			$selling_price = 0;
			$loop_item_product_id = $p1;
			$loop_item_unit_id = $p3;
			$stock = $p2;
				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$loop_item_product_id);
				$product_data_dsa = $this->db->get()->row();
				if(!empty($product_data_dsa)){
				$product_unit_type = $product_data_dsa->product_unit_type;

				$product_name= $product_data_dsa->name;

				if($product_unit_type == 1){
					$loop_item_unit_id = 0;

					$this->db->select('*');
					$this->db->from('tbl_product_units');
					$this->db->where('product_id',$loop_item_product_id);
					$this->db->where('id',$p3);
					$product_unit_dsa = $this->db->get()->row();

						if(!empty($product_unit_dsa)){
						$db_ratio = $product_unit_dsa->ratio;
							$stock = $db_ratio * $p2;
						}

				}
			}

				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('unit_id',$loop_item_unit_id);
				$this->db->where('product_id',$loop_item_product_id);
				$dsa= $this->db->get()->row();

				// echo $loop_item_unit_id;
				// echo $loop_item_product_id;
				// print_r($dsa); die();
				if(!empty($dsa)){





				$db_pro_stock = $dsa->stock;
				if($db_pro_stock >= $stock){

				$total_pro_stock = $db_pro_stock - $stock;

				$data_update = array(
				'stock'=>$total_pro_stock
				);
				$this->db->where('id', $dsa->id);
				$this->db->update('tbl_inventory', $data_update);

				$data_transaction_insert2 = array(
				'product_id'=>$p1,
				'unit_id'=>$p3,
				'stock'=>$stock,
				'type'=>3,
				'ip' =>$ip,
				'added_by' =>$user_id,
				'is_active' =>1,
				'date'=>$cur_date
				);


				$this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);





			//insert into order2 tabel

			$this->db->select('*');
						$this->db->from('tbl_product_units');
						$this->db->where('id',$p3);
						$this->db->where('product_id',$p1);
						$pu_data= $this->db->get()->row();
						if(!empty($pu_data)){

							 $selling_price = $pu_data->selling_price * $p2 ;
						}





			$data_insert2 = array('main_id'=>$last_id,
			'product_id'=>$p1,
			'unit_id'=>$p3,
			'quantity'=>$p2,
			'amount'=>$selling_price,
			'ip'=>$ip,
			'date'=>$cur_date

			);




			$last_id2=$this->base_model->insert_table("tbl_order2",$data_insert2,1) ;


		}
		else{
			// $data['data']=false;
			// $data['data_message']="Sorry! This product is out of stock";

$msg="Sorry! This product ".$product_name." is out of stock. Please remove this product from your cart.";
			$res = array('message'=>$msg,
							'status'=>201,


							);

			echo json_encode($res); exit;

		}
		}
		else{

			// $data['data']=false;
			// $data['data_message']="Sorry! This product's inventory is not exist";

$mssg="Sorry! This product ".$product_name." inventory is not exist. Please remove this product from your cart.";

			$res = array('message'=>$mssg,
							'status'=>201,


							);

			echo json_encode($res); exit;

		}





			}
			if(!empty($last_id)){







			$res = array('message'=>"success",
			'order_id'=>$last_id,
			'status'=>200
			);

			echo json_encode($res);
			exit;
			}
			else{
			$res = array('message'=>"Error Occured",
			'status'=>201
			);

			echo json_encode($res); exit;

			}



			}
			else{
			$res = array('message'=>validation_errors(),
								'status'=>201
								);

			echo json_encode($res);
			}
			}
			else{
			$res = array('message'=>'Please insert some data, No data available',
							'status'=>201
							);

			echo json_encode($res);
			}

			}


// End Checkout



// order checkout api for cod and payment method

public function order_checkout(){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

// $this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
// // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');
// $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
// $this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean');
// $this->form_validation->set_rules('qty', 'quantity', 'required|xss_clean');
// $this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean');
//
// $this->form_validation->set_rules('payment_type', 'address_id', 'required|xss_clean');


$this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('payment_type', 'payment_type', 'required|xss_clean|trim');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
$this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
$this->form_validation->set_rules('slot_id', 'slot_id', 'xss_clean|trim');
$this->form_validation->set_rules('datepickerValue', 'datepickerValue', 'xss_clean|trim');
$this->form_validation->set_rules('wallet_check_status', 'wallet_check_status', 'xss_clean|trim');




if($this->form_validation->run()== TRUE)
{
//$app_authentication_code=$this->input->post('app_authentication_code');
$address_id=$this->input->post('address_id');
$payment_type=$this->input->post('payment_type');
$user_id=$this->input->post('user_id');
$email=$this->input->post('email');
$password=$this->input->post('password');
$pass= $password;

$slot_id=$this->input->post('slot_id');
$datepickerValue=$this->input->post('datepickerValue');
$applied_promocode=$this->input->post('applied_promocode');
$wallet_check_status=$this->input->post('wallet_check_status');



$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");


//user check for security
$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$usrr_dat= $this->db->get()->row();

if(!empty($usrr_dat)){

if($usrr_dat->email == $email){

if($usrr_dat->password == $pass){


//paymemt type - Cash On delivery

if($payment_type==1)
{

										// $slot_order_limit = 0;
										// $this->db->select('*');
										// 			$this->db->from('tbl_delivery_slots');
										// 			$this->db->where('id',$slot_id);
										// 			$slot_data= $this->db->get()->row();
										// 			if(!empty($slot_data)){
										// 				$slot_order_limit = $slot_data->orders_limit;
										// 			}

										// $this->db->select('*');
										// $this->db->from('tbl_order1');
										// $this->db->where('order_status',1);
										// $this->db->where('delivery_slot_id',$slot_id);
										// $this->db->where('delivery_date',$datepickerValue);
										//
										// $ordered_slots = $this->db->get()->num_rows();

									//slot-check
										// if($slot_order_limit > $ordered_slots){

											$ip = $this->input->ip_address();
											date_default_timezone_set("Asia/Calcutta");
											$cur_date = date("Y-m-d H:i:s");

											//insert into order1 tabel



												$data_insert = array(
												'user_id'=>$user_id,
												'address_id'=>$address_id,
												'payment_type'=>$payment_type,
												'payment_status'=>0,
												'order_status'=>1,
												'date'=>$cur_date,
												'last_update_date'=>$cur_date,
												'ip'=>$ip,
												'total_amount' =>0,
													'delivery_slot_id' =>$slot_id,
													'delivery_date' => $datepickerValue
													 );


										$order1_last_id=$this->base_model->insert_table("tbl_order1",$data_insert,1);


									//inventory-checked with cart tabel Products

									$this->db->select('*');
									$this->db->from('tbl_cart');
									$this->db->where('user_id',$user_id);
									$user_cart= $this->db->get();

									// print_r($user_cart->result()); die();
									$total_amount = 0;
									foreach($user_cart->result() as $item) {
									$selling_price = 0;
									$loop_item_product_id = $item->product_id;
									$loop_item_unit_id = $item->unit_id;
									$stock = $item->quantity;
										$this->db->select('*');
										$this->db->from('tbl_product');
										$this->db->where('id',$loop_item_product_id);
										$product_data_dsa = $this->db->get()->row();
										if(!empty($product_data_dsa)){
										$product_unit_type = $product_data_dsa->product_unit_type;

										$product_names = $product_data_dsa->name;

										if($product_unit_type == 1){
											$loop_item_unit_id = 0;

											$this->db->select('*');
											$this->db->from('tbl_product_units');
											$this->db->where('product_id',$loop_item_product_id);
											$this->db->where('id',$item->unit_id);
											$product_unit_dsa = $this->db->get()->row();

												if(!empty($product_unit_dsa)){
												$db_ratio = $product_unit_dsa->ratio;
													$stock = $db_ratio * $item->quantity;
												}

										}
									}

										$this->db->select('*');
										$this->db->from('tbl_inventory');
										$this->db->where('unit_id',$loop_item_unit_id);
										$this->db->where('product_id',$loop_item_product_id);
										$dsa= $this->db->get()->row();
										if(!empty($dsa)){





										$db_pro_stock = $dsa->stock;
										if($db_pro_stock >= $stock){

										$total_pro_stock = $db_pro_stock - $stock;

										$data_update = array(
										'stock'=>$total_pro_stock
										);
										$this->db->where('id', $dsa->id);
										$this->db->update('tbl_inventory', $data_update);

										$data_transaction_insert2 = array(
										'product_id'=>$item->product_id,
										'unit_id'=>$item->unit_id,
										'stock'=>$stock,
										'type'=>3,
										'ip' =>$ip,
										'added_by' =>$user_id,
										'is_active' =>1,
										'date'=>$cur_date
										);


										$this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);





									//insert into order2 tabel

									$this->db->select('*');
												$this->db->from('tbl_product_units');
												$this->db->where('id',$item->unit_id);
												$this->db->where('product_id',$item->product_id);
												$pu_data= $this->db->get()->row();
												if(!empty($pu_data)){

													 $selling_price = $pu_data->selling_price * $item->quantity ;
												}

									$order2_insert = array(
									'main_id'=>$order1_last_id,
									'product_id'=>$item->product_id,
									'unit_id'=>$item->unit_id,
									'quantity'=>$item->quantity,
									'date'=>$cur_date,
									'amount' =>$selling_price,
									'ip'=> $this->input->ip_address()
										 );
											$this->base_model->insert_table("tbl_order2",$order2_insert,1) ;

										 	$total_amount  = $total_amount + $selling_price;



										}
										else{
											// $data['data']=false;
											// $data['data_message']="Sorry! This product is out of stock";

$msg="Sorry! This product ".$product_names." is out of stock. Please remove this product from your cart.";

											$res = array('message'=> $msg,
															'status'=>201,


															);

											echo json_encode($res); exit;

										}
										}
										else{

											// $data['data']=false;
											// $data['data_message']="Sorry! This product's inventory is not exist";

$mssg="Sorry! This product ".$product_names." inventory is not exist. Please remove this product from your cart.";

											$res = array('message'=> $mssg,
															'status'=>201,


															);

											echo json_encode($res); exit;

										}


									}
// $total_amount;
// $order1_last_id;
 $user_id;

 $total_amount;
									//promocode
									if(!empty($applied_promocode)){


										  $total_amount = $this->isValidPromocode($order1_last_id,$total_amount,$applied_promocode,$user_id);
									}
// echo "hsy";
// echo $total_amount; die();


//Start user wallet check and deduct wallete amount

// if($wallet_check_status == 1 ){
//
//       			$this->db->select('*');
// $this->db->from('tbl_users');
// $this->db->where('id',$user_id);
// $user_wallet_data= $this->db->get()->row();
//
// if(!empty($user_wallet_data)){
//
// 	$main_wallet_blnce= $user_wallet_data->wallet;
//
// 	if($main_wallet_blnce > $total_amount){
// 		$wallet_balance= $total_amount;
// 	}else{
// 		$wallet_balance= $main_wallet_blnce;
// 	}
//
// }else{
// 	$wallet_balance= 0;
// }
//
// $total_amount= $total_amount - $wallet_balance;
//
// }

//End user wallet check and deduct wallete amount




								if($total_amount <= 100 ){
									$deliveryCharge= 30;
										$amount_subtotal= $total_amount + $deliveryCharge;

										$data_update = array(
											 'payment_status'=> 1,
											 'total_amount'=>$amount_subtotal,
											 'delivery_charge'=>$deliveryCharge
											);

								}else{
									$deliveryCharge= 0;
										$amount_subtotal= $total_amount;
									$data_update = array(
										'payment_status'=> 1,
										 'total_amount'=>$amount_subtotal,
										 'delivery_charge'=>$deliveryCharge
										);
								}



										$this->db->where('id', $order1_last_id);
										$this->db->update('tbl_order1', $data_update);

									$check= 	$this->db->delete('tbl_cart', array('user_id' => $user_id));


//update rest wallet amount in user wallet after deduction from user's wallet

// if($wallet_check_status == 1 ){
//
// 	$this->db->select('*');
// 	$this->db->from('tbl_users');
// 	$this->db->where('id',$user_id);
// 	$wallet_user_datas= $this->db->get()->row();
//
// 	if(!empty($wallet_user_datas)){
// 		$user_wallet_amu= $wallet_user_datas->wallet;
// 		$rest_wallet_am= $user_wallet_amu - $wallet_balance;
//
//
// 		$data_user_wlt_update = array(
// 			'wallet'=> $rest_wallet_am
//
// 			);
//
// 			$this->db->where('id', $user_id);
// 			$this->db->update('tbl_users', $data_user_wlt_update);
// 	}
//
// }


								// 	$this->db->select('*');
								// 	$this->db->from('tbl_cart');
								// 	$this->db->where("user_id",$user_id);
								// 	//$this->db->where("is_cat_delete", 0);
								// 	$cart_products_data= $this->db->get();
							 //
							 // if(!empty($cart_products_data)){
								// // echo "wes"; die();
								// 	 foreach ($cart_products_data->result()  as $cart_product) {
							 //
							 //
							 // $data['cart_deleted']= $this->db->delete('tbl_cart', array('id' => $cart_product->id));
								// 		 // $this->db->where('id', $cat_product->id);
								// 		 // $this->db->where("is_cat_delete", 0);
								// 		 // $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
								// 	 }
							 // }


//Send email code start

									// 		$config = Array(
									// 		'protocol' => 'smtp',
									// 		'smtp_host' => 'mail.fineoutput.website',
									// 		'smtp_port' => 26,
									// 		'smtp_user' => 'info@fineoutput.website', // change it to yours
									// 		'smtp_pass' => 'info@fineoutput2019', // change it to yours
									// 		'mailtype' => 'html',
									// 		'charset' => 'iso-8859-1',
									// 		'wordwrap' => TRUE
									// 		);
									//
									// 		$this->db->select('*');
									// 					$this->db->from('tbl_users');
									// 					$this->db->where('id',$user_id);
									// 					$user_data= $this->db->get()->row();
									// $email = '';
									// 					if(!empty($user_data)){
									// 						$email =  $user_data->email;
									// 					}
									//
									// 		$to=$email;
									//
									// 		$email_data = array("order1_id"=>$order1_last_id
									// 		);
									//
									// 		$message = 	$this->load->view('frontend/emails/order-success',$email_data,TRUE);
									// 		// $message = 	"HELLO";
									// 		$this->load->library('email', $config);
									// 		$this->email->set_newline("");
									// 		$this->email->from('info@fineoutput.website'); // change it to yours
									// 		$this->email->to($to);// change it to yours
									// 		$this->email->subject('Order Placed Successfully');
									// 		$this->email->message($message);
									// 		if($this->email->send()){
									// 		//  echo 'Email sent.';
									// 		}else{
									// 		// show_error($this->email->print_debugger());
									// 		}


										// 	$enc_order_idd= base64_encode($order1_last_id);
										// 	 $enc_user_idd= base64_encode($user_id);
									 //
										// 	$data['orderr_idd']=$enc_order_idd;
										// 	$data['userr_idd']=$enc_user_idd;
									 //
										// 	$data['order_placed']=true;
									 //
									 // $data['data']=true;

									 $res = array('message'=>"success",
									 				'status'=>200,
									 				'order_id'=>$order1_last_id,
									 				'user_id'=>$user_id,




									 				);

									 echo json_encode($res); exit;



										// }
										// else{
										//
										// 	// $data['data']=false;
										// 	// $data['data_message']="Sorry! This slot is not available for Delivery.Please select another date and try again";
										//
										// 	$res = array('message'=>"Sorry! This slot is not available for Delivery.Please select another date and try again",
										// 					'status'=>201,
										//
										//
										// 					);
										//
										// 	echo json_encode($res); exit;
										//
										// }

}




}else{
	$res = array('message'=>"Wrong Password!",
					'status'=>201
					);

	echo json_encode($res); exit;
}

}else{
	$res = array('message'=>"Wrong Email!",
					'status'=>201
					);

	echo json_encode($res); exit;
}

}else{
	$res = array('message'=>"Wrong User!",
					'status'=>201
					);

	echo json_encode($res); exit;
}




}
else{
$res = array('message'=>validation_errors(),
					'status'=>201
					);

echo json_encode($res);
}
}
else{
$res = array('message'=>'Please insert some data, No data available',
				'status'=>201
				);

echo json_encode($res);
}

}





//online payment  hash code api
			public function online_payment_hash(){

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{


			$this->form_validation->set_rules('merchant_key', 'merchant_key', 'required|xss_clean');
		  $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean');
			$this->form_validation->set_rules('total_amount', 'total_amount', 'required|xss_clean');
			$this->form_validation->set_rules('product_info', 'product_info', 'required|xss_clean');
			$this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'required|xss_clean');




			if($this->form_validation->run()== TRUE)
			{
			//$app_authentication_code=$this->input->post('app_authentication_code');
			// echo $merchant_key=$this->input->post('merchant_key');
			// echo $txn_id= $this->input->post('txn_id');
			// echo $total_amount=$this->input->post('total_amount');
			// echo $product_info=$this->input->post('product_info');
			// echo $first_name=$this->input->post('first_name');
			// echo $email=$this->input->post('email');
			// echo $SALT= 'dxmk9SZZ9y';

			$merchant_key= MERVHANT_KEY;
			$txn_id= $this->input->post('txn_id');
			$total_amount=$this->input->post('total_amount');
			$product_info=$this->input->post('product_info');
			$first_name=$this->input->post('first_name');
			$email=$this->input->post('email');
			// $SALT= 'wk8s6dki8';
			$SALT= SALT_KEY;
			$udf1= '';
			$udf2= '';
			$udf3= '';
			$udf4= '';
			$udf5= '';
			$furl= "https://www.payumoney.com/mobileapp/payumoney/failure.php";
			$surl= "https://www.payumoney.com/mobileapp/payumoney/success.php";



// ------make hash string code start------ //


$hashstring = $merchant_key . '|' . $txn_id . '|' . $total_amount . '|' . $product_info . '|' . $first_name . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;
		 // print_r($hashstring); die();
					$hash = strtolower(hash('sha512', $hashstring));

// ------make hash string code end------ //


			$res = array('message'=>"success",
			'hash_key'=>$hash,
			'status'=>200
			);

			echo json_encode($res);
			exit;





			}
			else{
			$res = array('message'=>validation_errors(),
								'status'=>201
								);

			echo json_encode($res);
			}
			}
			else{
			$res = array('message'=>'Please insert some data, No data available',
							'status'=>201
							);

			echo json_encode($res);
			}


			}




// Order checkout api for Online Payment method

public function online_payment(){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

// $this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
// // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');
// $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
// $this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean');
// $this->form_validation->set_rules('qty', 'quantity', 'required|xss_clean');
// $this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean');
//
// $this->form_validation->set_rules('payment_type', 'address_id', 'required|xss_clean');


$this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('payment_type', 'payment_type', 'required|xss_clean|trim');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('user_email', 'user_email', 'xss_clean|trim');
$this->form_validation->set_rules('user_password', 'user_password', 'xss_clean|trim');
$this->form_validation->set_rules('slot_id', 'slot_id', 'xss_clean|trim');
$this->form_validation->set_rules('datepickerValue', 'datepickerValue', 'xss_clean|trim');
$this->form_validation->set_rules('wallet_check_status', 'wallet_check_status', 'xss_clean|trim');


//online_payment perameters validations
 $this->form_validation->set_rules('postback_param_id', 'postback_param_id', 'xss_clean|trim');
 $this->form_validation->set_rules('mihpay_id', 'mihpay_id', 'xss_clean|trim');
 $this->form_validation->set_rules('payment_id', 'payment_id', 'xss_clean|trim');
 $this->form_validation->set_rules('mode', 'mode', 'xss_clean|trim');
 $this->form_validation->set_rules('online_payment_status', 'online_payment_status', 'xss_clean|trim');
 $this->form_validation->set_rules('unmapped_status', 'unmapped_status', 'xss_clean|trim');
 $this->form_validation->set_rules('txn_id', 'txn_id', 'xss_clean|trim');
 $this->form_validation->set_rules('payment_gateway_amount', 'payment_gateway_amount', 'xss_clean|trim');
 $this->form_validation->set_rules('additional_charges', 'additional_charges', 'xss_clean|trim');
 $this->form_validation->set_rules('added_on', 'added_on', 'xss_clean|trim');
 $this->form_validation->set_rules('created_on', 'created_on', 'xss_clean|trim');
 $this->form_validation->set_rules('first_name', 'first_name', 'xss_clean|trim');
 $this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
 $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
 $this->form_validation->set_rules('bank_ref_number', 'bank_ref_number', 'xss_clean|trim');
 $this->form_validation->set_rules('bank_code', 'bank_code', 'xss_clean|trim');
 $this->form_validation->set_rules('err_message', 'err_message', 'xss_clean|trim');
 $this->form_validation->set_rules('name_on_card', 'name_on_card', 'xss_clean|trim');
 $this->form_validation->set_rules('card_num', 'card_num', 'xss_clean|trim');
 $this->form_validation->set_rules('card_type', 'card_type', 'xss_clean|trim');
 $this->form_validation->set_rules('online_payment_discount', 'online_payment_discount', 'xss_clean|trim');
 $this->form_validation->set_rules('net_amount_debit', 'net_amount_debit', 'xss_clean|trim');




if($this->form_validation->run()== TRUE)
{
//$app_authentication_code=$this->input->post('app_authentication_code');
$address_id=$this->input->post('address_id');
$payment_type=$this->input->post('payment_type');
$user_id=$this->input->post('user_id');
$user_email=$this->input->post('user_email');
$user_password=$this->input->post('user_password');
$pass= $user_password;

$slot_id=$this->input->post('slot_id');
$datepickerValue=$this->input->post('datepickerValue');
$applied_promocode=$this->input->post('applied_promocode');
$wallet_check_status=$this->input->post('wallet_check_status');


//online_payment perameters
$postback_param_id=$this->input->post('postback_param_id');
$mihpay_id=$this->input->post('mihpay_id');
$payment_id=$this->input->post('payment_id');
$mode=$this->input->post('mode');
$online_payment_status=$this->input->post('online_payment_status');
$unmapped_status=$this->input->post('unmapped_status');
$txn_id=$this->input->post('txn_id');
$payment_gateway_amount=$this->input->post('payment_gateway_amount');
$additional_charges=$this->input->post('additional_charges');
$added_on=$this->input->post('added_on');
$created_on=$this->input->post('created_on');
$first_name=$this->input->post('first_name');
$email=$this->input->post('email');
$phone=$this->input->post('phone');
$bank_ref_number=$this->input->post('bank_ref_number');
$bank_code=$this->input->post('bank_code');
$err_message=$this->input->post('err_message');
$name_on_card=$this->input->post('name_on_card');
$card_num=$this->input->post('card_num');
$card_type=$this->input->post('card_type');
$online_payment_discount=$this->input->post('online_payment_discount');
$net_amount_debit=$this->input->post('net_amount_debit');


$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");


//online payment status check
if($online_payment_status == "success"){
	$payment_statuss= 1;
	$order_statuss= 1;
}else{
	$payment_statuss= 0;
	$order_statuss= 0;
}


//user check foe security
$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$usrr_dat= $this->db->get()->row();

if(!empty($usrr_dat)){

if($usrr_dat->email == $user_email){

if($usrr_dat->password == $pass){

//paymemt type - Online Payment

if($payment_type==2)
{

									// 	$slot_order_limit = 0;
									// 	$this->db->select('*');
									// 				$this->db->from('tbl_delivery_slots');
									// 				$this->db->where('id',$slot_id);
									// 				$slot_data= $this->db->get()->row();
									// 				if(!empty($slot_data)){
									// 					$slot_order_limit = $slot_data->orders_limit;
									// 				}
									//
									// 	$this->db->select('*');
									// 	$this->db->from('tbl_order1');
									// 	$this->db->where('order_status',1);
									// 	$this->db->where('delivery_slot_id',$slot_id);
									// 	$this->db->where('delivery_date',$datepickerValue);
									//
									// 	$ordered_slots = $this->db->get()->num_rows();
									//
									// //slot-check
									// 	if($slot_order_limit > $ordered_slots){

											$ip = $this->input->ip_address();
											date_default_timezone_set("Asia/Calcutta");
											$cur_date = date("Y-m-d H:i:s");

											//insert into order1 tabel



												$data_insert = array(
												'user_id'=>$user_id,
												'address_id'=>$address_id,
												'payment_type'=>$payment_type,
												'payment_status'=>0,
												'order_status'=>0,
												'date'=>$cur_date,
												'last_update_date'=>$cur_date,
												'ip'=>$ip,
												'total_amount' =>0,
													'delivery_slot_id' =>$slot_id,
													'delivery_date' => $datepickerValue
													 );


										$order1_last_id=$this->base_model->insert_table("tbl_order1",$data_insert,1);


									//inventory-checked with cart tabel Products

									$this->db->select('*');
									$this->db->from('tbl_cart');
									$this->db->where('user_id',$user_id);
									$user_cart= $this->db->get();

									// print_r($user_cart->result()); die();
									$total_amount = 0;
									foreach($user_cart->result() as $item) {
									$selling_price = 0;
									$loop_item_product_id = $item->product_id;
									$loop_item_unit_id = $item->unit_id;
									$stock = $item->quantity;
										$this->db->select('*');
										$this->db->from('tbl_product');
										$this->db->where('id',$loop_item_product_id);
										$product_data_dsa = $this->db->get()->row();
										if(!empty($product_data_dsa)){
										$product_unit_type = $product_data_dsa->product_unit_type;

										$product_names = $product_data_dsa->name;

										if($product_unit_type == 1){
											$loop_item_unit_id = 0;

											$this->db->select('*');
											$this->db->from('tbl_product_units');
											$this->db->where('product_id',$loop_item_product_id);
											$this->db->where('id',$item->unit_id);
											$product_unit_dsa = $this->db->get()->row();

												if(!empty($product_unit_dsa)){
												$db_ratio = $product_unit_dsa->ratio;
													$stock = $db_ratio * $item->quantity;
												}

										}
									}

										$this->db->select('*');
										$this->db->from('tbl_inventory');
										$this->db->where('unit_id',$loop_item_unit_id);
										$this->db->where('product_id',$loop_item_product_id);
										$dsa= $this->db->get()->row();
										if(!empty($dsa)){





										$db_pro_stock = $dsa->stock;
										if($db_pro_stock >= $stock){

										$total_pro_stock = $db_pro_stock - $stock;

										$data_update = array(
										'stock'=>$total_pro_stock
										);
										$this->db->where('id', $dsa->id);
										$this->db->update('tbl_inventory', $data_update);

										$data_transaction_insert2 = array(
										'product_id'=>$item->product_id,
										'unit_id'=>$item->unit_id,
										'stock'=>$stock,
										'type'=>3,
										'ip' =>$ip,
										'added_by' =>$user_id,
										'is_active' =>1,
										'date'=>$cur_date
										);


										$this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);





									//insert into order2 tabel

									$this->db->select('*');
												$this->db->from('tbl_product_units');
												$this->db->where('id',$item->unit_id);
												$this->db->where('product_id',$item->product_id);
												$pu_data= $this->db->get()->row();
												if(!empty($pu_data)){

													 $selling_price = $pu_data->selling_price * $item->quantity ;
												}

									$order2_insert = array(
									'main_id'=>$order1_last_id,
									'product_id'=>$item->product_id,
									'unit_id'=>$item->unit_id,
									'quantity'=>$item->quantity,
									'date'=>$cur_date,
									'amount' =>$selling_price,
									'ip'=> $this->input->ip_address()
										 );
											$this->base_model->insert_table("tbl_order2",$order2_insert,1) ;

										 	$total_amount  = $total_amount + $selling_price;



										}
										else{
											// $data['data']=false;
											// $data['data_message']="Sorry! This product is out of stock";

$msg="Sorry! This product ".$product_names." is out of stock. Please remove this product from your cart.";

											$res = array('message'=> $msg,
															'status'=>201,


															);

											echo json_encode($res); exit;

										}
										}
										else{

											// $data['data']=false;
											// $data['data_message']="Sorry! This product's inventory is not exist";

$mssg="Sorry! This product ".$product_names." inventory is not exist. Please remove this product from your cart.";

											$res = array('message'=> $mssg,
															'status'=>201,


															);

											echo json_encode($res); exit;

										}


									}
// $total_amount;
// $order1_last_id;
 $user_id;

 $total_amount;
									//promocode
									if(!empty($applied_promocode)){


										  $total_amount = $this->isValidPromocode($order1_last_id,$total_amount,$applied_promocode,$user_id);
									}
// echo "hsy";
// echo $total_amount; die();



//Start user wallet check and deduct wallete amount

// if($wallet_check_status == 1 ){
//
//       			$this->db->select('*');
// $this->db->from('tbl_users');
// $this->db->where('id',$user_id);
// $user_wallet_data= $this->db->get()->row();
//
// if(!empty($user_wallet_data)){
//
// 		$main_wallet_blnce= $user_wallet_data->wallet;
//
// 		if($main_wallet_blnce > $total_amount){
// 			$wallet_balance= $total_amount;
// 		}else{
// 			$wallet_balance= $main_wallet_blnce;
// 		}
//
// }else{
// 	$wallet_balance= 0;
// }
//
// $total_amount= $total_amount - $wallet_balance;
//
// }

//End user wallet check and deduct wallete amount



								if($total_amount <= 100 ){
									$deliveryCharge= 0;
										$amount_subtotal= $total_amount + $deliveryCharge;

										$data_update = array(
											 'payment_status'=> $payment_statuss,
											 'order_status'=> $order_statuss,
											 'total_amount'=>$amount_subtotal,
											 'delivery_charge'=>$deliveryCharge,


		 'postback_param_id'=>$postback_param_id,
		 'mihpay_id'=>$mihpay_id,
		 'payment_id'=>$payment_id,
		 'mode'=>$mode,
		 'online_payment_status'=>$online_payment_status,
		 'unmapped_status'=>$unmapped_status,
		 'txn_id'=>$txn_id,
		 'payment_gateway_amount'=>$payment_gateway_amount,
		 'additional_charges'=>$additional_charges,
		 'added_on'=>$added_on,
		 'created_on'=>$created_on,
		 'first_name'=>$first_name,
		 'email'=>$email,
		 'phone'=>$phone,
		 'bank_ref_number'=>$bank_ref_number,
		 'bank_code'=>$bank_code,
		 'err_message'=>$err_message,
		 'name_on_card'=>$name_on_card,
		 'card_num'=>$card_num,
		 'card_type'=>$card_type,
		 'online_payment_discount'=>$online_payment_discount,
		 'net_amount_debit'=>$net_amount_debit

											);

								}else{
									$deliveryCharge= 0;
										$amount_subtotal= $total_amount;
									$data_update = array(
										'payment_status'=> $payment_statuss,
										'order_status'=> $order_statuss,
										 'total_amount'=>$amount_subtotal,
										 'delivery_charge'=>$deliveryCharge,

	 'postback_param_id'=>$postback_param_id,
	 'mihpay_id'=>$mihpay_id,
	 'payment_id'=>$payment_id,
	 'mode'=>$mode,
	 'online_payment_status'=>$online_payment_status,
	 'unmapped_status'=>$unmapped_status,
	 'txn_id'=>$txn_id,
	 'payment_gateway_amount'=>$payment_gateway_amount,
	 'additional_charges'=>$additional_charges,
	 'added_on'=>$added_on,
	 'created_on'=>$created_on,
	 'first_name'=>$first_name,
	 'email'=>$email,
	 'phone'=>$phone,
	 'bank_ref_number'=>$bank_ref_number,
	 'bank_code'=>$bank_code,
	 'err_message'=>$err_message,
	 'name_on_card'=>$name_on_card,
	 'card_num'=>$card_num,
	 'card_type'=>$card_type,
	 'online_payment_discount'=>$online_payment_discount,
	 'net_amount_debit'=>$net_amount_debit

										);
								}



										$this->db->where('id', $order1_last_id);
										$this->db->update('tbl_order1', $data_update);

if($online_payment_status == "success"){

									$check= 	$this->db->delete('tbl_cart', array('user_id' => $user_id));


//update rest wallet amount in user wallet after deduction from user's wallet

// if($wallet_check_status == 1 ){
//
// $this->db->select('*');
// $this->db->from('tbl_users');
// $this->db->where('id',$user_id);
// $wallet_user_datas= $this->db->get()->row();
//
// if(!empty($wallet_user_datas)){
// 	$user_wallet_amu= $wallet_user_datas->wallet;
// 	$rest_wallet_am= $user_wallet_amu - $wallet_balance;
//
//
// 	$data_user_wlt_update = array(
// 		'wallet'=> $rest_wallet_am
//
// 		);
//
// 		$this->db->where('id', $user_id);
// 		$this->db->update('tbl_users', $data_user_wlt_update);
// }
//
// }

								// 	$this->db->select('*');
								// 	$this->db->from('tbl_cart');
								// 	$this->db->where("user_id",$user_id);
								// 	//$this->db->where("is_cat_delete", 0);
								// 	$cart_products_data= $this->db->get();
							 //
							 // if(!empty($cart_products_data)){
								// // echo "wes"; die();
								// 	 foreach ($cart_products_data->result()  as $cart_product) {
							 //
							 //
							 // $data['cart_deleted']= $this->db->delete('tbl_cart', array('id' => $cart_product->id));
								// 		 // $this->db->where('id', $cat_product->id);
								// 		 // $this->db->where("is_cat_delete", 0);
								// 		 // $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
								// 	 }
							 // }


//send Email code start

									// 		$config = Array(
									// 		'protocol' => 'smtp',
									// 		'smtp_host' => 'mail.fineoutput.website',
									// 		'smtp_port' => 26,
									// 		'smtp_user' => 'info@fineoutput.website', // change it to yours
									// 		'smtp_pass' => 'info@fineoutput2019', // change it to yours
									// 		'mailtype' => 'html',
									// 		'charset' => 'iso-8859-1',
									// 		'wordwrap' => TRUE
									// 		);
									//
									// 		$this->db->select('*');
									// 					$this->db->from('tbl_users');
									// 					$this->db->where('id',$user_id);
									// 					$user_data= $this->db->get()->row();
									// $email = '';
									// 					if(!empty($user_data)){
									// 						$email =  $user_data->email;
									// 					}
									//
									// 		$to=$email;
									//
									// 		$email_data = array("order1_id"=>$order1_last_id
									// 		);
									//
									// 		$message = 	$this->load->view('frontend/emails/order-success',$email_data,TRUE);
									// 		// $message = 	"HELLO";
									// 		$this->load->library('email', $config);
									// 		$this->email->set_newline("");
									// 		$this->email->from('info@fineoutput.website'); // change it to yours
									// 		$this->email->to($to);// change it to yours
									// 		$this->email->subject('Order Placed Successfully');
									// 		$this->email->message($message);
									// 		if($this->email->send()){
									// 		//  echo 'Email sent.';
									// 		}else{
									// 		// show_error($this->email->print_debugger());
									// 		}


										// 	$enc_order_idd= base64_encode($order1_last_id);
										// 	 $enc_user_idd= base64_encode($user_id);
									 //
										// 	$data['orderr_idd']=$enc_order_idd;
										// 	$data['userr_idd']=$enc_user_idd;
									 //
										// 	$data['order_placed']=true;
									 //
									 // $data['data']=true;

									 $res = array('message'=>"success",
									 				'status'=>200,
									 				'order_id'=>$order1_last_id,
									 				'user_id'=>$user_id,




									 				);

									 echo json_encode($res); exit;


}else{
	$res = array('message'=>"Sorry! Payment Failed.",
					'status'=>201,
					'order_id'=>$order1_last_id,
					'user_id'=>$user_id,


					);

	echo json_encode($res); exit;
}


										// }
										// else{
										//
										// 	// $data['data']=false;
										// 	// $data['data_message']="Sorry! This slot is not available for Delivery.Please select another date and try again";
										//
										// 	$res = array('message'=>"Sorry! This slot is not available for Delivery.Please select another date and try again",
										// 					'status'=>201,
										//
										//
										// 					);
										//
										// 	echo json_encode($res); exit;
										//
										// }

}




}else{
	$res = array('message'=>"Wrong Password!",
					'status'=>201
					);

	echo json_encode($res); exit;
}

}else{
	$res = array('message'=>"Wrong Email!",
					'status'=>201
					);

	echo json_encode($res); exit;
}

}else{
	$res = array('message'=>"Wrong User!",
					'status'=>201
					);

	echo json_encode($res); exit;
}




}
else{
$res = array('message'=>validation_errors(),
					'status'=>201
					);

echo json_encode($res);
}
}
else{
$res = array('message'=>'Please insert some data, No data available',
				'status'=>201
				);

echo json_encode($res);
}

}







// payment api

public function payment()

{


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
$this->form_validation->set_rules('user_email', 'user_email', 'required|valid_email|xss_clean|trim');
$this->form_validation->set_rules('user_password', 'user_password', 'required|xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
 $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean');
 $this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean');
 $this->form_validation->set_rules('payment_method', 'payment_method', 'required|xss_clean');
 $this->form_validation->set_rules('total_amount', 'total_amount', 'required|xss_clean');
 $this->form_validation->set_rules('sub_total', 'sub_total', 'required|xss_clean');
	$this->form_validation->set_rules('total_order_weight', 'total_order_weight', 'required|xss_clean');
	$this->form_validation->set_rules('total_order_mrp', 'total_order_mrp', 'required|xss_clean');
	$this->form_validation->set_rules('total_order_rate_am', 'total_order_rate_am', 'required|xss_clean');
	$this->form_validation->set_rules('order_price', 'order_price', 'required|xss_clean');
	$this->form_validation->set_rules('ten_percent_of_order_price', 'ten_percent_of_order_price', 'required|xss_clean');
 $this->form_validation->set_rules('order_main_price', 'order_main_price', 'required|xss_clean');
 $this->form_validation->set_rules('order_shipping_amount', 'order_shipping_amount', 'required|xss_clean');
	$this->form_validation->set_rules('delivery_charge', 'delivery_charge', 'required|xss_clean');
	$this->form_validation->set_rules('discount', 'discount', 'required|xss_clean');


	if($this->form_validation->run()== TRUE)
	{

				 $user_id=$this->input->post('user_id');
				 $device_id=$this->input->post('device_id');
				 $user_email=$this->input->post('user_email');
				 $user_password=$this->input->post('user_password');
				 $user_pass= md5($user_password);
				// $passw=$this->input->post('password');
				// $pass=md5($passw);
				$order_id=$this->input->post('order_id');
				$address_id=$this->input->post('address_id');
				$applied_promocode=$this->input->post('applied_promocode');

				$payment_method=$this->input->post('payment_method');
				$total_amount=$this->input->post('total_amount');
				$sub_total=$this->input->post('sub_total');
				$total_order_weight=$this->input->post('total_order_weight');
				$total_order_mrp=$this->input->post('total_order_mrp');

				$total_order_rate_am=$this->input->post('total_order_rate_am');
				$order_price=$this->input->post('order_price');

				$ten_percent_of_order_price=$this->input->post('ten_percent_of_order_price');
				$order_main_price=$this->input->post('order_main_price');

				$order_shipping_amount=$this->input->post('order_shipping_amount');

				$delivery_charge=$this->input->post('delivery_charge');
				$discount=$this->input->post('discount');
				// $product_id=$this->input->post('product_id');
				// $type_id=$this->input->post('type_id');
				// $quantity=$this->input->post('quantity');


				$ip = $this->input->ip_address();
				date_default_timezone_set("Asia/Calcutta");
				$cur_date=date("Y-m-d H:i:s");


		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('id',$user_id);
		$user_data= $this->db->get()->row();

		if(!empty($user_data))
		{

			if($user_data->email == $user_email)
			{

				if($user_data->password == $user_pass)
				{


							// $this->db->select('*');
							// $this->db->from('tbl_order1');
							// $this->db->where('id',$order_id);
							// $order1data= $this->db->get()->row();



//promocode
				if(!empty($applied_promocode)){


						$sub_total = $this->isValidPromocode($order_id,$sub_total,$applied_promocode,$user_id,$device_id);
				}



						$data_insert = array(
									 'total_amount'=>$total_amount,
									 'sub_total'=>$sub_total,
									 'address_id'=>$address_id,
									 'promocode'=>$applied_promocode,
									 'payment_type'=>$payment_method,
									 'payment_status'=>1,
									 'order_status'=>1,
									 'delivery_charge'=>$delivery_charge,
									 'discount'=>$discount,
									 'total_order_weight'=>$total_order_weight,
									 'total_order_mrp'=>$total_order_mrp,
									 'total_order_rate_am'=>$total_order_rate_am,
									 'order_price'=>$order_price,
									 'ten_percent_of_order_price'=>$ten_percent_of_order_price,
									 'order_main_price'=>$order_main_price,
									 'order_shipping_amount'=>$order_shipping_amount,
									 'last_update_date'=>$cur_date,


											);
							$this->db->where('id', $order_id);
							$last_id=$this->db->update('tbl_order1', $data_insert);

						if(!empty($last_id)){
							$this->db->select('*');
							$this->db->from('tbl_cart');
							 $this->db->where('user_id',$user_id);
							// $this->db->where('mac_id',$mac_id);
							$cart1_data= $this->db->get();
							foreach($cart1_data->result() as $cart1){



								$lasts_id=$this->db->delete('tbl_cart', array('id' => $cart1->id));


							}

						}
							$res = array('message'=>"Success",
								'status'=>200
								);

							echo json_encode($res); exit;


						}
						else
						{


							$res = array('message'=>"Invalid Password",
								'status'=>201
								);

							echo json_encode($res);

						}


				}
				else
				{


					$res = array('message'=>"Invalid Email",
						'status'=>201
						);

					echo json_encode($res);

				}




		}
		else
		{


			$res = array('message'=>"User does not exist.",
				'status'=>201
				);

			echo json_encode($res);

		}


	}
	else
	{

		$res = array('message'=>validation_errors(),
							'status'=>201
							);

		echo json_encode($res);


	}

}
else{
$res = array('message'=>'Please insert some data, No data available',
				'status'=>201
				);

echo json_encode($res);


}


}








//--------------------------------------start garbage api(calculate)--------------------------------------//
			// calculation api

       function calculate()

      {


      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->helper('security');
      if($this->input->post())
      {

      $this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean');
      $this->form_validation->set_rules('total_amount', 'total_amount', 'required|xss_clean');
      $this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean');
      $this->form_validation->set_rules('qty', 'qty', 'required|xss_clean');
      // $this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
			// $address_id=$this->input->post('address_id');



      	if($this->form_validation->run()== TRUE)
      	{

					$address_id=$this->input->post('address_id');
					$total_amountt=$this->input->post('total_amount');
					$type_id[]=$this->input->post('type_id');
					$qty[]=$this->input->post('qty');
					$user_id=$this->input->post('user_id');

					// print_r($type_id);


							$ip = $this->input->ip_address();
							date_default_timezone_set("Asia/Calcutta");
							$cur_date=date("Y-m-d H:i:s");





							// type_id array
							$s3=str_replace("[", "",$type_id);
							$s4=str_replace("]", "",$s3);
							$myArrayTypeId = explode(',', $s4[0]);
							// print_r($myArrayTypeId);

							// qty array
							$s5=str_replace("[", "",$qty);
							$s6=str_replace("]", "",$s5);
							$myArrayQty = explode(',', $s6[0]);


							$cc1= count($myArrayTypeId);


//calculation part

							$type_weight=0;
							$final_amount=[];
							$total_type_wght=0;
							$total_type_mrp=0;

							for ($i=0; $i < $cc1; $i++) {


							 $type_id= $myArrayTypeId[$i];
							$quantity= $myArrayQty[$i];




							// $type_id= $order2->type_id;
							// $quantity= $order2->quantity;

							$this->db->select('*');
							$this->db->from('tbl_type');
							$this->db->where('id',$type_id);
							$typeData= $this->db->get()->row();

							$type_rate= $typeData->rate;
							$type_wgt= $typeData->weight;
							$type_mrp= $typeData->mrp;
							// $type_name= $typeData->type_name;

							// $type_wght = $type_weight + $type_wgt;

							$total_weight= $type_wgt * $quantity;
							$pack_charge= $total_weight *5;

							$a= $quantity*$type_rate;
							$other_exp= $a*5/100;

							$final_rate= $other_exp + $pack_charge;
							$final_rate_coasting= $final_rate + $type_rate;

							$bank_charge= $final_rate_coasting*3/100;

							$final_amount[]= $final_rate_coasting +  $bank_charge;

							$total_type_wght= $total_type_wght + $type_wgt;
							$total_type_mrp= $total_type_mrp + $type_rate;


							}

							// echo "wgt:".$total_type_wght;
							// echo "mrp:".$total_type_mrp;
							 $summ= array_sum($final_amount);
								 // print_r($final_amount); die();

								// echo "price:".
								$price= $total_type_mrp - $summ;

								 // echo "10%:".
								 $ten_percent_of_price= $price*10/100;

								 // echo "main_price:".
								 $main_price=  $price - $ten_percent_of_price;


								 		$total_order_weights=round($total_type_wght);
										 $total_order_mrp= round($total_type_mrp);
										 $total_order_rate_am= round($summ);
										 $order_price= round($price);
										 $order_main_prices= round($main_price);













					//calculate delivery charge and discount acording address shipping charge


							$total_order_weight= $total_order_weights;
							$order_main_price= $order_main_prices;
							$total_amount= $total_amountt;






							//user address shipping Charges

								$this->db->select('*');
								$this->db->from('tbl_user_address');
								$this->db->where('id',$address_id);
								$addres= $this->db->get()->row();

								if(!empty($addres)){
									$state_id=$addres->state;
									$city_id= $addres->city;

									$this->db->select('*');
									$this->db->from('tbl_shipping_charge');
									$this->db->where('state',$state_id);
									$this->db->where('city',$city_id);
									$shipping_data= $this->db->get()->row();

							if(!empty($shipping_data)){
									$shipping_amount= $shipping_data->shipping_charge;
							}

								}
							// echo $total_order_weight;
							// echo $order_main_price;

						 	 $total_weight_charge= $shipping_amount * $total_order_weight;

						// echo $order_main_price; die();

							if($order_main_price >= $total_weight_charge){
									$del_charge= $total_weight_charge;


							// $discount_am = $total_weight_charge - $order_main_price;
							$discount_am = $order_main_price - $del_charge ;
							$am= $total_amount + $discount_am ;

							}else{
								// $del_charge= $total_weight_charge;
								$del_charge= $total_weight_charge;
							$discount_am= 0;
							// $discount_am= $total_weight_charge;
							$am= $total_amount ;

							}




							$res = array('message'=>'success',
												'status'=>200,
												'total_order_weight'=>$total_order_weights,
												 'total_order_mrp'=>$total_order_mrp,
												 'total_order_rate_am'=>$total_order_rate_am,
												 'order_price'=>$order_price,
												 'order_main_price'=>$order_main_prices,
												'delivery_charge'=>$del_charge,
												'address_id'=>$address_id,
												'discount'=>$discount_am,
												'total_amount'=>$total_amount,
												'sub_total'=>$am,
												);

							echo json_encode($res); exit;





      	}
      	else
      	{

      		$res = array('message'=>validation_errors(),
      							'status'=>201
      							);

      		echo json_encode($res);


      	}

      }
      else{
      $res = array('message'=>'Please insert some data, No data available',
      				'status'=>201
      				);

      echo json_encode($res);


      }


      }

//-------------------------------------end garbage api(calculate)------------------------------------------//


//sir order_detail

 function order_detail(){


				 $this->load->helper(array('form', 'url'));
				 $this->load->library('form_validation');
				 $this->load->helper('security');
				 if($this->input->post())
				 {
					 // print_r($this->input->post());
					 // exit;
					 //$this->form_validation->set_rules('app_authentication_code', 'app_authentication_code', 'required|customAlpha|xss_clean');
// $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
//$this->form_validation->set_rules('mac_id', 'mac_id', 'required|xss_clean');
$this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean');
				 //  $this->form_validation->set_rules('textbox', 'textbox', 'required|customTextbox|xss_clean|min_length[8]');

					 if($this->form_validation->run()== TRUE)
					 {
						 //$app_authentication_code=$this->input->post('app_authentication_code');
						 $user_id=$this->input->post('user_id');
						 // $passw=$this->input->post('password');
						 //$mac_id=$this->input->post('mac_id');
						 $order_id=$this->input->post('order_id');
						 // $pass=md5($passw);

						 // if($this->form_validation->run()== TRUE)
						 // {



			 // $typ=base64_decode($t);
			 $this->db->select('*');
			 $this->db->from('tbl_users');
			 $this->db->where('id',$user_id);
			 $user_data= $this->db->get()->row();

			 if(!empty($user_data)){


//order1
$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$order_id);
$main_order= $this->db->get()->row();

$order_datetime=	$main_order->date;
$order_total=	$main_order->total_amount;
$order_sub_total=	"";

//order2
$this->db->select('*');
$this->db->from('tbl_order2');
$this->db->order_by('id','DESC');
$this->db->where('main_id',$order_id);
$da= $this->db->get();

$i=1; foreach($da->result() as $da2) {
$a=$da2->id;
$a1=$da2->product_id;
$a2=$da2->unit_id;
$a3=$da2->quantity;
$a4=$da2->amount;
// $a5=$da2->order_product_status;
// if($a5 == null){
// 	$a6= "";
// }

//product name
$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',$a1);
$product_data= $this->db->get()->row();
$base_url=base_url();
$product_name= $product_data->name;
$product_image= $product_data->image1;

//type name
$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('id',$a2);
$type_data= $this->db->get()->row();
$type_name= $type_data->unit_id;

$dataw[]=array('order2_id'=>$a,'product_name'=>$product_name,
'product_image'=>$base_url.$product_image ,'type_name'=>$type_name,'quantity'=>$a3,'quantity_price'=>$a4, 'order_datetime'=>$order_datetime,'order_total_amount'=>$order_total);

}

$res = array('message'=>"success",
'data'=>$dataw,
'status'=>200
);

echo json_encode($res); exit;





						 }
						 else{
							 $res = array('message'=>"User does not exist",
										 'status'=>201
										 );

							 echo json_encode($res);
						 }

					 }
					 else{
						 $res = array('message'=>validation_errors(),
											 'status'=>201
											 );

						 echo json_encode($res);
					 }
				 }
				 else{
					 $res = array('message'=>'Please insert some data, No data available',
										 'status'=>201
										 );

					 echo json_encode($res);
				 }

						 }




		 //order list

			 function orders(){


										$this->load->helper(array('form', 'url'));
										$this->load->library('form_validation');
										$this->load->helper('security');
										if($this->input->post())
										{
											// print_r($this->input->post());
											// exit;
											//$this->form_validation->set_rules('app_authentication_code', 'app_authentication_code', 'required|customAlpha|xss_clean');
											$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');


										//  $this->form_validation->set_rules('textbox', 'textbox', 'required|customTextbox|xss_clean|min_length[8]');

											if($this->form_validation->run()== TRUE)
											{
												//$app_authentication_code=$this->input->post('app_authentication_code');

												$user_id=$this->input->post('user_id');


												// if($this->form_validation->run()== TRUE)
												// {



									// $typ=base64_decode($t);
									$this->db->select('*');
									$this->db->from('tbl_users');
									$this->db->where('id',$user_id);
									$user_data= $this->db->get()->row();
			            $dataw=[];
									if(!empty($user_data)){




															$user_idd=$user_data->id;

					      			$this->db->select('*');
					$this->db->from('tbl_order1');
			    $this->db->order_by('id','DESC');
					$this->db->where('user_id',$user_idd);
					$this->db->where('order_status !=', 0);
					// $this->db->where('payment_status !=', 0);
					$da= $this->db->get();
// print_r($da->result()); exit;
					 if(!empty($da)){
					$i=1; foreach($da->result() as $da2) {

					$a1=$da2->id;
					$a2="";
					$a3=$da2->total_amount;
					// $a3=$da2->total_amount;
					$a4=$da2->payment_type;
					$a5=$da2->delivery_slot_id;
					$a6=$da2->delivery_date;
					$a7=$da2->delivery_status;
					$a8=$da2->delivery_charge;
					$a9=$da2->order_status;
					$a10=$da2->payment_status;
					$a11=$da2->address_id;
					if($a4==0){

					}
					if($a4==1){
						$a44="Cash on delivery";
			$dataw[]=array(
				'order_id'=>$a1,
			'sub_total'=>$a2,
			'amount'=>$a3,
			'payment_type'=>$a44,
			'payment_status'=>$a10,
			'delivery_slot_id'=>$a5,
			'delivery_date'=>$a6,
			'delivery_status'=>$a7,
			'delivery_charge'=>$a8,
			'order_status'=>$a9,
			'address_id'=>$a11,
			'date'=>$da2->date
		);
					}
					if($a4==2){
						$a44="online Payment";
			$dataw[]=array(
				'order_id'=>$a1,
			'sub_total'=>$a2,
			'amount'=>$a3,
			'payment_type'=>$a44,
			'payment_type'=>$a44,
			'payment_status'=>$a10,
			'delivery_slot_id'=>$a5,
			'delivery_date'=>$a6,
			'delivery_status'=>$a7,
			'delivery_charge'=>$a8,
			'order_status'=>$a9,
			'address_id'=>$a11,
			'date'=>$da2->date
		);
					}
				}
					$res = array('message'=>"success",
								'data'=>$dataw,
								'status'=>200
								);

					echo json_encode($res);

					}
					else{
						$res = array('message'=>"success",
									'data'=>[],
									'status'=>200
									);

						echo json_encode($res);

					}







												}
												else{
			                    $res = array('message'=>"success",
																'data'=>$dataw,
																'status'=>200
																);

													echo json_encode($res);
												}

											}
											else{
												$res = array('message'=>validation_errors(),
																	'status'=>201
																	);

												echo json_encode($res);
											}
										}
										else{
											$res = array('message'=>'Please insert some data, No data available',
																'status'=>201
																);

											echo json_encode($res);
										}

					            }

//promocode check function

 function isValidPromocode($inputOrderId,$final_amount,$userInput_promoCode,$user_idd){

								$user_id = $user_idd;
								$db_promocode_id = 0;
										$this->db->select('*');
										$this->db->from('tbl_promocode');
										$this->db->where('promocode',$userInput_promoCode);
										$dsa= $this->db->get();
										$da=$dsa->row();
										if(!empty($da)){
											$db_promocode_id = $da->id;
											$db_expiry_date = $da->expiry_date;
											$db_promocode_type = $da->type;
											$db_promocode_minimum_amount = $da->minimum_amount;
											$db_promocode_percent = $da->percent;
										 $db_promocode_maximum_gift_amount = $da->maximum_gift_amount;
										 $cur_date=date("Y-m-d");

											if($cur_date <= $db_expiry_date){
												if($db_promocode_type == 1){
																 $this->db->select('*');
																 $this->db->from('tbl_promocode_applied');
																 $this->db->where('user_id',$user_id);
																 $this->db->where('promocode_id',$da->id);
																 $dsa= $this->db->get();
																 $da=$dsa->row();
																 if(!empty($da)){
																	 return $final_amount;
																 }
											 }

															 if($final_amount >= $db_promocode_minimum_amount ){

																 if($db_promocode_percent <= 100){
																	 $calc = $db_promocode_percent / 100;
																	 $deduction_amount = $calc * $final_amount;

																	 if($deduction_amount > $db_promocode_maximum_gift_amount){
																		 $deduction_amount = $db_promocode_maximum_gift_amount;
																	 }

																	 $calculated_final_amount = $final_amount - (int) $deduction_amount;
																	 $current_date=date("Y-m-d");
																	$data_insert = array(
																						'user_id'=>$user_id,
																						'order_id'=>$inputOrderId,
																						'promocode_id'=>$db_promocode_id,
																						'date'=>$current_date

																						);
																					$this->base_model->insert_table("tbl_promocode_applied",$data_insert,1) ;

			//deduction amount save in order table
			$data_insert_discount = array(
								'discount'=>$deduction_amount


								);

							$this->db->where('id', $inputOrderId);
						 	$this->db->update('tbl_order1', $data_insert_discount);

																	 return $calculated_final_amount;

															 }else{
																 return $final_amount;
															 }


															 }else{
																 return $final_amount;
															 }



						 }else{
							 return $final_amount;
						 }
										}else{
											return $final_amount;
										}

						}




//promocode check function

public function Promocode_coupon(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('input_promocode', 'input_promocode', 'required|xss_clean|trim');
$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('final_amount', 'final_amount', 'required|xss_clean|trim');

if($this->form_validation->run()== TRUE)
{

$userInput_promoCode =$this->input->post('input_promocode');
$final_amount =$this->input->post('final_amount');
$device_id =$this->input->post('device_id');

// $user_id = $user_idd;
$db_promocode_id = 0;
	$this->db->select('*');
	$this->db->from('tbl_promocode');
	$this->db->where('promocode',$userInput_promoCode);
	$dsa= $this->db->get();
	$da=$dsa->row();
	if(!empty($da)){

		$db_promocode_id = $da->id;
		$db_expiry_date = $da->expiry_date;
		$db_promocode_type = $da->type;
		$db_promocode_minimum_amount = $da->minimum_amount;
		$db_promocode_percent = $da->percent;
	 $db_promocode_maximum_gift_amount = $da->maximum_gift_amount;
	 $cur_date=date("Y-m-d");

		if($cur_date <= $db_expiry_date){
			if($db_promocode_type == 1){
							 $this->db->select('*');
							 $this->db->from('tbl_promocode_applied');
							 // $this->db->where('user_id',$user_id);
							 $this->db->where('device_id',$device_id);
							 $this->db->where('promocode_id',$da->id);
							 $dsa= $this->db->get();
							 $da=$dsa->row();
							 if(!empty($da)){
								 // return $final_amount;

								 $res = array('message'=>"Promocode alredy used.",
												 'status'=>200,
												 'total_amount'=>$final_amount,
												 'discount'=>0,
												 'subtotal_amount'=>$final_amount,

												 );

								 echo json_encode($res); exit;
							 }

							 }
		 }

						 if($final_amount >= $db_promocode_minimum_amount ){

							 if($db_promocode_percent <= 100){
								 $calc = $db_promocode_percent / 100;
								 $deduction_amount = $calc * $final_amount;

								 if($deduction_amount > $db_promocode_maximum_gift_amount){
									 $deduction_amount = $db_promocode_maximum_gift_amount;
								 }

								 $calculated_final_amount = $final_amount - (int) $deduction_amount;
								 $current_date=date("Y-m-d");
								// $data_insert = array(
								// 					'user_id'=>$user_id,
								// 					'order_id'=>$inputOrderId,
								// 					'promocode_id'=>$db_promocode_id,
								// 					'date'=>$current_date
								//
								// 					);
								// 				$this->base_model->insert_table("tbl_promocode_applied",$data_insert,1) ;



								 // return $calculated_final_amount;
								 $res = array('message'=>"success",
												 'status'=>200,
												 'total_amount'=>$final_amount,
												 'discount'=>round($deduction_amount),
												 'subtotal_amount'=>round($calculated_final_amount),

												 );

								 echo json_encode($res); exit;
							 }


						 }else{
							 // return $final_amount;
							 $res = array('message'=>"your amount is less then promocode minimumn amount",
											 'status'=>201,
											 'total_amount'=>$final_amount,
											 'discount'=>0,
											 'subtotal_amount'=>$final_amount,

											 );

							 echo json_encode($res); exit;
						 }


						 }else{
							 $res = array('message'=>"Invalid Promocode",
												'status'=>201,
												'total_amount'=>$final_amount,
												'discount'=>0,
												'subtotal_amount'=>$final_amount,

												);

								echo json_encode($res); exit;
						 }







}
else{

$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res); exit;


}

}
else{
$res = array('message'=>'Please insert some data, No data available',
'status'=>201
);

echo json_encode($res); exit;


 }

}



//Cancel order api
public function cancel_order(){


			 $this->load->helper(array('form', 'url'));
			 $this->load->library('form_validation');
			 $this->load->helper('security');
			 if($this->input->post())
			 {

				$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');

				$this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean');



				 if($this->form_validation->run()== TRUE)
				 {

					 $user_id=$this->input->post('user_id');

					 $order_id=$this->input->post('order_id');

					 date_default_timezone_set("Asia/Calcutta");
					 $cur_date=date("Y-m-d H:i:s");



		 $this->db->select('*');
		 $this->db->from('tbl_users');
		 $this->db->where('id',$user_id);
		 $user_data= $this->db->get()->row();

		 if(!empty($user_data)){


//order1
$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$order_id);
$main_order= $this->db->get()->row();

if(!empty($main_order)){

$payment_type= $main_order->payment_type;

	if($payment_type == 1){
		$data_update = array(
			'order_status'=> 5,
			'cod_cancel_status'=> 1,
			'cancel_order_type'=> 1,
			'last_update_date'=>$cur_date
		 );
	}else{
		$data_update = array(
			'order_status'=> 5,
			'cancel_order_type'=> 1,
			'last_update_date'=>$cur_date
		 );
	}


$this->db->where('id', $order_id);
$this->db->update('tbl_order1', $data_update);


$res = array('message'=>"success",
'status'=>200
);

echo json_encode($res); exit;

}else{

$res = array('message'=>"Order does not exist",
		'status'=>201
		);

echo json_encode($res); exit;

}



					 }
					 else{
						 $res = array('message'=>"User does not exist",
									 'status'=>201
									 );

						 echo json_encode($res); exit;
					 }

				 }
				 else{
					 $res = array('message'=>validation_errors(),
										 'status'=>201
										 );

					 echo json_encode($res); exit;
				 }
			 }
			 else{
				 $res = array('message'=>'Please insert some data, No data available',
									 'status'=>201
									 );

				 echo json_encode($res); exit;
			 }

	 }






	 	//Get API FOR all Promocodes list
	 	public function get_promocode(){

	 									 $this->db->select('*');
	 									$this->db->from('tbl_promocode');
	 									//$this->db->where('email',$email);
	 									$all_promocode_data= $this->db->get();
$data=[];
if(!empty($all_promocode_data)){
							foreach ($all_promocode_data->result() as  $promocode) {
	 										$data[]=array(
	 											'id'=> $promocode->id,
	 											'promocode'=> $promocode->promocode,
	 											'percent'=>$promocode->percent,
	 											'type'=>$promocode->type,
	 											'minimum_amount'=>$promocode->minimum_amount,
	 											'maximum_gift_amount'=>$promocode->maximum_gift_amount,
	 											'expiry_date'=>$promocode->expiry_date,
	 											'date'=>$promocode->date,

	 										);



	 									}


									}

									$res = array('message'=>"Success",
												'status'=>200,
												'data'=>$data

												);
												
	 									echo json_encode($res); exit;


	 	}



//deduct wallet amount fron order cart total amount

public function wallet_deduction(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('check_status', 'check_status', 'required|xss_clean|trim');


if($this->form_validation->run()== TRUE)
{

$user_id =$this->input->post('user_id');
$check_status =$this->input->post('check_status');



//cart table user order toatl amount


									$this->db->select('*');
									$this->db->from('tbl_cart');
									$this->db->where('user_id',$user_id);
									$user_cart= $this->db->get();

									// print_r($user_cart->result()); die();
									$total_amount = 0;
									if(!empty($user_cart)){
									foreach($user_cart->result() as $item) {
									$selling_price = 0;
									//get total amount of cart

									$this->db->select('*');
												$this->db->from('tbl_product_units');
												$this->db->where('id',$item->unit_id);
												$this->db->where('product_id',$item->product_id);
												$pu_data= $this->db->get()->row();
												if(!empty($pu_data)){

													 $selling_price = $pu_data->selling_price * $item->quantity ;
												}



										 	$total_amount  = $total_amount + $selling_price;

									}
								}




//Start user wallet check and deduct wallete amount
      			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$user_wallet_data= $this->db->get()->row();

if(!empty($user_wallet_data)){

	$main_wallet_blnce= $user_wallet_data->wallet;

		if($check_status == 1){

				if($main_wallet_blnce > $total_amount){
					$wallet_balance= $total_amount;
				}else{
					$wallet_balance= $main_wallet_blnce;
				}

		}else{
		$wallet_balance= $main_wallet_blnce;
		}

}else{
	$wallet_balance= 0;
}

if($check_status == 1){
$total_amount= $total_amount - $wallet_balance;
}
//End user wallet check and deduct wallete amount





$res = array('message'=>'success',
'status'=>200,
'wallet_balance'=> $wallet_balance,
'total_amount'=>$total_amount
);

echo json_encode($res); exit;


}
else{

$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res); exit;


}

}
else{
$res = array('message'=>'Please insert some data, No data available',
'status'=>201
);

echo json_encode($res); exit;


 }

}







//check cod cancel status API Post
			public function cod_cancel_status_check()
			{


				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->helper('security');
				if($this->input->post())
				{

				$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean|trim');


				if($this->form_validation->run()== TRUE)
				{


			$user_id=$this->input->post('user_id');

		  $ip = $this->input->ip_address();
	  	date_default_timezone_set("Asia/Calcutta");
		  $cur_date=date("Y-m-d H:i:s");

			$txnnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);


//check cart inventory part

//inventory-checked with cart tabel Products

			$this->db->select('*');
			$this->db->from('tbl_cart');
			$this->db->where('user_id',$user_id);
			$user_cart= $this->db->get();

if(!empty($user_cart)){
			// print_r($user_cart->result()); die();
			// $total_amount = 0;
			foreach($user_cart->result() as $item) {
			// $selling_price = 0;
			$loop_item_product_id = $item->product_id;
			$loop_item_unit_id = $item->unit_id;
			$stock = $item->quantity;
				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$loop_item_product_id);
				$product_data_dsa = $this->db->get()->row();
				if(!empty($product_data_dsa)){
				$product_unit_type = $product_data_dsa->product_unit_type;

				$product_names = $product_data_dsa->name;

				if($product_unit_type == 1){
					$loop_item_unit_id = 0;

					$this->db->select('*');
					$this->db->from('tbl_product_units');
					$this->db->where('product_id',$loop_item_product_id);
					$this->db->where('id',$item->unit_id);
					$product_unit_dsa = $this->db->get()->row();

						if(!empty($product_unit_dsa)){
						$db_ratio = $product_unit_dsa->ratio;
							$stock = $db_ratio * $item->quantity;
						}

				}
			}

				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('unit_id',$loop_item_unit_id);
				$this->db->where('product_id',$loop_item_product_id);
				$dsa= $this->db->get()->row();
				if(!empty($dsa)){





				$db_pro_stock = $dsa->stock;
				if($db_pro_stock >= $stock){





				}
				else{
					// $data['data']=false;
					// $data['data_message']="Sorry! This product is out of stock";

			$msg="Sorry! This product ".$product_names." is out of stock. Please remove this product from your cart.";

					$res = array('message'=> $msg,
									'status'=>201,


									);

					echo json_encode($res); exit;

				}
				}
				else{

					// $data['data']=false;
					// $data['data_message']="Sorry! This product's inventory is not exist";

			$mssg="Sorry! This product ".$product_names." inventory is not exist. Please remove this product from your cart.";

					$res = array('message'=> $mssg,
									'status'=>201,


									);

					echo json_encode($res); exit;

				}


			}
}





//start check status of cod cancel of last order of user part

			      			$this->db->select('*');
			$this->db->from('tbl_order1');
			// $this->db->where('order_status', 1);
			$this->db->where('user_id', $user_id);
			$this->db->order_by('id','Desc');
			$order_datta= $this->db->get()->row();

// print_r($order_datta);
			if(!empty($order_datta)){
				$payment_type= $order_datta->payment_type;
				$cod_cncl_status= $order_datta->cod_cancel_status;
				$order_status= $order_datta->order_status;
				$payment_status= $order_datta->payment_status;
				$online_payment_status= $order_datta->online_payment_status;

				if($payment_type == 1  ){
					if($cod_cncl_status == 1 ){
						$show_status= 1;
					}else{
						$show_status= 0;
					}

				}else{

					if($online_payment_status == "success" && $payment_status == 1  ){
						$show_status= 0;
					}else{
						$show_status= 1;
					}

				}


			}else{
				$show_status= 0;
			}

			//end zipcode delivery_date status





					$res = array('message'=>"success",
					'status'=>200,
					'show_status'=>$show_status,
						'txnId'=> $txnnid,
					);

					echo json_encode($res); exit;
        	// return $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code



								}else{

								$res = array('message'=>validation_errors(),
								        'status'=>201
								        );

								echo json_encode($res); exit;


								}

								}else{
								$res = array('message'=>'Please insert some data, No data available',
								      'status'=>201
								      );

								echo json_encode($res); exit;


								}



			}






			public function add_order_deliveryboy_rating()
			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
      $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean');
      $this->form_validation->set_rules('order_rating', 'order_rating', 'required|xss_clean');
      $this->form_validation->set_rules('delivery_rating', 'delivery_rating', 'required|xss_clean');
      $this->form_validation->set_rules('feedback', 'feedback', 'required|xss_clean');

			if($this->form_validation->run()== TRUE)
			{

			$user_id=$this->input->post('user_id');

      $order_id=$this->input->post('order_id');
      $order_rating=$this->input->post('order_rating');
      // $area=$this->input->post('area');
      $delivery_rating=$this->input->post('delivery_rating');
      $feedback=$this->input->post('feedback');


			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");


      			$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$order_id);
$order_dataa= $this->db->get()->row();

if(!empty($order_dataa)){
        $data_update = array('delivery_rating'=>$delivery_rating,
                            'order_rating'=>$order_rating,

        					'feedback'=>$feedback,


        					);



									$this->db->where('id', $order_id);
									$this->db->update('tbl_order1', $data_update);

									$res = array('message'=>"success",
				        					'status'=>200

				        					);

				        	echo json_encode($res); exit;

}else{

	$res = array('message'=>"failed",
					'status'=>201

					);

	echo json_encode($res); exit;

}




        	// return $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code


			}
			else{

			$res = array('message'=>validation_errors(),
			        'status'=>201
			        );

			echo json_encode($res);


			}

			}
			else{
			$res = array('message'=>'Please insert some data, No data available',
			      'status'=>201
			      );

			echo json_encode($res);


			}


			}





}
