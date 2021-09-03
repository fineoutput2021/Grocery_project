<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}

		public function checkout()
			{
			if(!empty	($this->session->userdata('user_data'))){
					$this->load->view('common/header');
					$this->load->view('checkout');
					$this->load->view('common/footer');

				}else{
					 $this->session->set_flashdata('popup',1);
					redirect("/","refresh");
				}
			}
public function cart(){
  if (!empty($this->session->userdata('user_id'))) {
    $user_id =  $this->session->userdata('user_id');

    $this->db->select('*');
      $this->db->from('tbl_cart');
      $this->db->where('user_id',$user_id);
      $data['cart_data']= $this->db->get();
	$data['local_cart_data'] =	$this->session->userdata('cart_items');
      $this->load->view('common/header',$data);
    $this->load->view('local_cart');
    $this->load->view('common/footer');
  }
  else{
	$data['local_cart_data'] =	$this->session->userdata('cart_items');
		// print_r($data);
		// exit;
    $this->load->view('common/header',$data);
      $this->load->view('local_cart');
      $this->load->view('common/footer');
  }
}





public function add_to_cart()
	{


    $this->load->helper(array('form', 'url'));
   			$this->load->library('form_validation');
   			$this->load->helper('security');
   			if($this->input->post())
   			{

   				// print_r($this->input->post());
   				// exit;
   		$this->form_validation->set_rules('product_id', 'product_id', 'required');
   		$this->form_validation->set_rules('unit_id', 'unit_id', 'required');
   		$this->form_validation->set_rules('quantity', 'quantity', 'required');
   		// $this->form_validation->set_rules('lname', 'last name', 'required');


   				if($this->form_validation->run()== TRUE)
   				{
   					// echo "hii";
   					// exit;
   					 $product_id=$this->input->post('product_id');
   					 $unit_id=$this->input->post('unit_id');
   					 $quantity=$this->input->post('quantity');


						 $ip = $this->input->ip_address();
					 date_default_timezone_set("Asia/Calcutta");
					 	$cur_date=date("Y-m-d H:i:s");
// echo $product_id; die();
              if(!empty($this->session->userdata('user_id'))){

              $user_id =  $this->session->userdata('user_id');


							$this->db->select('*');
		$this->db->from('tbl_inventory');
		$this->db->where('product_id',$product_id);
		$this->db->where('unit_id',$unit_id);
		$this->db->where('is_active',1);
		$inv_data= $this->db->get()->row();

		if(!empty($inv_data)){

		$db_inv_stock= $inv_data->stock;
		if($db_inv_stock >= $quantity){

			 									 $this->db->select('*');
			 									       $this->db->from('tbl_cart');
			 									       $this->db->where('product_id',$product_id);
			 									       $this->db->where('user_id',$user_id);
			 									       $dsa= $this->db->get();
			 									       $da=$dsa->row();

			 				 			  if(empty($da)){

			 									     $data_insert = array('product_id'=>$product_id,

			 									            'user_id'=>$user_id,
			 									            'unit_id' =>$unit_id,
			 									            'quantity' =>$quantity,

			 									            'ip' =>$ip,
			 									            'date' =>$cur_date,

			 									            );





			 									  $last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;





			 									 }else{

												 $this->session->set_flashdata('header_emessage','Item is already in your cart.');
												 	redirect($_SERVER['HTTP_REFERER']);

			 									 }






 									}else {
 										$this->session->set_flashdata('header_emessage','Product is out of stock.');
 											redirect($_SERVER['HTTP_REFERER']);
 									}

 								}else{
 									$this->session->set_flashdata('header_emessage','Product is out of stock.');
 										redirect($_SERVER['HTTP_REFERER']);
 								}



$this->session->set_flashdata('header_smessage','Product added in your cart.');
      redirect($_SERVER['HTTP_REFERER']);

              }else{


//items array
								$cart_item = array('product_id'=>$product_id,
													'unit_id'=>$unit_id,
													'quantity'=>$quantity,

													'ip' =>$ip,

													'date'=>$cur_date

													);


if(!$this->session->has_userdata('cart_items')) {

	      			$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('product_id',$product_id);
	$this->db->where('unit_id',$unit_id);
	$this->db->where('is_active',1);
	$inv_data= $this->db->get()->row();
// print_r($inv_data);
	if(!empty($inv_data)){
// die('demo');
		$db_inv_stock= $inv_data->stock;
		if($db_inv_stock >= $quantity){


//add to cart start

			$cart = array($cart_item);
			$this->session->set_userdata('cart_items', $cart);

//add to cart end


		}else {
			$this->session->set_flashdata('header_emessage','Product is out of stock.');
				redirect($_SERVER['HTTP_REFERER']);
		}

	}else{
		$this->session->set_flashdata('header_emessage','Product is out of stock.');
			redirect($_SERVER['HTTP_REFERER']);
	}




}else {


				$this->db->select('*');
			$this->db->from('tbl_inventory');
			$this->db->where('product_id',$product_id);
			$this->db->where('unit_id',$unit_id);
			$this->db->where('is_active',1);
			$inv_data= $this->db->get()->row();

			if(!empty($inv_data)){

			$db_inv_stock= $inv_data->stock;
			if($db_inv_stock >= $quantity){


				//product is exist or not
				$cart = $this->session->userdata('cart_items');

				foreach ($cart as $items) {
					if($items['product_id'] == $product_id){
						$this->session->set_flashdata('header_emessage','Product is already in your cart.');
							redirect($_SERVER['HTTP_REFERER']);
					}
				}

				//add cart data start

				array_push($cart, $cart_item);

				$this->session->set_userdata('cart_items', $cart);

				//add cart data end



			}else {
			$this->session->set_flashdata('header_emessage','Product is out of stock.');
			redirect($_SERVER['HTTP_REFERER']);
			}

			}else{
			$this->session->set_flashdata('header_emessage','Product is out of stock.');
			redirect($_SERVER['HTTP_REFERER']);
			}




}


// $old_cart= $this->session->userdata('cart_items');
// // $data['cart_data']= $this->session->userdata('cart_items');
//
// print_r($old_cart);
//
// echo "success1"; die();


$this->session->set_flashdata('header_smessage','Product added in your cart.');
redirect($_SERVER['HTTP_REFERER']);


              }



  		}else{

  		$this->session->set_flashdata('header_emessage',validation_errors());
  		redirect($_SERVER['HTTP_REFERER']);

  		}

  }else{

  		$this->session->set_flashdata('header_emessage','Please insert some data, No data available');
  		redirect($_SERVER['HTTP_REFERER']);

  }



	}




  	public function delete_product($idd){

  				 if(!empty($this->session->userdata('user_id'))){

  	$id=base64_decode($idd);



  	$this->db->select('id');
  	$this->db->from('tbl_cart');
  	$this->db->where('id',$id);
  	$dsa= $this->db->get();
  	$da=$dsa->row();

  	if(!empty($da)){

  				$id=$da->id;

  	$zapak=$this->db->delete('tbl_cart', array('id' => $id));
  	if($zapak!=0){
  	//      $path = FCPATH . "assets/public/slider/".$id;
  	// unlink($path);
  	redirect("Cart/cart","refresh");

  		}else{
  		$this->session->set_flashdata('emessage','Sorry error occured');
  				redirect($_SERVER['HTTP_REFERER']);
  		}


  		}else{
  			$this->session->set_flashdata('emessage','Sorry error occured');
  					redirect($_SERVER['HTTP_REFERER']);
  		}

  	}
  	else{

  	redirect("Home/login","refresh");

  	}

  	}



			//update quantity in cart table after user login
									 public function update_qty_in_tbl_cart(){

						 $this->load->helper(array('form', 'url'));
							$this->load->library('form_validation');
							$this->load->helper('security');
							if($this->input->post())
							{

									 				 	$cart_id= $this->input->post('cart_id');
									 					$product_id= $this->input->post('product_id');
									 					$quantity= $this->input->post('quantity');
									 					// $user_id= $this->session->userdata('usersid');
									 					$user_id= 15;

									 					date_default_timezone_set("Asia/Calcutta");
									 					$cur_date=date("Y-m-d H:i:s");


			      			$this->db->select('*');
			$this->db->from('tbl_cart');
			$this->db->where('id',$cart_id);
			$cart_data= $this->db->get()->row();

			// print_r($cart_data); die();
									 if(!empty($cart_data)){

									 	$data_update = array(
									 		'quantity'=> $quantity

									 	 );

										 $this->db->where('id', $cart_id);
			 					      $last_id=$this->db->update('tbl_cart', $data_update);

											//total cart product count of user
											$this->db->select('*');
										$this->db->from('tbl_cart');
										$this->db->where('user_id',$user_id);
										$user_cart_count= $this->db->count_all_results();

										if($last_id !=0)	{

									 	  $data['data'] = true;
									 	  $data['cartcount'] = $user_cart_count;
										}else{
											$data['data'] = false;
											$data['cartcount'] = $user_cart_count;
										}

									 }else{

									 $data['data'] = false;

									 }

						 }else{

				 		 $data['data'] = false;
				 		 $data['data_message'] = 'Please insert some data, No data available';

				 		 }

									 echo json_encode($data);

									 	}






			public function delete_product_session($idd){
				$pro_id= base64_decode($idd);
		$index="-1";
				$cart = $this->session->userdata('cart_items');
				if(!empty($cart)){
			        for ($i = 0; $i < count($cart); $i ++) {
			            if ($cart[$i]['product_id'] == $pro_id) {
			                $index= $i;
			            }
			        }
				}
		// echo print_r($cart); die();

							if($index > -1){
							        $cart = $this->session->userdata('cart_items');
							        unset($cart[$index]);
							        $this->session->set_userdata('cart_items', $cart);

								}


		 redirect('Cart/cart');

			}




		//update quantity in cart session before user login
								 public function update_qty_in_session(){

					 $this->load->helper(array('form', 'url'));
						$this->load->library('form_validation');
						$this->load->helper('security');
						if($this->input->post())
						{


													$product_id= $this->input->post('product_id');
													$unit_id= $this->input->post('unit_id');
													$quantity= $this->input->post('quantity');
													// $user_id= $this->session->userdata('usersid');
													$user_id= 15;

													date_default_timezone_set("Asia/Calcutta");
													$cur_date=date("Y-m-d H:i:s");



				$index="-1";
						$cart = $this->session->userdata('cart_items');
						// print_r( $cart ); die();
					        for ($i = 0; $i < count($cart); $i ++) {
					            if ($cart[$i]['product_id'] == $product_id) {
												// echo "v"; die();
					                $index= $i;
					            }
					        }

		// echo $index; die();
								if($index > -1){
									// echo "done"; die();
								        $cart = $this->session->userdata('cart_items');

												$cart[$index]['quantity'] = $quantity;
												$this->session->set_userdata('cart_items', $cart);



									$data['data'] = true;

								}else{
									$data['data'] = false;
									$data['data_message'] = 'Some error occured';
								}




					 }else{

					 $data['data'] = false;
					 $data['data_message'] = 'Please insert some data, No data available';

					 }

								 echo json_encode($data);

									}








}
