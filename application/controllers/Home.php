<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}
public function index()
	{

      			$this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$data['category']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_sliders2');
$this->db->where('is_active',1);
$data['sliders2']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_sliders');
$this->db->where('is_active',1);
$data['sliders']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_home_slider');
$this->db->where('is_active',1);
$data['home']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_combo');
// $this->db->where('is_active',1);
$data['combo']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_combo2');
// $this->db->where('is_active',1);
$data['combo2']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_trending_products');
// $this->db->where('is_active',1);
$data['da']= $this->db->get();


						$this->db->select('*');
						$this->db->from('tbl_recent_products');
						// $this->db->where('is_active',1);
						$data['re']= $this->db->get();




			$this->load->view('common/header',$data);
			$this->load->view('index');
			$this->load->view('common/footer');

	}

public function shop($td="")
	{

$views=$this->input->get('view');
$mini=$this->input->get('mini');
$sub=$this->input->get('sub');

			$ts=base64_decode($td);
// echo ($ts);exit;
$data['category_id']=$ts;

$this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('id',$ts);
            $dsa= $this->db->get();
            $da=$dsa->row();
					if(!empty($da)){
						$data['cat_name']=$da->name;

					}
					else{
						$data['cat_name']="";
					}


if(!empty($sub)){

$this->db->select('*');
            $this->db->from('tbl_subcategory');
            $this->db->where('id',$sub);
            $dsa= $this->db->get();
            $da=$dsa->row();
      $data['ssub_cat']=$da->name;
						// exit;
		$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('is_active',1);
	$this->db->where('subcategory_id',$sub );
	$data['products']= $this->db->get();


	$this->db->select('*');
	$this->db->from('tbl_sub_category2');
	$this->db->where('subcategory_id',$sub);
	$data['subcategory2_da']= $this->db->get();

	$this->db->select('*');
	$this->db->from('tbl_subcategory');
	$this->db->where('category_id',$ts);
	$data['subcategory_da']= $this->db->get();

// $data['subcategory_da']= "";
$data['page_from']= 1;


}elseif (!empty($mini)) {

	$this->db->select('*');
	            $this->db->from('tbl_sub_category2');
	            $this->db->where('id',$mini);
	            $dsa= $this->db->get();
	            $da=$dsa->row();
	      $data['min_ssub_cat']=$da->name;
				$cc2=$da->subcategory_id;

				$this->db->select('*');
				            $this->db->from('tbl_subcategory');
				            $this->db->where('id',$cc2);
				            $dsa= $this->db->get();
				            $da=$dsa->row();
				           $data['ssub_cat']=$da->name;


	$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('subcategory2_id',$mini);
$data['products']= $this->db->get();


//get subcategory
$this->db->select('*');
$this->db->from('tbl_sub_category2');
$this->db->where('id',$mini);
$subcate2_da= $this->db->get()->row();
// print_r($pro_da); die();
if(!empty($subcate2_da)){
	$subcate_id= $subcate2_da->subcategory_id;

	$this->db->select('*');
	$this->db->from('tbl_sub_category2');
	$this->db->where('subcategory_id',$subcate_id);
	$data['subcategory2_da']= $this->db->get();
}else{
	$data['subcategory2_da']= "";
}


$data['subcategory_da']= "";

$data['page_from']= 2;

}else {

	$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('category_id',$ts);
$data['products']= $this->db->get();

$this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('category_id',$ts);
$data['subcategory_da']= $this->db->get();

$data['subcategory2_da']= "";

$data['page_from']= 0;

}








// if (!empty($mini)) {
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$mini);
// $data['products']= $this->db->get();
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$mini);
// $dt= $this->db->get()->row();
// if (!empty($dt)) {
// 	$ts=$dt->category_id;
// }
// }


//
// if (!empty($sub)) {
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $data['products']= $this->db->get();
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $dt= $this->db->get()->row();
// $ts=$dt->category_id;
// }

if (!empty($views)) {
	// code...
	$this->db->select('*');
$this->db->from('tbl_trending_products');
// $this->db->where('is_active',1);
$data['da']= $this->db->get();

}

$this->db->order_by('rand()');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('category_id',$ts);
$this->db->limit(9);
$data['relate']= $this->db->get();

      			$this->db->select('*');
$this->db->from('tbl_category');
//$this->db->where('',);
$data['category']= $this->db->get();





			$this->load->view('common/header',$data);
			$this->load->view('shop');
			$this->load->view('common/footer');

	}

public function shop_third_category($td="")
	{

$views=$this->input->get('view');
$mini=$this->input->get('mini');
$sub=$this->input->get('sub');

			$ts=base64_decode($td);
// echo ($ts);exit;
$data['subcategory_id']=$ts;

      			$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('subcategory_id',$ts);
$data['products']= $this->db->get();

if (!empty($mini)) {

						$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('subcategory_id',$mini);
$data['products']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('subcategory_id',$mini);
$dt= $this->db->get()->row();
if (!empty($dt)) {
	$ts=$dt->category_id;
}
}
//
// if (!empty($sub)) {
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $data['products']= $this->db->get();
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $dt= $this->db->get()->row();
// $ts=$dt->category_id;
// }

if (!empty($views)) {
	// code...
	$this->db->select('*');
$this->db->from('tbl_trending_products');
// $this->db->where('is_active',1);
$data['da']= $this->db->get();

}

$this->db->order_by('rand()');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('subcategory_id',$ts);
$this->db->limit(9);
$data['relate']= $this->db->get();

      			$this->db->select('*');
$this->db->from('tbl_category');
//$this->db->where('',);
$data['subcategory']= $this->db->get();

			$this->load->view('common/header',$data);
			$this->load->view('shop_third_category');
			$this->load->view('common/footer');

	}




	public function shop_subcategory_products($idd)
		{

	// $views=$this->input->get('view');
	// $mini=$this->input->get('mini');
	// $sub=$this->input->get('sub');

				$id=base64_decode($idd);
	// echo ($ts);exit;
	$data['subcategory_id']=$idd;

	      			$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('is_active',1);
	$this->db->where('subcategory_id',$id);
	$data['products']= $this->db->get();

//get subcategory name
	$this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('id',$id);
$subcategory_da= $this->db->get()->row();
// echo $id;
// print_r($subcategory_da); die();
$subcategory_name= "N/A";
if(!empty($subcategory_da)){
	$subcategory_name= $subcategory_da->name;
}

	$data['subcategory_name']= $subcategory_name;

	$this->db->order_by('rand()');
	$this->db->from('tbl_product');
	$this->db->where('is_active',1);
	$this->db->where('subcategory_id',$id);
	$this->db->limit(9);
	$data['relate']= $this->db->get();

	      			$this->db->select('*');
	$this->db->from('tbl_category');
	//$this->db->where('',);
	$data['category']= $this->db->get();

				$this->load->view('common/header',$data);
				$this->load->view('shop_subcat_products');
				$this->load->view('common/footer');

		}




public function single($pro)
	{

			$product_id=base64_decode($pro);
			// echo $product_id;

			$this->db->select('*');
			$this->db->from('tbl_product');
			$this->db->where('is_active',1);
			$this->db->where('id',$product_id);
			$data['product']= $this->db->get()->row();

			$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('is_active',1);
	$this->db->where('id',$product_id);
	$pr= $this->db->get()->row();

//get product name
	$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('id',$product_id);
$prod_da= $this->db->get()->row();
// echo $id;
// print_r($subcategory_da); die();
$product_name= "N/A";
if(!empty($prod_da)){
	$product_name= $prod_da->name;
}

$data['product_name']= $product_name;

			$this->db->order_by('rand()');
			$this->db->from('tbl_product');
			$this->db->where('is_active',1);
			$this->db->where('subcategory_id',$pr->subcategory_id);
			$this->db->limit(9);
			$data['relate']= $this->db->get();

			$this->load->view('common/header',$data);
			$this->load->view('single');
			$this->load->view('common/footer');

	}
public function about()
	{
			$this->load->view('common/header');
			$this->load->view('about');
			$this->load->view('common/footer');

	}
public function blog_detail()
	{
			$this->load->view('common/header');
			$this->load->view('blog_detail');
			$this->load->view('common/footer');

	}
public function blog()
	{
			$this->load->view('common/header');
			$this->load->view('blog');
			$this->load->view('common/footer');

	}
public function cart()
	{
			$this->load->view('common/header');
			$this->load->view('cart');
			$this->load->view('common/footer');

	}
public function checkout()
	{
			$this->load->view('common/header');
			$this->load->view('checkout');
			$this->load->view('common/footer');

	}
public function contact()
	{
			$this->load->view('common/header');
			$this->load->view('contact');
			$this->load->view('common/footer');

	}
public function faq()
	{
			$this->load->view('common/header');
			$this->load->view('faq');
			$this->load->view('common/footer');

	}
public function my_address()
	{
			$this->load->view('common/header');
			$this->load->view('my_address');
			$this->load->view('common/footer');

	}
public function my_profile()
	{
			$this->load->view('common/header');
			$this->load->view('my_profile');
			$this->load->view('common/footer');

	}
public function not_found()
	{
			$this->load->view('common/header');
			$this->load->view('not_found');
			$this->load->view('common/footer');

	}
public function orderlist()
	{
			$this->load->view('common/header');
			$this->load->view('orderlist');
			$this->load->view('common/footer');

	}
public function wishlist()
	{
			$this->load->view('common/header');
			$this->load->view('wishlist');
			$this->load->view('common/footer');

	}
public function order_success()
	{
			$this->load->view('common/header');
			$this->load->view('order_success');
			$this->load->view('common/footer');

	}

public function sign_up()
	{
			$this->load->view('common/header');
			$this->load->view('sign_up');
			$this->load->view('common/footer');

	}


	public function error404()
		{
				$this->load->view('errors/error404');

		}



	// public function blog()
	// {
	//
	//
	// 											$this->db->select('*');
	// 											$this->db->from('tbl_blog');
	// 											$this->db->where('is_active',1);
	// 											$this->db->order_by('blog_id', 'DESC');
	// 											$data['blog_data']= $this->db->get();
	//
	//
	//
	//
	// 		$this->load->view('blog/header',$data);
	// 		$this->load->view('blog/blog');
	// 		$this->load->view('blog/footer');
	//     // }
	// }


		// public function single()
		// {
		//
		// 		$this->load->view('blog/single-header');
		// 		$this->load->view('blog/blogsingle');
		// 		$this->load->view('blog/footer');
		//
		// }



		// get type dataType



		public function get_unit_type_data(){




			$product_id= $this->input->get('product_id');
			$unit_id= $this->input->get('unit_id');
			// $product_id= 1;


				$this->db->select('*');
			  $this->db->from('tbl_product_units');
			  // $this->db->where('product_id',$product_id);
			  $this->db->where('id',$unit_id);
			  $this->db->where('is_active',1);
			  $producttypedata=$this->db->get()->row();






			// unlink( $img );
			$data['data'] = true;
			$data['producttypedata'] = $producttypedata;




			echo json_encode($data);


	    }



			  	public function checkout_delete_product($idd){

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
			  	redirect("Home/checkout","refresh");

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








// order placing

public function place_order()
		{
$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	$this->load->helper('security');
	if($this->input->post())
	{
$this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean|trim');
$this->form_validation->set_rules('last_name', 'last_name', 'required|xss_clean|trim');
$this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
$this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
$this->form_validation->set_rules('country', 'country', 'required|xss_clean|trim');
$this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
$this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
$this->form_validation->set_rules('zipcode', 'zipcode', 'required|xss_clean|trim');
$this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
// $this->form_validation->set_rules('applied_promocode', 'applied_promocode', 'xss_clean|trim');


		if($this->form_validation->run()== TRUE)
		{


				 // $address_id=$this->input->post('addr_id');
				 $first_name=$this->input->post('first_name');
				 $last_name=$this->input->post('last_name');
				 $phone=$this->input->post('phone');
				 $email=$this->input->post('email');
				 $country=$this->input->post('country');
				 $state=$this->input->post('state');
				 $city=$this->input->post('city');
				 $zipcode=$this->input->post('zipcode');
				 $address=$this->input->post('address');

			// $payment_type=$this->input->post('payment_type');
			$payment_type=1	;


			// $applied_promocode=$this->input->post('applied_promocode');
			// $page=$this->input->post('page');

			$user_id = $this->session->userdata('user_id');
			$ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			$cur_date=date("Y-m-d H:i:s");

$address_id= "";
$last_id="";
//add and update address start

					$this->db->select('*');
$this->db->from('tbl_user_address');
$this->db->where('id',$user_id);
$address_data= $this->db->get()->row();

if(!empty($address_data)){

$data_update = array('user_id'=>$user_id,
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'phone'=>$phone,
					'email'=>$email,
					'country'=>$country,
					'city'=>$city,
					'state'=>$state,
					'address'=>$address,
					'zipcode'=>$zipcode,
					'ip' =>$ip,
					'date'=>$cur_date

					);

					$this->db->where('id', $address_data->id);
					$last_id=$this->db->update('tbl_user_address', $data_update);

					$address_id= $address_data->id;

}else {

$data_insert = array('user_id'=>$user_id,
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'phone'=>$phone,
					'email'=>$email,
					'country'=>$country,
					'city'=>$city,
					'state'=>$state,
					'address'=>$address,
					'zipcode'=>$zipcode,
					'ip' =>$ip,
					'date'=>$cur_date

				);


$address_id =$this->base_model->insert_table("tbl_user_address",$data_insert,1) ;

}


//add and update address end





$totalAmount= 0;




// if(!empty($applied_promocode)){
// 						$this->db->select('*');
// $this->db->from('tbl_promocode');
// $this->db->where('promo_code',$applied_promocode);
// $this->db->where('is_active', 1);
// $promocode_da= $this->db->get()->row();
//
// if(!empty($promocode_da)){
// 	$promocode_id= $promocode_da->id;
// }else{
// 	$promocode_id= "";
// }
// }else{
// $promocode_id= "";
// }



if($payment_type==1){


// if($page != 0){
// 			$this->db->select('*');
// 			$this->db->from('tbl_cart');
// 			$this->db->where('user_id',$user_id);
// 			$this->db->where('product_id',$page);
// 			$cart_da= $this->db->get();
// }else {
$this->db->select('*');
		$this->db->from('tbl_cart');
		$this->db->where('user_id',$user_id);
		$cart_da= $this->db->get();
// }



		if(!empty($cart_da)){
		 $i=1;  foreach($cart_da->result() as $data) {

				$this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('product_id',$data->product_id);
$this->db->where('unit_id',$data->unit_id);
$inv_data= $this->db->get()->row();

if(!empty($inv_data)){
$inv_id = $inv_data->id;
$db_stock= $inv_data->stock;

if($db_stock >= $data->quantity){

if($i== 1){

//tbl order1 entry
$data_insert_order1 = array('user_id'=>$user_id,
										 'total_amount'=>0,
										 'address_id'=>$address_id,
					 'payment_type'=>$payment_type,
					'payment_status'=>0,
					'order_status' =>0,
						'delivery_charge' =>0,
						'ip' =>$ip,
					'date'=>$cur_date

					);

$last_order_id= $this->base_model->insert_table("tbl_order1",$data_insert_order1, 1);
}



				$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$data->product_id);
$this->db->where('id',$data->unit_id);
$this->db->where('is_active', 1);
$type_data= $this->db->get()->row();

if(!empty($type_data)){
$selling_price= $type_data->selling_price;
$product_qty_price= $selling_price * $data->quantity;
}else{
$selling_price= 0;
$product_qty_price= 0;
}


//tbl order2 entry
$data_insert = array(
	// 'user_id'=>$user_id,
										 'unit_id'=>$data->unit_id,
										 'product_id'=>$data->product_id,
					 'quantity'=>$data->quantity,
					'amount'=>$product_qty_price,
						'main_id' =>$last_order_id,

					'date'=>$cur_date

					);


$last_id=$this->base_model->insert_table("tbl_order2",$data_insert,1) ;


//calculate total cart amount
$totalAmount= $totalAmount + $product_qty_price;


$i++;

}else{
$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$data->product_id);
$this->db->where('is_active',1);
$prodata= $this->db->get()->row();
if(!empty($prodata)){
$product_name= $prodata->product_name;
}else{
$product_name= "";
}


$this->session->set_flashdata('emessage','This product '.$product_name.' is out of stock.Please remove this product before order place.');
redirect($_SERVER['HTTP_REFERER']);
}

}else{

				$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$data->product_id);
$this->db->where('is_active',1);
$prodata= $this->db->get()->row();
if(!empty($prodata)){
$product_name= $prodata->product_name;
}else{
$product_name= "";
}


$this->session->set_flashdata('emessage','This product '.$product_name.' is out of stock.Please remove this product before order place.');
redirect($_SERVER['HTTP_REFERER']);
}



}   }






	 if($last_order_id!=0){


		 // if(!empty($applied_promocode)){
		 //
		 //
			// 							$totalAmount = $this->isValidPromocode($last_order_id,$totalAmount,$applied_promocode);
			// 					}



//update order details full information of order
		 $data_update_ordr = array('total_amount'=>$totalAmount,
											'payment_status'=>1,
											'order_status' =>1,
											// 'promocode' =>$promocode_id,

					 );

				 $this->db->where('id', $last_order_id);
					 $order =$this->db->update('tbl_order1', $data_update_ordr);






//update cart products inventory stocks
// if($page != 0){
// 			$this->db->select('*');
// 			$this->db->from('tbl_cart');
// 			$this->db->where('user_id',$user_id);
// 			$this->db->where('product_id',$page);
// 			$cart_da= $this->db->get();
// }else {
$this->db->select('*');
		$this->db->from('tbl_cart');
		$this->db->where('user_id',$user_id);
		$cart_da= $this->db->get();
// }

		if(!empty($cart_da)){
		 $k=1;  foreach($cart_da->result() as $crt_data) {

			 $this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('product_id',$crt_data->product_id);
$this->db->where('unit_id',$crt_data->unit_id);
$inv_data= $this->db->get()->row();

if(!empty($inv_data)){
$inv_id = $inv_data->id;
$db_stock= $inv_data->stock;
$update_inv=  $db_stock - $crt_data->quantity;

$data_update_inv = array(
'stock'=>$update_inv
);

	$this->db->where('id', $inv_id);
		$inventory_da=$this->db->update('tbl_inventory', $data_update_inv);

}

		 }
	 }


//delete Tbl Cart data of user

// if($page != 0){
// 			$this->db->select('*');
// 			$this->db->from('tbl_cart');
// 			$this->db->where('user_id',$user_id);
// 			$this->db->where('product_id',$page);
// 			$cart_dat= $this->db->get();
// }else {
$this->db->select('*');
		$this->db->from('tbl_cart');
		$this->db->where('user_id',$user_id);
		$cart_dat= $this->db->get();
// }


if(!empty($cart_dat)){
foreach ($cart_dat->result() as $cart) {

$del_cart=$this->db->delete('tbl_cart', array('id' => $cart->id));

}
}



//send email to user's email start
//
// $config = Array(
// 							'protocol' => 'smtp',
// 							// 'smtp_host' => 'mail.fineoutput.co.in',
// 							'smtp_host' => SMTP_HOST,
// 							'smtp_port' => 26,
// 							// 'smtp_user' => 'info@fineoutput.co.in', // change it to yours
// 							// 'smtp_pass' => 'info@fineoutput2019', // change it to yours
// 							'smtp_user' => USER_NAME, // change it to yours
// 							'smtp_pass' => PASSWORD, // change it to yours
// 							'mailtype' => 'html',
// 							'charset' => 'iso-8859-1',
// 							'wordwrap' => TRUE
// 							);
//
// 							$this->db->select('*');
// 										$this->db->from('tbl_users');
// 										$this->db->where('id',$user_id);
// 										$user_data= $this->db->get()->row();
// 					$email = '';
// 										if(!empty($user_data)){
// 											$email =  $user_data->email;
// 										}
//
// 							$to=$email;
//
// 							$email_data = array("order1_id"=>$last_order_id, "type"=>"1"
// 							);
//
// 							$message = 	$this->load->view('emails/order-success',$email_data,TRUE);
// 							// $message = 	"HELLO";
// 							$this->load->library('email', $config);
// 							$this->email->set_newline("");
// 							// $this->email->from('info@fineoutput.co.in'); // change it to yours
// 							$this->email->from(EMAIL); // change it to yours
// 							$this->email->to($to);// change it to yours
// 							$this->email->subject('Order Placed Successfully');
// 							$this->email->message($message);
// 							if($this->email->send()){
// 							//  echo 'Email sent.';
// 							}else{
// 							// show_error($this->email->print_debugger());
// 							}

//send email to user's email end




//remove cart session before login
$this->session->unset_userdata('cart_items');

	 // $this->session->set_flashdata('smessage','Register successfully');
	 redirect("Home/order_success","refresh");

	 }else{

		 $this->session->set_flashdata('emessage','Sorry error occured');
		 redirect($_SERVER['HTTP_REFERER']);


	 }


}

if($payment_type == 2){


$txnid=  substr(hash('sha256', mt_rand() . microtime()), 0, 20);


				// if($page != 0){
				// 				$this->db->select('*');
				// 				$this->db->from('tbl_cart');
				// 				$this->db->where('user_id',$user_id);
				// 				$this->db->where('product_id',$page);
				// 				$cart_da= $this->db->get();
				// }else {
					$this->db->select('*');
								$this->db->from('tbl_cart');
								$this->db->where('user_id',$user_id);
								$cart_da= $this->db->get();
				// }


				if(!empty($cart_da)){
				 $i=1;  foreach($cart_da->result() as $data) {



$this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('pid',$data->product_id);
$this->db->where('tid',$data->type_id);
// $this->db->where('is_active', 1);
$inv_data= $this->db->get()->row();



if(!empty($inv_data)){
// $inv_id = $inv_data->id;


	$inv_id = $inv_data->id;
	$db_stock= $inv_data->quantity;

	if($db_stock >= $data->quantity){

if($i== 1){

//tbl order1 entry
	$data_insert_order1 = array('user_id'=>$user_id,
												 'total_amount'=>0,
												 'address_id'=>$address_id,
							 'payment_type'=>$payment_type,
							'payment_status'=>0,
							'order_status' =>0,
								'delivery_charge' =>0,
								'ip' =>$ip,
							'date'=>$cur_date,
							'txnid'=>$txnid,
							// 'buynow_pro'=>$page,

							);

	$last_order_id= $this->base_model->insert_table("tbl_order1",$data_insert_order1, 1);
}



	$this->db->select('*');
$this->db->from('tbl_types');
$this->db->where('product',$data->product_id);
$this->db->where('id',$data->type_id);
$this->db->where('is_active', 1);
$type_data= $this->db->get()->row();


if(!empty($type_data)){
	$selling_price= $type_data->total;
	$product_qty_price= $selling_price * $data->quantity;
}else{
	$selling_price= 0;
	$product_qty_price= 0;
}


//tbl order2 entry
	$data_insert = array('user_id'=>$user_id,
												 'type_id'=>$data->type_id,
												 'product_id'=>$data->product_id,
							 'quantity'=>$data->quantity,
							'total_amount'=>$product_qty_price,
								'main_id' =>$last_order_id,

							'date'=>$cur_date

							);


$last_id=$this->base_model->insert_table("tbl_order2",$data_insert,1) ;


//calculate total cart amount
$totalAmount= $totalAmount + $product_qty_price;


 $i++;

	}else{
		$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$data->product_id);
$this->db->where('is_active',1);
$prodata= $this->db->get()->row();
if(!empty($prodata)){
$product_name= $prodata->product_name;
}else{
$product_name= "";
}


$this->session->set_flashdata('emessage','This product '.$product_name.' is out of stock.Please remove this product before order place.');
redirect($_SERVER['HTTP_REFERER']);
	}

}else{

						$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$data->product_id);
$this->db->where('is_active',1);
$prodata= $this->db->get()->row();
if(!empty($prodata)){
	$product_name= $prodata->product_name;
}else{
	$product_name= "";
}


	$this->session->set_flashdata('emessage','This product '.$product_name.' is out of stock.Please remove this product before order place.');
	redirect($_SERVER['HTTP_REFERER']);
}



 }   }






			 if($last_order_id!=0){


				 // if(!empty($applied_promocode)){
				 //
				 //
					// 							$totalAmount = $this->isValidPromocode($last_order_id,$totalAmount,$applied_promocode);
					// 					}


//payment Gateway start

					$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$user_id);
$this->db->where('is_active', 1);
$user_data= $this->db->get()->row();

if(!empty($user_data)){
$user_name= $user_data->name;
$user_email= $user_data->email;
$user_phone= $user_data->phone;
}

				$MERCHANT_KEY= MERVHANT_KEY;
				$SALT= SALT_KEY;
				// $txnid=  uniqid();

				$product_info= 'Arbour';
				$udf1= '';
				$udf2= '';
				$udf3= '';
				$udf4= '';
				$udf5= '';
				$amount_total= $totalAmount;
				$customer_name= $user_name;
				$customer_emial= $user_email;
				$customer_phone= $user_phone;
				$address= '';

				if(!empty($address_id)){
				$this->db->select('*');
				$this->db->from('tbl_user_address');
				$this->db->where('id',$address_id);
				$user_addres= $this->db->get()->row();
				if(!empty($user_addres)){

				$address= $user_addres->address;


				}
				}



				// $encoded_updated_last_id= base64_encode($updated_last_id);
				// $flag=base64_encode(1);
				// $flagf="";
				// $flagc="";

				$hashstring = $MERCHANT_KEY . '|' . $txnid . '|' . $amount_total . '|' . $product_info . '|' . $customer_name . '|' . $customer_emial . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;

				$hash = strtolower(hash('sha512', $hashstring));


				$success = base_url() . 'Home/index_payment';
				$fail = base_url() . 'Home/order_failed';
				$cancel = base_url() . 'Home/order_cancelled';


				$data = array(
				'mkey' => $MERCHANT_KEY,
				'salt' => $SALT,
				'tid' => $txnid,
				'hash' => $hash,
				'amount' => $amount_total,
				'name' => $customer_name,
				'productinfo' => $product_info,
				'mailid' => $customer_emial,
				'phoneno' => $customer_phone,
				'address' => $address,
				'action' => PAYMENT_LINK, //for live change action  https://secure.payu.in
				'sucess' => $success,
				'failure' => $fail,
				'cancel' => $cancel,
				'order_id' => $last_order_id,
				// 'promocode_id' => $promocode_id,
				);

// echo "user ".$this->session->userdata('usersid');
//
// print_r($data); exit;



				$this->load->view('frontend\confirmation',$data);



//payment Gateway end

			 // $this->session->set_flashdata('smessage','Register successfully');
			 // redirect("Home/order_success","refresh");

			 }else{

				 $this->session->set_flashdata('emessage','Sorry error occured');
				 redirect($_SERVER['HTTP_REFERER']);


			 }


}







}else{

$this->session->set_flashdata('emessage',validation_errors());
redirect($_SERVER['HTTP_REFERER']);

	}

	}
else{

$this->session->set_flashdata('emessage','Please insert some data, No data available');
redirect($_SERVER['HTTP_REFERER']);

}

}



// //--------search_bar----------------
// public function search_bar(){
//
// 					$this->load->helper( array( 'form', 'url' ) );
// 	        $this->load->library( 'form_validation' );
// 	        $this->load->helper( 'security' );
// 	        if ( $this->input->post() ) {
//
// 	            $this->form_validation->set_rules( 'keyword', 'keyword', 'xss_clean|trim' );
// 	            if ( $this->form_validation->run() == TRUE ) {
// 								      $keyword = $this->input->post( 'keyword' );
//
// 											$this->db->select('*');
// 											$this->db->from('tbl_product');
// 											$this->db->like('name',$keyword);
// 											$keyword_data= $this->db->get();
//
// 											$this->load->view('');
//
//
// 										}else{
//
// 										$this->session->set_flashdata('emessage',validation_errors());
// 										redirect($_SERVER['HTTP_REFERER']);
//
// 											}
//
// 											}
// 										else{
//
// 										$this->session->set_flashdata('emessage','Please insert some data, No data available');
// 										redirect($_SERVER['HTTP_REFERER']);
//
// 										}
//
//
//
//
// }

//-------------------search_data-----------
public function search(){

	$this->load->helper( array( 'form', 'url' ) );
	$this->load->library( 'form_validation' );
	$this->load->helper( 'security' );
	if ( $this->input->post() ) {

			$this->form_validation->set_rules( 'keyword', 'keyword', 'xss_clean|trim' );
			if ( $this->form_validation->run() == TRUE ) {
							$keyword = $this->input->post( 'keyword' );

							$this->db->select('*');
							$this->db->from('tbl_product');
							$this->db->like('name',$keyword);
							$keyword_data= $this->db->get();


										 $this->load->view('common/header',$keyword_data);
										 $this->load->view('search');
										 $this->load->view('common/footer');

						}else{

						$this->session->set_flashdata('emessage',validation_errors());
						redirect($_SERVER['HTTP_REFERER']);

							}

							}
						else{

						$this->session->set_flashdata('emessage','Please insert some data, No data available');
						redirect($_SERVER['HTTP_REFERER']);

						}




			 $this->load->view('common/header',$data);
			 $this->load->view('search');
			 $this->load->view('common/footer');


               }




}
