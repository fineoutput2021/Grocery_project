<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class HomeController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}



//category , recent category and trending category Get API

public function home_category()

{


// if(!empty($this->session->userdata('admin_data'))){
//$data= [];


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');


if($this->form_validation->run()== TRUE)
{
	$device_id=$this->input->post('device_id');
	$user_id=$this->input->post('user_id');

$orders= [];
//delivered order list
// echo  $user_id;
	$name= "";
$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',4);
$this->db->where('user_id',$user_id);
$this->db->where('order_rating',999);
$delivered_orders= $this->db->get();
$base_url=base_url();
// echo "hi";
// print_r($delivered_orders->result()); die();
if(!empty($delivered_orders)){
$i=1; foreach($delivered_orders->result() as $data) {

      			$this->db->select('*');
$this->db->from('tbl_transfer_orders');
$this->db->where('order_id',$data->id);
$delive= $this->db->get()->row();

	if(!empty($delive)){

			$this->db->select('*');
			$this->db->from('tbl_delivery_users');
			$this->db->where('id',$delive->delivery_user_id);
			$d_boy_data= $this->db->get()->row();

			if(!empty($d_boy_data)){
				$name= $d_boy_data->name;
			}else{
				$name= "";
			}

	}
				$orders[]= array (
						'order_id'=>$data->id,
					'delivery_boy_name'=>$name,

				);

}
}

//end delivered order list


$this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$this->db->order_by('sort_id',"ASC");
$categories= $this->db->limit(9)->get();
$base_url=base_url();

$i=1; foreach($categories->result() as $data) {

				$category[]= array (
						'id'=>$data->id,
					'name'=>$data->name,
					'image'=>$base_url.$data->image,
					'app_image'=>$base_url.$data->app_image,
					'short_desc'=>"",
					'long_desc'=>"",
					'sort_id'=>$data->sort_id,
					'is_active'=>$data->is_active,
					'url'=>"",
					'subtext1'=>$data->subtext1,
					'subtext2'=>$data->subtext2,
				);







}


//Festival app products data
$festival_offer_products= [];
$types_da= [];
$this->db->select('*');
$this->db->from('tbl_offer_products');
// $this->db->order_by('rand()');
// $this->db->limit(10);
//$this->db->where('id',$usr);
//$this->db->order_by('id', 'RANDOM');
$offer_product= $this->db->get();

if(!empty($offer_product)){

$i=1; foreach($offer_product->result() as $datas) {

      			$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',$datas->product_id);
$this->db->where('is_active', 1);
$this->db->where('is_cat_delete', 0);
$this->db->where('is_subcat_delete', 0);
$this->db->order_by('id', 'DESC');
$data= $this->db->get()->row();

if(!empty($data)){

			$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$data->id);
$this->db->where('is_active', 1);
$type_data= $this->db->get();
// print_r($type_data->result()); die();
if(!empty($type_data)){
foreach ($type_data->result() as $type) {

// 	$this->db->select('*');
// $this->db->from('tbl_units');
// $this->db->where('id',$type->unit_id);
// $this->db->where('is_active', 1);
// $ptoduct_unit_data= $this->db->get()->row();

if(!empty($type->unit_id)){

	$unit_name= $type->unit_id;
}else{
	$unit_name="";
}


//get percent off avarage
$typeMRP= $type->mrp;
$typeSelling= $type->selling_price;

$dif= $typeMRP - $typeSelling;

$avg_off = $dif * 100/$typeMRP;
$percent_off = round($avg_off);



$types_da[]= array(
'type_id'=>$type->id,
'unit_id'=>$type->id,
'type_name'=>$unit_name,
'type_category_id'=>"",
'type_product_id'=>$type->product_id,
'type_mrp'=>$type->mrp,
'gst_percentage'=>"",
'gst_percentage_price'=>"",
'selling_price'=>$type->selling_price,
'type_weight'=>"",
'type_rate'=>"",
'type_ratio'=>$type->ratio,
'percent_off'=>$percent_off


);



}
}
else{
$types_da[]= [];
}



//check and send data from cart table
if(empty($user_id)){

	$this->db->select('*');
	$this->db->from('tbl_cart');
	//$this->db->where('product_id',$seller_product->id);
	$this->db->where('device_id',$device_id);
	$this->db->where('product_id',$data->id);
	 $cart_data= $this->db->get()->row();





		if(!empty($cart_data)){

			$this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();
if(!empty($product_unit_data)){
			$cart_pro_unit_id= $product_unit_data->id;
			$cart_type_id= $cart_data->unit_id;
			$cart_type_price= $product_unit_data->selling_price;
			$cart_quantity= $cart_data->quantity;
			$cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			$cart_status= "1";
}else{

	$cart_pro_unit_id="";
	$cart_type_id= "";
	$cart_type_price= "";
	$cart_quantity= "";
	$cart_total_price= "";
	$cart_status= "0";
}

		}else{
			$cart_pro_unit_id="";
			$cart_type_id= "";
			$cart_type_price= "";
			$cart_quantity= "";
			$cart_total_price= "";
			$cart_status= "0";
		}


	}else{

		$this->db->select('*');
	 $this->db->from('tbl_cart');
	 //$this->db->where('product_id',$seller_product->id);
	 $this->db->where('user_id',$user_id);
	 $this->db->where('product_id',$data->id);
		$cart_data= $this->db->get()->row();

// echo $data->id;
// print_r($cart_data); die();



		 if(!empty($cart_data)){

			 $this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();

if(!empty($product_unit_data)){
				$cart_pro_unit_id= $product_unit_data->id;
			 $cart_type_id= $cart_data->unit_id;
			 $cart_type_price= $product_unit_data->selling_price;
			 $cart_quantity= $cart_data->quantity;
			 $cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			 $cart_status= "1";
		 }else{

		 	$cart_pro_unit_id="";
		 	$cart_type_id= "";
		 	$cart_type_price= "";
		 	$cart_quantity= "";
		 	$cart_total_price= "";
		 	$cart_status= "0";
		 }

		 }else{

			 $cart_pro_unit_id="";
			 $cart_type_id= "";
			 $cart_type_price= "";
			 $cart_quantity= "";
			 $cart_total_price= "";
			 $cart_status= "0";
		 }


	}





//wishlist status check


// if(empty($user_id)){
//
// //without Login
//
// $this->db->select('*');
// $this->db->from('tbl_wishlist');
// //$this->db->where('product_id',$seller_product->id);
// $this->db->where('device_id',$device_id);
// $this->db->where('product_id',$data->id);
// // $this->db->where('email',$email);
//  $wish_data= $this->db->get()->row();
//
//  if(!empty($wish_data)){
// 	 $wish_status= 1;
// }else{
// 	$wish_status= 0;
// }
//
// }else{
//
// //with Login
//
// 	$this->db->select('*');
// 	$this->db->from('tbl_wishlist');
// 	//$this->db->where('product_id',$seller_product->id);
// 	$this->db->where('user_id',$user_id);
// 	$this->db->where('product_id',$data->id);
// 	// $this->db->where('email',$email);
// 	 $wish_data= $this->db->get()->row();
//
// 	 if(!empty($wish_data)){
// 		 $wish_status= 1;
// 	}else{
// 		$wish_status= 0;
// 	}
//
// }

//End wishlist status check


if(!empty($data->app_image1)){
	$app_image_1= $base_url.$data->app_image1;
}else{
	$app_image_1= "";
}

if(!empty($data->app_image2)){
	$app_image_2= $base_url.$data->app_image2;
}else{
	$app_image_2= "";
}

if(!empty($data->app_image3)){
	$app_image_3= $base_url.$data->app_image3;
}else{
	$app_image_3= "";
}

if(!empty($data->app_image4)){
	$app_image_4= $base_url.$data->app_image4;
}else{
	$app_image_4= "";
}

if(!empty($data->app_main_image)){
	$app_mains_image= $base_url.$data->app_main_image;
}else{
	$app_mains_image= "";
}

$festival_offer_products[]= array  (
	'id'=>$data->id,
	'category_id'=>$data->category_id,
	'name'=>$data->name,
	'long_desc'=>$data->long_description,
	'short_desc'=>$data->short_description,
	'cart_pro_unit_id'=>$cart_pro_unit_id,
	'cart_type_id'=> $cart_type_id,
	'cart_type_price'=> $cart_type_price,
	'cart_quantity'=> $cart_quantity,
	'cart_total_price'=> $cart_total_price,
	'cart_status'=> $cart_status,
	'wish_status'=>"",
	'image1'=>$app_image_1,
	'image2'=>$app_image_2,
	'image3'=>$app_image_3,
	'image4'=>$app_image_4,
	'app_main_image'=>$app_mains_image,
	'app_image'=>$base_url.$data->app_pro_image,
	'product_unit_type'=>$data->product_unit_type,
	'is_cat_delete'=>$data->is_cat_delete,
	'is_active'=>$data->is_active,
	'url'=>"",
'type'=>$types_da
);
$types_da= [];
// print_r($trending)

}

	}
}

//End Festival app products data





$types= [];
$trending=[];

      			$this->db->select('*');
$this->db->from('tbl_trending_products');
//$this->db->where('id',$usr);
$trendings= $this->db->get();



if(!empty($trendings)){
$i=1; foreach($trendings->result() as $trendng) {


	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('id',$trendng->product_id);
	$this->db->where('is_active',1);
	$this->db->where('is_cat_delete',0);
	$this->db->where('is_subcat_delete',0);
	//$this->db->where('id',$usr);
	//$this->db->order_by('id', 'RANDOM');
	$data= $this->db->get()->row();

if(!empty($data)){
			$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$data->id);
$this->db->where('is_active',1);
$type_data= $this->db->get();
// print_r($type_data->result()); die();
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


//get percent off avarage
$typeMRP= $type->mrp;
$typeSelling= $type->selling_price;

$dif= $typeMRP - $typeSelling;

$avg_off = $dif * 100/$typeMRP;
$percent_off = round($avg_off);



$types[]= array(
'type_id'=>$type->id,
'unit_id'=>$type->unit_id,
'type_name'=>$type->unit_id,
'type_category_id'=>"",
'type_product_id'=>$type->product_id,
'type_mrp'=>$type->mrp,
'gst_percentage'=>"",
'gst_percentage_price'=>"",
'selling_price'=>$type->selling_price,
'type_weight'=>"",
'type_rate'=>"",
'type_ratio'=>$type->ratio,
'percent_off'=>$percent_off


);



}
}
else{
$types[]= [];
}



//check and send data from cart table
if(empty($user_id)){

	$this->db->select('*');
	$this->db->from('tbl_cart');
	//$this->db->where('product_id',$seller_product->id);
	$this->db->where('device_id',$device_id);
	$this->db->where('product_id',$data->id);
	 $cart_data= $this->db->get()->row();





		if(!empty($cart_data)){

			$this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();
if(!empty($product_unit_data)){
			$cart_pro_unit_id= $product_unit_data->id;
			$cart_type_id=$cart_data->unit_id;
			$cart_type_price= $product_unit_data->selling_price;
			$cart_quantity= $cart_data->quantity;
			$cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			$cart_status= "1";
}else{

	$cart_pro_unit_id="";
	$cart_type_id= "";
	$cart_type_price= "";
	$cart_quantity= "";
	$cart_total_price= "";
	$cart_status= "0";
}

		}else{
			$cart_pro_unit_id="";
			$cart_type_id= "";
			$cart_type_price= "";
			$cart_quantity= "";
			$cart_total_price= "";
			$cart_status= "0";
		}


	}else{

		$this->db->select('*');
	 $this->db->from('tbl_cart');
	 //$this->db->where('product_id',$seller_product->id);
	 $this->db->where('user_id',$user_id);
	 $this->db->where('product_id',$data->id);
		$cart_data= $this->db->get()->row();

// echo $data->id;
// print_r($cart_data); die();



		 if(!empty($cart_data)){

			 $this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();

if(!empty($product_unit_data)){
				$cart_pro_unit_id= $product_unit_data->id;
			 $cart_type_id= $cart_data->unit_id;
			 $cart_type_price= $product_unit_data->selling_price;
			 $cart_quantity= $cart_data->quantity;
			 $cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			 $cart_status= "1";
		 }else{

		 	$cart_pro_unit_id="";
		 	$cart_type_id= "";
		 	$cart_type_price= "";
		 	$cart_quantity= "";
		 	$cart_total_price= "";
		 	$cart_status= "0";
		 }

		 }else{

			 $cart_pro_unit_id="";
			 $cart_type_id= "";
			 $cart_type_price= "";
			 $cart_quantity= "";
			 $cart_total_price= "";
			 $cart_status= "0";
		 }


	}





//wishlist status check


// if(empty($user_id)){
//
// //without Login
//
// $this->db->select('*');
// $this->db->from('tbl_wishlist');
// //$this->db->where('product_id',$seller_product->id);
// $this->db->where('device_id',$device_id);
// $this->db->where('product_id',$data->id);
// // $this->db->where('email',$email);
//  $wish_data= $this->db->get()->row();
//
//  if(!empty($wish_data)){
// 	 $wish_status= 1;
// }else{
// 	$wish_status= 0;
// }
//
// }else{
//
// //with Login
//
// 	$this->db->select('*');
// 	$this->db->from('tbl_wishlist');
// 	//$this->db->where('product_id',$seller_product->id);
// 	$this->db->where('user_id',$user_id);
// 	$this->db->where('product_id',$data->id);
// 	// $this->db->where('email',$email);
// 	 $wish_data= $this->db->get()->row();
//
// 	 if(!empty($wish_data)){
// 		 $wish_status= 1;
// 	}else{
// 		$wish_status= 0;
// 	}
//
// }

//End wishlist status check

if(!empty($data->app_image1)){
	$app_image_1= $base_url.$data->app_image1;
}else{
	$app_image_1= "";
}

if(!empty($data->app_image2)){
	$app_image_2= $base_url.$data->app_image2;
}else{
	$app_image_2= "";
}

if(!empty($data->app_image3)){
	$app_image_3= $base_url.$data->app_image3;
}else{
	$app_image_3= "";
}

if(!empty($data->app_image4)){
	$app_image_4= $base_url.$data->app_image4;
}else{
	$app_image_4= "";
}

if(!empty($data->app_main_image)){
	$app_mains_image= $base_url.$data->app_main_image;
}else{
	$app_mains_image= "";
}


$trending[]= array  (
	'id'=>$data->id,
	'category_id'=>$data->category_id,
	'name'=>$data->name,
	'long_desc'=>$data->long_description,
	'short_desc'=>$data->short_description,
	'cart_pro_unit_id'=>$cart_pro_unit_id,
	'cart_type_id'=> $cart_type_id,
	'cart_type_price'=> $cart_type_price,
	'cart_quantity'=> $cart_quantity,
	'cart_total_price'=> $cart_total_price,
	'cart_status'=> $cart_status,
	'wish_status'=>"",
	'image1'=>$app_image_1,
	'image2'=>$app_image_2,
	'image3'=>$app_image_3,
	'image4'=>$app_image_4,
	'app_main_image'=>$app_mains_image,
	'app_image'=>$base_url.$data->app_pro_image,
	'product_unit_type'=>$data->product_unit_type,
	'is_cat_delete'=>$data->is_cat_delete,
	'is_active'=>$data->is_active,
	'url'=>"",
'type'=>$types
);
$types= [];
// print_r($trending)

}
	}
}


$typedata= [];
$recent= [];
$this->db->select('*');
$this->db->from('tbl_recent_products');
$recents= $this->db->get();

if(!empty($recents)){

$i=1; foreach($recents->result() as $rcnts) {

	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where("id", $rcnts->product_id);
	$this->db->where('is_active',1);
	$this->db->where('is_cat_delete',0);
	$this->db->where('is_subcat_delete',0);
	$data= $this->db->get()->row();

if(!empty($data)){

$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$data->id);
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



//get percent off avarage
$typeMRP= $type->mrp;
$typeSelling= $type->selling_price;

$dif= $typeMRP - $typeSelling;

$avg_off = $dif * 100/$typeMRP;
$percent_off = round($avg_off);


$typedata[]= array(
	'type_id'=>$type->id,
	'unit_id'=>$type->id,
	'type_name'=>$unit_name,
	'type_category_id'=>"",
	'type_product_id'=>$type->product_id,
	'type_mrp'=>$type->mrp,
	'gst_percentage'=>"",
	'gst_percentage_price'=>"",
	'selling_price'=>$type->selling_price,
	'type_weight'=>"",
	'type_rate'=>"",
	'type_ratio'=>$type->ratio,
	'percent_off'=>$percent_off
);

}
}else{
$typedata[]= [];
}



//check and send data from cart table
if(empty($user_id)){

	$this->db->select('*');
	$this->db->from('tbl_cart');
	//$this->db->where('product_id',$seller_product->id);
	$this->db->where('device_id',$device_id);
	$this->db->where('product_id',$data->id);
	 $cart_data= $this->db->get()->row();





		if(!empty($cart_data)){

			$this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();

if(!empty($product_unit_data)){

			$cart_pro_unit_id= $product_unit_data->id;
			$cart_type_id= $cart_data->unit_id;
			$cart_type_price= $product_unit_data->selling_price;
			$cart_quantity= $cart_data->quantity;
			$cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			$cart_status= "1";
		}else{

	 	$cart_pro_unit_id="";
	 	$cart_type_id= "";
	 	$cart_type_price= "";
	 	$cart_quantity= "";
	 	$cart_total_price= "";
	 	$cart_status= "0";
	  }

		}else{
			$cart_pro_unit_id="";
			$cart_type_id= "";
			$cart_type_price= "";
			$cart_quantity= "";
			$cart_total_price= "";
			$cart_status= "0";
		}


	}else{

		$this->db->select('*');
	 $this->db->from('tbl_cart');
	 //$this->db->where('product_id',$seller_product->id);
	 $this->db->where('user_id',$user_id);
	 $this->db->where('product_id',$data->id);
		$cart_data= $this->db->get()->row();

// echo $data->id;
// print_r($cart_data); die();



		 if(!empty($cart_data)){

			 $this->db->select('*');
			$this->db->from('tbl_product_units');
			$this->db->where('product_id',$cart_data->product_id);
			$this->db->where('id',$cart_data->unit_id);
			$product_unit_data= $this->db->get()->row();

if(!empty($product_unit_data)){
				$cart_pro_unit_id= $product_unit_data->id;
			 $cart_type_id= $cart_data->unit_id;
			 $cart_type_price= $product_unit_data->selling_price;
			 $cart_quantity= $cart_data->quantity;
			 $cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
			 $cart_status= "1";

		 }else{

			$cart_pro_unit_id="";
			$cart_type_id= "";
			$cart_type_price= "";
			$cart_quantity= "";
			$cart_total_price= "";
			$cart_status= "0";
		 }


		 }else{

			 $cart_pro_unit_id="";
			 $cart_type_id= "";
			 $cart_type_price= "";
			 $cart_quantity= "";
			 $cart_total_price= "";
			 $cart_status= "0";
		 }


	}




//wishlist status check


// if(empty($user_id)){
//
// //without Login
//
// $this->db->select('*');
// $this->db->from('tbl_wishlist');
// //$this->db->where('product_id',$seller_product->id);
// $this->db->where('device_id',$device_id);
// $this->db->where('product_id',$data->id);
// // $this->db->where('email',$email);
//  $wish_data= $this->db->get()->row();
//
//  if(!empty($wish_data)){
// 	 $wish_status= 1;
// }else{
// 	$wish_status= 0;
// }
//
// }else{
//
// //with Login
//
// 	$this->db->select('*');
// 	$this->db->from('tbl_wishlist');
// 	//$this->db->where('product_id',$seller_product->id);
// 	$this->db->where('user_id',$user_id);
// 	$this->db->where('product_id',$data->id);
// 	// $this->db->where('email',$email);
// 	 $wish_data= $this->db->get()->row();
//
// 	 if(!empty($wish_data)){
// 		 $wish_status= 1;
// 	}else{
// 		$wish_status= 0;
// 	}
//
// }

//End wishlist status check


if(!empty($data->app_image1)){
	$app_image_1= $base_url.$data->app_image1;
}else{
	$app_image_1= "";
}

if(!empty($data->app_image2)){
	$app_image_2= $base_url.$data->app_image2;
}else{
	$app_image_2= "";
}

if(!empty($data->app_image3)){
	$app_image_3= $base_url.$data->app_image3;
}else{
	$app_image_3= "";
}

if(!empty($data->app_image4)){
	$app_image_4= $base_url.$data->app_image4;
}else{
	$app_image_4= "";
}

if(!empty($data->app_main_image)){
	$app_mains_image= $base_url.$data->app_main_image;
}else{
	$app_mains_image= "";
}


$recent[]=  array (
	'id'=>$data->id,
	'category_id'=>$data->category_id,
'name'=>$data->name,
'long_desc'=>$data->long_description,
'short_desc'=>$data->short_description,
'cart_pro_unit_id'=>$cart_pro_unit_id,
'cart_type_id'=> $cart_type_id,
'cart_type_price'=> $cart_type_price,
'cart_quantity'=> $cart_quantity,
'cart_total_price'=> $cart_total_price,
'cart_status'=> $cart_status,
'wish_status'=>"",
'image1'=>$app_image_1,
'image2'=>$app_image_2,
'image3'=>$app_image_3,
'image4'=>$app_image_4,
'app_main_image'=>$app_mains_image,
'app_image'=>$base_url.$data->app_pro_image,
'product_unit_type'=>$data->product_unit_type,
'is_cat_delete'=>$data->is_cat_delete,
'is_active'=>$data->is_active,
'url'=>"",
'type'=>$typedata
);

$typedata= [];

}
}

}




//get both sliders of oswal

//app slider1
$this->db->select('*');
$this->db->from('tbl_app_slider1');
//$this->db->where('email',$email);
$offers_slider_data= $this->db->get();

// print_r($offers_data->result());
$offersfirst5= [];
if(!empty($offers_slider_data)){
foreach ($offers_slider_data->result() as  $offer) {
 $offersfirst5[]=array(
   'id'=> $offer->id,
   'offer_name'=> $offer->name,
   'category'=> "",
   'subcategory'=> "",

   'image'=>$base_url.$offer->image,
	 'device_type'=> "",
	 'link'=> "",
 );
}
}


// app slider2 data

$this->db->select('*');
$this->db->from('tbl_app_slider2');
//$this->db->where('email',$email);
$offers_slider2_data= $this->db->get();

$offersNext5= [];
// print_r($offers_n_data->result()); die();
if(!empty($offers_slider_data)){
foreach ($offers_slider2_data->result() as  $offerN) {
 $offersNext5[]=array(
   'id'=> $offerN->id,
   'offer_name'=> $offerN->name,
	 'category'=> "",
	 'subcategory'=> "",

   'image'=>$base_url.$offerN->image,
	 'device_type'=> "",
	 'link'=> "",
 );
}

}


// web slider1 data
//
// $this->db->select('*');
// $this->db->from('tbl_sliders');
// //$this->db->where('email',$email);
// $offers_slider_data= $this->db->get();
//
// // print_r($offers_data->result());
//
// if(!empty($offers_slider_data)){
// foreach ($offers_slider_data->result() as  $offer) {
//  $offersfirst5[]=array(
//    'id'=> $offer->id,
//    'offer_name'=> $offer->image_name,
//    'category'=> $offer->category,
//    'subcategory'=> $offer->subcategory,
//
//    'image'=>$base_url."assets/admin/all_img/slider_images/".$offer->image,
// 	 'device_type'=> $offer->device_type,
// 	 'link'=> $offer->link,
//  );
// }
// }else{
// 	$offersfirst5[]= [];
// }


// web slider2 data
//
// $this->db->select('*');
// $this->db->from('tbl_sliders2');
// //$this->db->where('email',$email);
// $offers_slider2_data= $this->db->get();
//
// // print_r($offers_n_data->result()); die();
// if(!empty($offers_slider_data)){
// foreach ($offers_slider2_data->result() as  $offerN) {
//  $offersNext5[]=array(
//    'id'=> $offerN->id,
//    'offer_name'=> $offerN->image_name,
// 	 'category'=> $offerN->category,
// 	 'subcategory'=> $offer->subcategory,
//
//    'image'=>$base_url."assets/admin/all_img/slider_images/".$offerN->image,
// 	 'device_type'=> $offerN->device_type,
// 	 'link'=> $offerN->link,
//  );
// }
//
// }else{
// 	$offersNext5[]= [];
// }




//AppSliders data
$this->db->select('*');
$this->db->from('tbl_appslider');
//$this->db->where('email',$email);
$app_slider_data= $this->db->get();

// print_r($offers_n_data->result()); die();
if(!empty($app_slider_data)){
foreach ($app_slider_data->result() as  $appslide) {
 $app_sliders[]=array(
   'id'=> $appslide->id,
   'image_name'=> $appslide->image_name,

   'image'=>$base_url."assets/admin/all_img/app_slider_images/".$appslide->image,
	 'link'=> $appslide->link,
 );
}

}else{
	$app_sliders[]= [];
}


//App HOme Images

//App Home Image1
$this->db->select('*');
$this->db->from('tbl_home_image1');
$this->db->order_by('is_active',1);
$this->db->order_by('id',"Desc");
$app_home_image1_data= $this->db->get()->row();

// print_r($offers_n_data->result()); die();
if(!empty($app_home_image1_data)){
$main_image1= $base_url.$app_home_image1_data->image;

}else{
	$main_image1= "";
}



//App Home Image2
$this->db->select('*');
$this->db->from('tbl_home_image2');
$this->db->order_by('is_active',1);
$this->db->order_by('id',"Desc");
$app_home_image2_data= $this->db->get()->row();

// print_r($offers_n_data->result()); die();
if(!empty($app_home_image2_data)){
$main_image2= $base_url.$app_home_image2_data->image;

}else{
	$main_image2= "";
}

//App Home Image3
$this->db->select('*');
$this->db->from('tbl_home_image3');
$this->db->order_by('is_active',1);
$this->db->order_by('id',"Desc");
$app_home_image3_data= $this->db->get()->row();

// print_r($offers_n_data->result()); die();
if(!empty($app_home_image3_data)){
$main_image3= $base_url.$app_home_image3_data->image;

}else{
	$main_image3= "";
}

// $main_image1= $base_url."assets/frontend/au_mobile/DIWALIFEST.jpg";
// $main_image2= $base_url."assets/frontend/au_mobile/FESTIVE.jpg";
// $main_image3= $base_url."assets/frontend/au_mobile/BACKLIGHT.jpg";

// echo $base_url; die();

$data= array (
'image1'=>$main_image1,
'image2'=>$main_image2,
'image3'=>$main_image3,
'categories'=>$category,
'trending'=>$trending,
'recent'=>$recent,
'offersfirst5'=>$offersfirst5,
'offersNext5'=>$offersNext5,
'app_sliders'=>$app_sliders,
'festival_products'=>$festival_offer_products,
'orders'=>$orders

);




$res = array('message'=>"success",
'status'=>200,
'data'=> $data,
);

echo json_encode($res);




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

//     }
//     else{
//
// redirect("login/admin_login","refresh");
//
//
//     }

}



//Get Profile Data API FOR User
public function get_user_profile(){


		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		if($this->input->post())
		{

				$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
				$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');

				if($this->form_validation->run()== TRUE)
				{

	      $device_id=$this->input->post('device_id');
				$user_id=$this->input->post('user_id');


								 $this->db->select('*');
								$this->db->from('tbl_users');
								$this->db->where('id',$user_id);
								$user_profile_data= $this->db->get();

							if(!empty($user_profile_data)){
								foreach ($user_profile_data->result() as  $user) {
									$data=array(
										'id'=>$user->id,
										'name'=>$user->first_name,
										'lastname'=>$user->last_name,
										'device_id'=>$device_id,
														'email'=>$user->email,
														'password'=>$user->password,
														'contact'=>$user->contact,
														'wallet'=>$user->wallet
									);

										$res = array('message'=>"Success",
													'status'=>200,
													'data'=>$data

													);

								}

							}else{
								$res = array('message'=>"Invalid User.",
											'status'=>201

											);
							}



								echo json_encode($res); exit;



				}else{

				$res = array('message'=>validation_errors(),
				        'status'=>201
				        );

				echo json_encode($res);


				}

		}else{
		$res = array('message'=>'Please insert some data, No data available',
		      'status'=>201
		      );

		echo json_encode($res);


		}


}




//edit profile

public function edit_profile()
{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
$this->form_validation->set_rules('first_name', 'first_name', 'xss_clean');
$this->form_validation->set_rules('last_name', 'last_name', 'xss_clean');

$this->form_validation->set_rules('email', 'email', 'valid_email|xss_clean');
$this->form_validation->set_rules('password', 'password', 'xss_clean');
$this->form_validation->set_rules('phone', 'phone', 'xss_clean');


if($this->form_validation->run()== TRUE)
{

$device_id=$this->input->post('device_id');
$user_id=$this->input->post('user_id');
$first_name=$this->input->post('first_name');
$last_name=$this->input->post('last_name');
$email=$this->input->post('email');
$passw=$this->input->post('password');
$phone_number=$this->input->post('phone');

// $passw= md5($password);

	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");

	$this->db->select('*');
	$this->db->from('tbl_users');
	$this->db->where('id',$user_id);
	// $device_cart_data= $this->db->get()->row();
	$user_datas= $this->db->get()->row();

if(!empty($user_datas)){


	if($user_datas->email == $email){

				if($user_datas->contact == $phone_number){

				$data_update = array('first_name'=>$first_name,
															'last_name'=>$last_name,
														 'device_id'=>$device_id,

						'email'=>$email,
						// 'password'=>md5($passw),
						'contact'=>$phone_number,

						// 'ip' =>$ip,

						// 'is_active' =>1,
						// 'date'=>$cur_date

						);





						$this->db->where('id',$user_id);
						$last_id=$this->db->update('tbl_users', $data_update);

					} else{

						$this->db->select('*');
						$this->db->from('tbl_users');
						$this->db->where('contact',$phone_number);
						// $device_cart_data= $this->db->get()->row();
						$user_cont= $this->db->get()->row();

						if(empty($user_cont)){



						$data_update = array(
															'first_name'=>$first_name,
															'last_name'=>$last_name,
														 'device_id'=>$device_id,

						'email'=>$email,
						// 'password'=>md5($passw),
						'contact'=>$phone_number,

						// 'ip' =>$ip,

						// 'is_active' =>1,
						// 'date'=>$cur_date

						);





						$this->db->where('id',$user_id);
						$last_id=$this->db->update('tbl_users', $data_update);

					}else{

						$res = array('message'=>"Contact Number already exist.",
						'status'=>201
						);

						echo json_encode($res); exit;

					}


					}

	}else{


				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->where('email',$email);
				// $device_cart_data= $this->db->get()->row();
				$user_eml= $this->db->get()->row();

				if(empty($user_eml)){



		$data_update = array('first_name'=>$first_name,
													'last_name'=>$last_name,
												 'device_id'=>$device_id,

				'email'=>$email,
				// 'password'=>md5($passw),
				'contact'=>$phone_number,

				// 'ip' =>$ip,

				// 'is_active' =>1,
				// 'date'=>$cur_date

				);





				$this->db->where('id',$user_id);
				$last_id=$this->db->update('tbl_users', $data_update);

			}else{

				$res = array('message'=>"Email already exist.",
				'status'=>201
				);

				echo json_encode($res); exit;

			}



	}

if($last_id!=0)
{


					$this->db->select('*');
					$this->db->from('tbl_users');
					$this->db->where('id',$user_id);
					// $this->db->where('mac_id',$mac_id);
					$user_data= $this->db->get()->row();

if(!empty($user_data->first_name)){
	$first_name = $user_data->first_name;
}else{
	$first_name = "";
}

if(!empty($user_data->first_name)){
	$last_name = $user_data->last_name;
}else{
	$last_name = "";
}

if(!empty($user_data->first_name)){
	$email = $user_data->email;
}else{
	$email = "";
}



					$data= array (
						'id'=>$user_data->id,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						'device_id'=>$device_id,
										'email'=>$email,
										'password'=>$user_data->password,
										'contact'=>$user_data->contact,

					);



$res = array('message'=>"success",
'status'=>200,
'data'=>$data

);

echo json_encode($res); exit;

}

else
{
$res = array('message'=>"failed",
'status'=>201
);

echo json_encode($res); exit;
}


}else{

	$res = array('message'=>"User not Found!",
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






//Search Api for Oswal app

// public function search_data()

public function search_data()

{
  // if(!empty($this->session->userdata('admin_data'))){


  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
  $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');



  if($this->form_validation->run()== TRUE)
  {

  $device_id=$this->input->post('device_id');
  $user_id=$this->input->post('user_id');


$products=[];
$typedata= [];
  $this->db->select('*');
  $this->db->from('tbl_product');
	$this->db->where('is_active', 1);
	$this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
  $products_da= $this->db->get();
  $base_url=base_url();

if(!empty($products_da)){
  $i=1; foreach($products_da->result() as $data) {

  $this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$data->id);
	$this->db->where('is_active',1);
  $type_data= $this->db->get();


  if(!empty($type_data)){
  foreach ($type_data->result() as $type) {

		//get percent off avarage
		$typeMRP= $type->mrp;
		$typeSelling= $type->selling_price;

		$dif= $typeMRP - $typeSelling;

		$avg_off = $dif * 100/$typeMRP;
		$percent_off = round($avg_off);


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
  	// 'type_id'=>$type->id,
  	// 'type_name'=>$type->type_name,
  	// 'type_category_id'=>$type->category_id,
  	// 'type_product_id'=>$type->product_id,
  	// 'type_mrp'=>$type->mrp,
  	// 'gst_percentage'=>$type->gst_percentage,
  	// 'gst_percentage_price'=>$type->gst_percentage_price,
  	// 'selling_price'=>$type->selling_price,
  	// 'type_weight'=>$type->weight,
  	// 'type_rate'=>$type->rate,




		'type_id'=>$type->id,
		'unit_id'=>$type->id,
		'type_name'=>$unit_name,
		'type_category_id'=>"",
		'type_product_id'=>$type->product_id,
		'type_mrp'=>$type->mrp,
		'gst_percentage'=>"",
		'gst_percentage_price'=>"",
		'selling_price'=>$type->selling_price,
		'type_weight'=>"",
		'type_rate'=>"",
		'type_ratio'=>$type->ratio,
		'percent_off'=>$percent_off
  );

  }
  }else{
  $typedata[]= [];
  }

//wishlist status check

// if(empty($user_id)){
//
// //without Login
//
// $this->db->select('*');
// $this->db->from('tbl_wishlist');
// //$this->db->where('product_id',$seller_product->id);
// $this->db->where('device_id',$device_id);
// $this->db->where('product_id',$data->id);
// // $this->db->where('email',$email);
//  $wish_data= $this->db->get()->row();
//
//  if(!empty($wish_data)){
// 	 $wish_status= 1;
// }else{
// 	$wish_status= 0;
// }
//
// }else{
//
// //with Login
//
// 	$this->db->select('*');
// 	$this->db->from('tbl_wishlist');
// 	//$this->db->where('product_id',$seller_product->id);
// 	$this->db->where('user_id',$user_id);
// 	$this->db->where('product_id',$data->id);
// 	// $this->db->where('email',$email);
// 	 $wish_data= $this->db->get()->row();
//
// 	 if(!empty($wish_data)){
// 		 $wish_status= 1;
// 	}else{
// 		$wish_status= 0;
// 	}
//
// }


	//check and send data from cart table


if(empty($user_id)){

	  $this->db->select('*');
	  $this->db->from('tbl_cart');
	  //$this->db->where('product_id',$seller_product->id);
	  $this->db->where('device_id',$device_id);
	  $this->db->where('product_id',$data->id);
	   $cart_data= $this->db->get()->row();





	    if(!empty($cart_data)){

				$this->db->select('*');
				$this->db->from('tbl_product_units');
				$this->db->where('product_id',$cart_data->product_id);
				$this->db->where('id',$cart_data->unit_id);
				$product_unit_data= $this->db->get()->row();

				$cart_pro_unit_id= $product_unit_data->id;
	      $cart_type_id= $cart_data->unit_id;
	      $cart_type_price= $product_unit_data->selling_price;
	      $cart_quantity= $cart_data->quantity;
	      $cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
	      $cart_status= 1;

	    }else{
				$cart_pro_unit_id="";
	      $cart_type_id= "";
	      $cart_type_price= "";
	      $cart_quantity= "";
	      $cart_total_price= "";
	      $cart_status= 0;
	    }


	  }else{

			$this->db->select('*');
		 $this->db->from('tbl_cart');
		 //$this->db->where('product_id',$seller_product->id);
		 $this->db->where('user_id',$user_id);
		 $this->db->where('product_id',$data->id);
			$cart_data= $this->db->get()->row();

// echo $data->id;
// print_r($cart_data); die();



			 if(!empty($cart_data)){

				 $this->db->select('*');
			 	$this->db->from('tbl_product_units');
			 	$this->db->where('product_id',$cart_data->product_id);
			 	$this->db->where('id',$cart_data->unit_id);
			 	$product_unit_data= $this->db->get()->row();

				 	$cart_pro_unit_id= $product_unit_data->id;
				 $cart_type_id= $cart_data->unit_id;
				 $cart_type_price= $product_unit_data->selling_price;
				 $cart_quantity= $cart_data->quantity;
				 $cart_total_price= $cart_data->quantity * $product_unit_data->selling_price;
				 $cart_status= 1;

			 }else{

				 $cart_pro_unit_id="";
				 $cart_type_id= "";
				 $cart_type_price= "";
				 $cart_quantity= "";
				 $cart_total_price= "";
				 $cart_status= 0;
			 }


		}






		if(!empty($data->app_image1)){
			$app_image_1= $base_url.$data->app_image1;
		}else{
			$app_image_1= "";
		}

		if(!empty($data->app_image2)){
			$app_image_2= $base_url.$data->app_image2;
		}else{
			$app_image_2= "";
		}

		if(!empty($data->app_image3)){
			$app_image_3= $base_url.$data->app_image3;
		}else{
			$app_image_3= "";
		}

		if(!empty($data->app_image4)){
			$app_image_4= $base_url.$data->app_image4;
		}else{
			$app_image_4= "";
		}

		if(!empty($data->app_main_image)){
			$app_mains_image= $base_url.$data->app_main_image;
		}else{
			$app_mains_image= "";
		}




  $products[]=  array (
  // 	'id'=>$data->id,
  // 	'category_id'=>$data->category_id,
  // 'name'=>$data->name,
  // 'long_desc'=>$data->long_desc,
	// 'cart_type_id'=> $cart_type_id,
	// 'cart_type_price'=> $cart_type_price,
	// 'cart_quantity'=> $cart_quantity,
	// 'cart_total_price'=> $cart_total_price,
	// 'cart_status'=> $cart_status,
	// 'wish_status'=> $wish_status,
  // 'url'=>$data->url,
  // 'image1'=>$base_url."assets/admin/products/".$data->img1,
  // 'image2'=>$base_url."assets/admin/products/".$data->img2,
  // 'image3'=>$base_url."assets/admin/products/".$data->img3,
  // 'image4'=>$base_url."assets/admin/products/".$data->img4,
  // 'is_active'=>$data->is_active,
  // 'type'=>$typedata




	'id'=>$data->id,
	'category_id'=>$data->category_id,
	'name'=>$data->name,
	'long_desc'=>$data->long_description,
	'short_desc'=>$data->short_description,
	'cart_pro_unit_id'=>$cart_pro_unit_id,
	'cart_type_id'=> $cart_type_id,
	'cart_type_price'=> $cart_type_price,
	'cart_quantity'=> $cart_quantity,
	'cart_total_price'=> $cart_total_price,
	'cart_status'=> $cart_status,
	'wish_status'=>"",
	'image1'=>$app_image_1,
	'image2'=>$app_image_2,
	'image3'=>$app_image_3,
	'image4'=>$app_image_4,
	'app_main_image'=>$app_mains_image,
	'product_unit_type'=>$data->product_unit_type,
	'is_cat_delete'=>$data->is_cat_delete,
	'is_active'=>$data->is_active,
	'url'=>"",
'type'=>$typedata


  );

  $typedata= [];

  }
}

  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $products,
  );

  echo json_encode($res); exit;




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
  //     }
  //     else{
  //
  // redirect("login/admin_login","refresh");
  //
  //
  //     }


}




//share aubasket app link

public function share_refer_app_post()

{
// echo "yes"; die();
// $this->load->helper(array('form', 'url'));
// $this->load->library('form_validation');
// $this->load->helper('security');
// if($this->input->post())
// {




// $user_id=$this->input->post('custid');
$user_id=$this->input->get('refer_user_id');
// $refer_code=$this->input->post('refer_code');
// $device_id=$this->input->post('device_id');
// $device_id=$this->input->get('device_id');

// $passw= md5($password);

	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");



	$data_insert = array(
											'user_id'=>$user_id,

						// 'device_id'=>$device_id,
						'ip'=>$ip,

						'date'=>$cur_date

						);



	$last_id=$this->base_model->insert_table("tbl_user_share_and_refer",$data_insert,1) ;




// }
// else{
// $res = array('message'=>'Please insert some data, No data available',
// 			'status'=>201
// 			);
//
// echo json_encode($res);
//
//
// }


}




}
