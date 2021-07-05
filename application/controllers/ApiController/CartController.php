<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class CartController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}



			public function add_to_cart()

			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
      $this->form_validation->set_rules('category_id', 'category_id', 'xss_clean|trim');
      $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('type_price', 'type_price', 'xss_clean|trim');
      $this->form_validation->set_rules('qty', 'qty', 'required|xss_clean|trim');




			if($this->form_validation->run()== TRUE)
			{
			$device_id=$this->input->post('device_id');
			$user_id=$this->input->post('user_id');
			$category_id=$this->input->post('category_id');
			$product_id=$this->input->post('product_id');
			$type_id=$this->input->post('type_id');
			$type_price=$this->input->post('type_price');
			 $qty=$this->input->post('qty');

       $total_qty_price= $type_price * $qty ;

			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");

if(empty($user_id)){

$this->db->select('*');
$this->db->from('tbl_cart');
// $this->db->where('user_id',$user_id);
$this->db->where('device_id',$device_id);
$this->db->where('product_id',$product_id);
$cartt_data= $this->db->get()->row();


$unit_id_inv_id = 0;
$check_quantity = 0;
if(empty($cartt_data)){

	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('id',$product_id);
	$product_data_dsa = $this->db->get()->row();
	if(!empty($product_data_dsa)){
		$product_unit_type = $product_data_dsa->product_unit_type;


	if($product_unit_type == 1){

		$this->db->select('*');
		$this->db->from('tbl_product_units');
		$this->db->where('product_id',$product_id);
		$this->db->where('id',$type_id);
			$this->db->where('is_active', 1);
		$product_unit_dsa = $this->db->get()->row();

		if(!empty($product_unit_dsa)){


				$db_ratio = $product_unit_dsa->ratio;
				$check_quantity = $db_ratio * $qty;
		}

	}

	if($product_unit_type == 2){
	$unit_id_inv_id = $type_id;
	$check_quantity = $qty;
}
}


if($product_unit_type == 1){
	$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('product_id',$product_id);
	// $this->db->where('unit_id',$unit_id_inv_id);
	$tbl_inventory_dsa_data =  $this->db->get()->row();
}else{
	$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('product_id',$product_id);
	$this->db->where('unit_id',$unit_id_inv_id);
	$tbl_inventory_dsa_data =  $this->db->get()->row();
}



	if(!empty($tbl_inventory_dsa_data)){
		$db_qty = $tbl_inventory_dsa_data->stock;

		if($check_quantity <= $db_qty){

			$data_insert = array(
													 'device_id'=>$device_id,

					'user_id'=>$user_id,
					// 'category_id'=>$category_id,
					'product_id'=>$product_id,
					'unit_id'=>$type_id,
					// 'type_price'=>$type_price,
					'quantity'=>$qty,
					// 'total_qty_price'=>$total_qty_price,
					'ip' =>$ip,

					'date'=>$cur_date,
					// 'updated_date'=>$cur_date,

					);





			$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;



						}else{


					$res = array('message'=>"Product is out of stock",
					'status'=>201
					);

					echo json_encode($res); exit;

						}
				}else{

					$res = array('message'=>"Product is out of stock",
					'status'=>201
					);

					echo json_encode($res); exit;

				}








    }
    // elseif ($qty == 0) {
    //
    //   $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));
    //
    //
    // }
    else{

      if($qty != 0){


				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$product_id);
				$product_data_dsa = $this->db->get()->row();
				if(!empty($product_data_dsa)){
					$product_unit_type = $product_data_dsa->product_unit_type;


				if($product_unit_type == 1){

					$this->db->select('*');
					$this->db->from('tbl_product_units');
					$this->db->where('product_id',$product_id);
					$this->db->where('id',$type_id);
						$this->db->where('is_active', 1);
					$product_unit_dsa = $this->db->get()->row();

					if(!empty($product_unit_dsa)){
							$db_ratio = $product_unit_dsa->ratio;
							$check_quantity = $db_ratio * $qty;
					}

				}

				if($product_unit_type == 2){
				$unit_id_inv_id = $type_id;
				$check_quantity = $qty;
			}
			}



			if($product_unit_type == 1){
				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('product_id',$product_id);
				// $this->db->where('unit_id',$unit_id_inv_id);
				$tbl_inventory_dsa_data =  $this->db->get()->row();
			}else{
				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('product_id',$product_id);
				$this->db->where('unit_id',$unit_id_inv_id);
				$tbl_inventory_dsa_data =  $this->db->get()->row();
			}



				if(!empty($tbl_inventory_dsa_data)){
					$db_qty = $tbl_inventory_dsa_data->stock;

					if($check_quantity <= $db_qty){




      $data_updates = array(

          'unit_id'=>$type_id,
          // 'type_price'=>$type_price,
          'quantity'=>$qty,
          // 'total_qty_price'=>$total_qty_price,

          // 'updated_date'=>$cur_date,

          );



          // $this->db->where('device_id', $device_id);
          // $this->db->where('product_id',$product_id);
          $this->db->where('id', $cartt_data->id);
          $last_id=$this->db->update('tbl_cart', $data_updates);


				}else{


			$res = array('message'=>"Product is out of stock",
			'status'=>201
			);

			echo json_encode($res); exit;

				}
		}else{

			$res = array('message'=>"Product is out of stock",
			'status'=>201
			);

			echo json_encode($res); exit;

		}



        }else{

          $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));

        }


    }

	}else{

//with login

$this->db->select('*');
$this->db->from('tbl_cart');
// $this->db->where('user_id',$user_id);
$this->db->where('user_id',$user_id);
$this->db->where('product_id',$product_id);
$cartt_data= $this->db->get()->row();


$unit_id_inv_id = 0;
$check_quantity = 0;
if(empty($cartt_data)){

	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('id',$product_id);
	$product_data_dsa = $this->db->get()->row();
	if(!empty($product_data_dsa)){
		$product_unit_type = $product_data_dsa->product_unit_type;


	if($product_unit_type == 1){

		$this->db->select('*');
		$this->db->from('tbl_product_units');
		$this->db->where('product_id',$product_id);
		$this->db->where('id',$type_id);
			$this->db->where('is_active', 1);
		$product_unit_dsa = $this->db->get()->row();

		if(!empty($product_unit_dsa)){
				$db_ratio = $product_unit_dsa->ratio;
				$check_quantity = $db_ratio * $qty;
		}

	}

	if($product_unit_type == 2){
	$unit_id_inv_id = $type_id;
	$check_quantity = $qty;
}
}


if($product_unit_type == 1){
	$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('product_id',$product_id);
	// $this->db->where('unit_id',$unit_id_inv_id);
	$tbl_inventory_dsa_data =  $this->db->get()->row();
}else{
	$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('product_id',$product_id);
	$this->db->where('unit_id',$unit_id_inv_id);
	$tbl_inventory_dsa_data =  $this->db->get()->row();
}



	if(!empty($tbl_inventory_dsa_data)){
		$db_qty = $tbl_inventory_dsa_data->stock;

		if($check_quantity <= $db_qty){

			$data_insert = array(
													 'device_id'=>$device_id,

					'user_id'=>$user_id,
					// 'category_id'=>$category_id,
					'product_id'=>$product_id,
					'unit_id'=>$type_id,
					// 'type_price'=>$type_price,
					'quantity'=>$qty,
					// 'total_qty_price'=>$total_qty_price,
					'ip' =>$ip,

					'date'=>$cur_date,
					// 'updated_date'=>$cur_date,

					);





			$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;



						}else{


					$res = array('message'=>"Product is out of stock",
					'status'=>201
					);

					echo json_encode($res); exit;

						}
				}else{

					$res = array('message'=>"Product is out of stock",
					'status'=>201
					);

					echo json_encode($res); exit;

				}








    }
    // elseif ($qty == 0) {
    //
    //   $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));
    //
    //
    // }
    else{

      if($qty != 0){


				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$product_id);
				$product_data_dsa = $this->db->get()->row();
				if(!empty($product_data_dsa)){
					$product_unit_type = $product_data_dsa->product_unit_type;


				if($product_unit_type == 1){

					$this->db->select('*');
					$this->db->from('tbl_product_units');
					$this->db->where('product_id',$product_id);
					$this->db->where('id',$type_id);
						$this->db->where('is_active', 1);
					$product_unit_dsa = $this->db->get()->row();

					if(!empty($product_unit_dsa)){
							$db_ratio = $product_unit_dsa->ratio;
							$check_quantity = $db_ratio * $qty;
					}

				}

				if($product_unit_type == 2){
				$unit_id_inv_id = $type_id;
				$check_quantity = $qty;
			}
			}


			if($product_unit_type == 1){
				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('product_id',$product_id);
				// $this->db->where('unit_id',$unit_id_inv_id);
				$tbl_inventory_dsa_data =  $this->db->get()->row();
			}else{
				$this->db->select('*');
				$this->db->from('tbl_inventory');
				$this->db->where('product_id',$product_id);
				$this->db->where('unit_id',$unit_id_inv_id);
				$tbl_inventory_dsa_data =  $this->db->get()->row();
			}



				if(!empty($tbl_inventory_dsa_data)){
					$db_qty = $tbl_inventory_dsa_data->stock;

					if($check_quantity <= $db_qty){




      $data_updates = array(

          'unit_id'=>$type_id,
          // 'type_price'=>$type_price,
          'quantity'=>$qty,
          // 'total_qty_price'=>$total_qty_price,

          // 'updated_date'=>$cur_date,

          );



          // $this->db->where('device_id', $device_id);
          // $this->db->where('product_id',$product_id);
          $this->db->where('id', $cartt_data->id);
          $last_id=$this->db->update('tbl_cart', $data_updates);


				}else{


			$res = array('message'=>"Product is out of stock",
			'status'=>201
			);

			echo json_encode($res); exit;

				}
		}else{

			$res = array('message'=>"Product is out of stock",
			'status'=>201
			);

			echo json_encode($res); exit;

		}



        }else{

          $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));

        }


    }



	}

			if($last_id!=0)
			{

    			$res = array('message'=>"success",
    			'status'=>200
    			);

    			echo json_encode($res);

			}

			else
			{
			$res = array('message'=>"failed",
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



      //Cart Data Get API

      public function get_cart()
      {

      // if(!empty($this->session->userdata('admin_data'))){
      //$data= [];

      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->helper('security');
      if($this->input->post())
      {

      $this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
			$this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
			$this->form_validation->set_rules('password', 'password', 'xss_clean|trim');

      if($this->form_validation->run()== TRUE)
      {



        $device_id=$this->input->post('device_id');
        $user_id=$this->input->post('user_id');
				$email=$this->input->post('email');
        $password=$this->input->post('password');
				$pass= $password;


          $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
          $cur_date=date("Y-m-d H:i:s");

$txnnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				// 	$this->db->select('*');
				// $this->db->from('tbl_user_address');
				// $this->db->where('user_id',$user_id);
				// $device_user_addr_data= $this->db->get();

if(empty($user_id)) {

//without Login


      $this->db->select('*');
      $this->db->from('tbl_cart');
      $this->db->where('device_id',$device_id);
      // $this->db->where('is_active',1);
      $cart_data= $this->db->get();
      // print_r($cart_data->result()); die();
      $base_url=base_url();
        $product_data= [];
				$slot=[];
				$total_cart_amount = 0;
if(!empty($cart_data)){
      $i=1; foreach($cart_data->result() as $datas) {

				$this->db->select('*');
				$this->db->from('tbl_product_units');
				$this->db->where('product_id',$datas->product_id);
				$this->db->where('id',$datas->unit_id);
				$this->db->where('is_active',1);
				$product_unitss_data= $this->db->get()->row();

				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$datas->product_id);
				$this->db->where('is_active',1);
				$this->db->where('is_cat_delete',0);
				$this->db->where('is_subcat_delete',0);

				$product_das= $this->db->get()->row();

        $p1=$datas->product_id;
        $p2=$product_das->category_id;
        $p3=$datas->unit_id;
				$p7=$product_unitss_data->id;
        $p4=$datas->quantity;
        $p6=$product_unitss_data->selling_price;
        $p5=$datas->quantity * $product_unitss_data->selling_price;

//inventory check by product stocks start

				$stock = $p4;


		$product_unit_type = $product_das->product_unit_type;

		if($product_unit_type == 1){


			$this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$datas->product_id);
			$this->db->where('id',$datas->unit_id);
			$this->db->where('is_active',1);
			$product_unit_dsas = $this->db->get()->row();

				if(!empty($product_unit_dsas)){

				$db_ratio = $product_unit_dsas->ratio;

					$stock = $db_ratio * $p4;

				}

		}


if($product_unit_type == 1){

	$this->db->select('*');
	$this->db->from('tbl_inventory');
	// $this->db->where('unit_id',$datas->unit_id);
	$this->db->where('product_id',$datas->product_id);
	$dsa_inv= $this->db->get()->row();

}else{
		$this->db->select('*');
		$this->db->from('tbl_inventory');
		$this->db->where('unit_id',$datas->unit_id);
		$this->db->where('product_id',$datas->product_id);
		$dsa_inv= $this->db->get()->row();
}
		// echo $loop_item_unit_id;
		// echo $loop_item_product_id;
		// print_r($dsa); die();
		if(!empty($dsa_inv)){


		$db_pro_stock = $dsa_inv->stock;
		if($db_pro_stock >= $stock){

		$inventory_status= 1;

		}else{

			$inventory_status= 0;

		}

} else{

	$inventory_status= 0;
}

//inventory check by product stocks end

 				// $cart[]= array (
      				// 		'id'=>$data->id,
      				// 	'name'=>$data->name,
      				// 	'short_desc'=>$data->short_dis,
      				// 	'long_desc'=>$data->long_desc,
      				// 	'url'=>$data->url,
      				// 	'image'=>$base_url."assets/admin/major_category/".$data->image,
      				// 	'is_active'=>$data->is_active,
      				// );

              $typedata= [];
                $this->db->select('*');
                $this->db->from('tbl_product');
                $this->db->where('id', $p1);
                $products= $this->db->get()->row();
                $base_url=base_url();




                $this->db->select('*');
                $this->db->from('tbl_product_units');
                $this->db->where('product_id',$products->id);
								$this->db->where('is_active',1);
                $type_data= $this->db->get();
                if(!empty($type_data)){
                foreach ($type_data->result() as $type) {


								// 	$this->db->select('*');
								// $this->db->from('tbl_units');
								// $this->db->where('id',$type->unit_id);
								// $this->db->where('is_active',1);
								// $ptoduct_unit_data= $this->db->get()->row();

								if(!empty($type->unit_id)){

									$unit_name= $type->unit_id;
								}else{
									$unit_name="";
								}


                $typedata[]= array(
                	'type_id'=>$type->id,
                	'unit_id'=>$type->id,
                	'type_name'=>$unit_name,
                	'type_category_id'=>$p2,
                	'type_product_id'=>$type->product_id,
                	'type_mrp'=>$type->mrp,
                	'gst_percentage'=>"",
                	'gst_percentage_price'=>"",
                	'selling_price'=>$type->selling_price,
                	'type_weight'=>"",
                	'type_rate'=>"",
                	'total_typ_qty_price'=>$p4 * $type->selling_price,
									'type_ratio'=>$type->ratio,
                );

                }
                }else{
                $typedata[]= [];
                }


								if(!empty($products->app_image1)){
									$app_image_1= $base_url.$products->app_image1;
								}else{
									$app_image_1= "";
								}

								if(!empty($products->app_image2)){
									$app_image_2= $base_url.$products->app_image2;
								}else{
									$app_image_2= "";
								}

								if(!empty($products->app_image3)){
									$app_image_3= $base_url.$products->app_image3;
								}else{
									$app_image_3= "";
								}

								if(!empty($products->app_image4)){
									$app_image_4= $base_url.$products->app_image4;
								}else{
									$app_image_4= "";
								}

								if(!empty($products->app_main_image)){
									$app_mains_image= $base_url.$products->app_main_image;
								}else{
									$app_mains_image= "";
								}



                $product_data[]=  array (
                	'id'=>$datas->id,
                  'product_id'=>$p1,
                	'category_id'=>$p2,
                	'type_id'=>$p7,
                	'unit_id'=>$p3,
                	'type_price'=>round($p6),
									'inventory_status'=>$inventory_status,
                'quantity'=>$p4,
                'total_qty_price'=>round($p5),
                'product_name'=>$products->name,
                'long_desc'=>$products->long_description,
                'short_desc'=>$products->short_description,
                'url'=>"",
								'image1'=>$app_image_1,
								'image2'=>$app_image_2,
								'image3'=>$app_image_3,
								'image4'=>$app_image_4,
								'app_main_image'=>$app_mains_image,
								'product_unit_type'=>$products->product_unit_type,
								'is_cat_delete'=>$products->is_cat_delete,
                'is_active'=>$products->is_active,
                'type'=>$typedata
                );

                $typedata= [];



$total_cart_amount =$total_cart_amount + $p5;



      }

if($total_cart_amount < 100){
	$delivery_charge=30;
}else{
	$delivery_charge=0;
}



//slot data

$this->db->select('*');
$this->db->from('tbl_delivery_slots');
// $this->db->where('product_id',$products->id);
$slot_data= $this->db->get();

if(!empty($slot_data)){
foreach ($slot_data->result() as $slott) {

$str_slot= date("h:i a", strtotime($slott->from_time))." to ".date("h:i a", strtotime($slott->to_time));


$slot[]=array(
	'id'=>$slott->id,
	'from_time'=>$slott->from_time,
	'to_time'=>$slott->to_time,
	'orders_limit'=>$slott->orders_limit,
	'custom_slot'=>$str_slot,

);

}
}else{
$slot[]= [];
}




      $res = array('message'=>"success",
      'status'=>200,
			'delivery_charge'=> $delivery_charge,
			'wallet_balance'=> 0,
			'txnId'=> $txnnid,
			'slot'=> $slot,
      'data'=> $product_data,
      );

      echo json_encode($res); exit;

}
else{
  $product_data=[];
  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $product_data,
  );

  echo json_encode($res); exit;

}

}else{

//with Login

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$usrr_dat= $this->db->get()->row();

if(!empty($usrr_dat)){

if($usrr_dat->email == $email){

if($usrr_dat->password == $pass){


      $this->db->select('*');
      $this->db->from('tbl_cart');
      $this->db->where('user_id',$user_id);
      // $this->db->where('is_active',1);
      $cart_data= $this->db->get();
      // print_r($cart_data->result()); die();
      $base_url=base_url();
        $product_data= [];
				$slot=[];
				$total_cart_amount = 0;

if(!empty($cart_data)){
      $i=1; foreach($cart_data->result() as $datas) {

				$this->db->select('*');
				$this->db->from('tbl_product_units');
				$this->db->where('product_id',$datas->product_id);
				$this->db->where('id',$datas->unit_id);
				$this->db->where('is_active',1);
				$product_unitss_data= $this->db->get()->row();

				$this->db->select('*');
				$this->db->from('tbl_product');
				$this->db->where('id',$datas->product_id);
				$this->db->where('is_active',1);
				$this->db->where('is_cat_delete',0);
				$this->db->where('is_subcat_delete',0);

				$product_das= $this->db->get()->row();


        $p1=$datas->product_id;
        $p2=$product_das->category_id;
        $p3=$datas->unit_id;
				$p7=$product_unitss_data->id;
        $p4=$datas->quantity;
        $p6=$product_unitss_data->selling_price;
        $p5=$datas->quantity * $product_unitss_data->selling_price;



				//inventory check by product stocks start

								$stock = $p4;


						$product_unit_type = $product_das->product_unit_type;

						if($product_unit_type == 1){


							$this->db->select('*');
							$this->db->from('tbl_product_units');
							$this->db->where('product_id',$datas->product_id);
							$this->db->where('id',$datas->unit_id);
							$this->db->where('is_active',1);
							$product_unit_dsas = $this->db->get()->row();

								if(!empty($product_unit_dsas)){

								$db_ratio = $product_unit_dsas->ratio;

									$stock = $db_ratio * $p4;

								}

						}


if($product_unit_type == 1){

						$this->db->select('*');
						$this->db->from('tbl_inventory');
						// $this->db->where('unit_id',$datas->unit_id);
						$this->db->where('product_id',$datas->product_id);
						$dsa_inv= $this->db->get()->row();
}else{
	$this->db->select('*');
	$this->db->from('tbl_inventory');
	$this->db->where('unit_id',$datas->unit_id);
	$this->db->where('product_id',$datas->product_id);
	$dsa_inv= $this->db->get()->row();
}
						// echo $loop_item_unit_id;
						// echo $loop_item_product_id;
						// print_r($dsa); die();
						// print_r($dsa_inv); die();
						if(!empty($dsa_inv)){


						$db_pro_stock = $dsa_inv->stock;
						if($db_pro_stock >= $stock){

						$inventory_status= 1;

						}else{

							$inventory_status= 0;

						}

				} else{

					$inventory_status= 0;
				}

				//inventory check by product stocks end



      				// $cart[]= array (
      				// 		'id'=>$data->id,
      				// 	'name'=>$data->name,
      				// 	'short_desc'=>$data->short_dis,
      				// 	'long_desc'=>$data->long_desc,
      				// 	'url'=>$data->url,
      				// 	'image'=>$base_url."assets/admin/major_category/".$data->image,
      				// 	'is_active'=>$data->is_active,
      				// );

              $typedata= [];
                $this->db->select('*');
                $this->db->from('tbl_product');
                $this->db->where('id', $p1);
                $products= $this->db->get()->row();
                $base_url=base_url();




                $this->db->select('*');
                $this->db->from('tbl_product_units');
                $this->db->where('product_id',$products->id);
								$this->db->where('is_active',1);
                $type_data= $this->db->get();
                if(!empty($type_data)){
                foreach ($type_data->result() as $type) {

								//
								// 	$this->db->select('*');
								// $this->db->from('tbl_units');
								// $this->db->where('id',$type->unit_id);
								// $this->db->where('is_active',1);
								// $ptoduct_unit_data= $this->db->get()->row();

								if(!empty($type->unit_id)){

									$unit_name= $type->unit_id;
								}else{
									$unit_name="";
								}


                $typedata[]= array(
                	'type_id'=>$type->id,
                	'unit_id'=>$type->id,
                	'type_name'=>$unit_name,
                	'type_category_id'=>$p2,
                	'type_product_id'=>$type->product_id,
                	'type_mrp'=>$type->mrp,
                	'gst_percentage'=>"",
                	'gst_percentage_price'=>"",
                	'selling_price'=>$type->selling_price,
                	'type_weight'=>"",
                	'type_rate'=>"",
                	'total_typ_qty_price'=>$p4 * $type->selling_price,
									'type_ratio'=>$type->ratio,
                );

                }
                }else{
                $typedata[]= [];
                }


                $product_data[]=  array (
                	'id'=>$datas->id,
                  'product_id'=>$p1,
                	'category_id'=>$p2,
                	'type_id'=>$p7,
                	'unit_id'=>$p3,
                	'type_price'=>round($p6),
									'inventory_status'=>$inventory_status,
                'quantity'=>$p4,
                'total_qty_price'=>round($p5),
                'product_name'=>$products->name,
                'long_desc'=>$products->long_description,
                'short_desc'=>$products->short_description,
                'url'=>"",
								'image1'=>$base_url.$products->image1,
								'image2'=>$base_url.$products->image2,
								'image3'=>$base_url.$products->image3,
								'image4'=>$base_url.$products->image4,
								'product_unit_type'=>$products->product_unit_type,
								'is_cat_delete'=>$products->is_cat_delete,
                'is_active'=>$products->is_active,
                'type'=>$typedata
                );

                $typedata= [];



$total_cart_amount =$total_cart_amount + $p5;



      }


//delivery charge
			if($total_cart_amount < 100){
				$delivery_charge=30;
			}else{
				$delivery_charge=0;
			}


//wallet balance
$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$user_wallet_data= $this->db->get()->row();

if(!empty($user_wallet_data)){
	$wallet_balance= $user_wallet_data->wallet;
}else{
	$wallet_balance= 0;
}



//slot data

			$this->db->select('*');
			$this->db->from('tbl_delivery_slots');
			// $this->db->where('product_id',$products->id);
			$slot_data= $this->db->get();

			if(!empty($slot_data)){
			foreach ($slot_data->result() as $slott) {

			$str_slot= date("h:i a", strtotime($slott->from_time))." to ".date("h:i a", strtotime($slott->to_time));


			$slot[]=array(
				'id'=>$slott->id,
				'from_time'=>$slott->from_time,
				'to_time'=>$slott->to_time,
				'orders_limit'=>$slott->orders_limit,
				'custom_slot'=>$str_slot,

			);

			}
			}else{
			$slot[]= [];
			}

//End Slot




      $res = array('message'=>"success",
      'status'=>200,
			'delivery_charge'=> $delivery_charge,
			'wallet_balance'=> $wallet_balance,
			'txnId'=> $txnnid,
			'slot'=> $slot,
      'data'=> $product_data,
      );

      echo json_encode($res); exit;

}
else{
  $product_data=[];
  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $product_data,
  );

  echo json_encode($res); exit;

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

      //     }
      //     else{
      //
      // redirect("login/admin_login","refresh");
      //
      //
      //     }

      }





//current_delivery_date_status_check API Post
			public function current_delivery_date_status_check()
			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('address_id', 'address_id', 'required|xss_clean|trim');


			if($this->form_validation->run()== TRUE)
			{

			$address_id=$this->input->post('address_id');

		  $ip = $this->input->ip_address();
	  	date_default_timezone_set("Asia/Calcutta");
		  $cur_date=date("Y-m-d H:i:s");



			//start zipcode delivery_date status

			      			$this->db->select('*');
			$this->db->from('tbl_user_address');
			$this->db->where('id',$address_id);
			$addres_datta= $this->db->get()->row();

			if(!empty($addres_datta)){
				$addr_zipcode= $addres_datta->zipcode;

				      			$this->db->select('*');
				$this->db->from('tbl_address_zipcode');
				$this->db->where('zipcode',$addr_zipcode);
				$zipcode_tbl_data= $this->db->get()->row();

				if(!empty($zipcode_tbl_data)){

						$day_status= $zipcode_tbl_data->day;

						if($day_status != "" && $day_status != null && $day_status == 1){
								$d_status = "1";
						}else{
								$d_status= "0";
						}

				}else{
					$d_status= "0";
				}

			}else{
				$d_status= "0";
			}

			//end zipcode delivery_date status





					$res = array('message'=>"success",
					'status'=>200,
					'delivery_d_status'=>$d_status,
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





			//Cart Data Delete API Post
						public function delete_cart()

						{

						$this->load->helper(array('form', 'url'));
						$this->load->library('form_validation');
						$this->load->helper('security');
						if($this->input->post())
						{

						$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
			      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
			      $this->form_validation->set_rules('cart_id', 'cart_id', 'required|xss_clean');
			      // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');





						if($this->form_validation->run()== TRUE)
						{
						$device_id=$this->input->post('device_id');
						$user_id=$this->input->post('user_id');

			      $cart_id=$this->input->post('cart_id');
			      // $category_id=$this->input->post('category_id');




						  $ip = $this->input->ip_address();
						date_default_timezone_set("Asia/Calcutta");
						  $cur_date=date("Y-m-d H:i:s");


			if(empty($user_id)){

			//Without Login

							$this->db->select('*');
			$this->db->from('tbl_cart');
			//$this->db->where('id',$usr);
			$this->db->where('device_id',$device_id);
			$this->db->where('id',$cart_id);
			$cart= $this->db->get()->row();

			if(!empty($cart)){

				$delet_id=$this->db->delete('tbl_cart', array('id' => $cart_id));


			}else{
				$delet_id= 0;
			}







			        if($delet_id!=0)
			        {

								$res = array('message'=>"success",
								'status'=>200
								);

								echo json_encode($res); exit;
			        	// return $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code
			        }

			        else
			        {
			        $res = array('message'=>"failed",
			        				'status'=>201
			        				);

			        echo json_encode($res); exit;
			        }

			}
			else{

			//With Login

			$this->db->select('*');
			$this->db->from('tbl_cart');
			$this->db->where('user_id',$user_id);
			$this->db->where('id',$cart_id);
			$cart= $this->db->get()->row();

			if(!empty($cart)){

			$delet_id=$this->db->delete('tbl_cart', array('id' => $cart_id));


			}else{
			$delet_id= 0;
			}




			if($delet_id!=0)
			{

				$res = array('message'=>"success",
				'status'=>200
				);

				echo json_encode($res); exit;
				// return $this->response(array('status' => 'success'), 200); // 200 being the HTTP response code
			}

			else
			{
			$res = array('message'=>"failed",
							'status'=>201
							);

			echo json_encode($res); exit;
			}





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






}
