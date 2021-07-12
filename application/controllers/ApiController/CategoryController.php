<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class CategoryController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}




//All category Get API

public function all_category()

{

// if(!empty($this->session->userdata('admin_data'))){
//$data= [];

$this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$categories= $this->db->get();
$base_url=base_url();
$sub_cat_da= [];

if(!empty($categories)){
$i=1; foreach($categories->result() as $data) {

//get subcategory
$this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('category_id', $data->id);
$this->db->where('is_active', 1);
$this->db->where('is_cat_delete', 0);
$subcategories= $this->db->get();

if(!empty($subcategories)){
foreach ($subcategories->result() as $subcate) {



$sub_cat_da[]= array(
'id'=>$subcate->id,
'category_id'=>$subcate->category_id,
'name'=>$subcate->name,
'image'=>$base_url.$subcate->image,
'short_desc'=>"",
'long_desc'=>"",
'sort_id'=>"",
'is_active'=>$subcate->is_active,
'url'=>"",
'subtext1'=>$subcate->subtext1


);



}
}
else{
$sub_cat_da[]= [];
}





				$category[]= array (
					'id'=>$data->id,
				'name'=>$data->name,
				'image'=>$base_url.$data->image,
				'short_desc'=>"",
				'long_desc'=>"",
				'sort_id'=>$data->sort_id,
				'is_active'=>$data->is_active,
				'url'=>"",
				'subtext1'=>$data->subtext1,
				'subtext2'=>$data->subtext2,
				'sub_category'=>$sub_cat_da,
				);

$sub_cat_da= [];

}

}else{
	$category= [];
}


$res = array('message'=>"success",
'status'=>200,
'data'=> $category,
);

echo json_encode($res);


//     }
//     else{
//
// redirect("login/admin_login","refresh");
//
//
//     }

}



//All subcategory list by category_id Get API

public function subcategory()
{


  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean');


  if($this->form_validation->run()== TRUE)
  {

  $subcategory_id=$this->input->post('subcategory_id');



$subcategory2_data=[];
$base_url=base_url();




	//get subcategory2
	$this->db->select('*');
	$this->db->from('tbl_sub_category2');
	$this->db->where('subcategory_id', $subcategory_id);
	$this->db->where('is_active', 1);
	$this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
	$this->db->where('is_subcate2_delete', 0);
	$subcategories2_da= $this->db->get();

	if(!empty($subcategories2_da)){
	foreach ($subcategories2_da->result() as $subcate2) {

		$subcategory2_data[]= array(
			'id'=>$subcate2->id,
			'category_id'=>$subcate2->category_id,
			'subcategory_id'=>$subcate2->subcategory_id,
			'name'=>$subcate2->name,
			'image'=>$base_url.$subcate2->image,
			'short_desc'=>"",
			'long_desc'=>"",
			'sort_id'=>"",
			'is_active'=>$subcate2->is_active,
			'url'=>"",
			'subtext1'=>$subcate2->subtext1

			);


	}
	}






  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $subcategory2_data,
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


}



//Get Products Of Category Wise Post API
public function get_category_products()

{
  // if(!empty($this->session->userdata('admin_data'))){


  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean');
  $this->form_validation->set_rules('subcategory2_id', 'subcategory2_id', 'xss_clean');
  $this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
  $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');
  // $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
  // $this->form_validation->set_rules('password', 'password', 'required|xss_clean');


  if($this->form_validation->run()== TRUE)
  {
  //$app_authentication_code=$this->input->post('app_authentication_code');
  $category_id=$this->input->post('category_id');
  $subcategory_id=$this->input->post('subcategory_id');
  $subcategory2_id=$this->input->post('subcategory2_id');
  $device_id=$this->input->post('device_id');
  $user_id=$this->input->post('user_id');
  // $email=$this->input->post('email');
  // $passw=$this->input->post('password');
  // $pass=md5($passw);

$products=[];
$typedata= [];

if(!empty($subcategory2_id)){
	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('category_id', $category_id);
	$this->db->where('subcategory_id', $subcategory_id);
	$this->db->where('subcategory2_id', $subcategory2_id);
	$this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
	$this->db->where('is_subcate2_delete', 0);
	$this->db->where('is_active', 1);
	$cate_products= $this->db->get();
}else{
	$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('category_id', $category_id);
	$this->db->where('subcategory_id', $subcategory_id);
	$this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
	$this->db->where('is_subcate2_delete', 0);
	$this->db->where('is_active', 1);
	$cate_products= $this->db->get();
}





  $base_url=base_url();

if(!empty($cate_products)){
  $i=1; foreach($cate_products->result() as $data) {

  $this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$data->id);
		$this->db->where('is_active', 1);
  $type_data= $this->db->get();

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



//Get Products Detail Post API

public function product_detail()

{
  // if(!empty($this->session->userdata('admin_data'))){


  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
  $this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
  $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');
  // $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
  // $this->form_validation->set_rules('password', 'password', 'required|xss_clean');


  if($this->form_validation->run()== TRUE)
  {
  //$app_authentication_code=$this->input->post('app_authentication_code');
  $product_id= $this->input->post('product_id');
  $device_id=$this->input->post('device_id');
  $user_id=$this->input->post('user_id');
  // $email=$this->input->post('email');
  // $passw=$this->input->post('password');
  // $pass=md5($passw);

$products=[];
$typedata= [];
  $this->db->select('*');
  $this->db->from('tbl_product');
  $this->db->where('id', $product_id);
  $this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
	$this->db->where('is_subcate2_delete', 0);
  $this->db->where('is_active', 1);
  $data= $this->db->get()->row();
  $base_url=base_url();

if(!empty($data)){


  $this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$data->id);
		$this->db->where('is_active', 1);
  $type_data= $this->db->get();

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



  $products=  array (
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

//Get Related Products Post API
public function related_product()

{

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

		$this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');
	  $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
	  $this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
	  $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');


  if($this->form_validation->run()== TRUE)
  {

		$category_id=$this->input->post('category_id');
	  $product_id=$this->input->post('product_id');
	  $device_id=$this->input->post('device_id');
	  $user_id=$this->input->post('user_id');


$products=[];
$typedata= [];
  $this->db->select('*');
  $this->db->from('tbl_product');
  $this->db->where('category_id', $category_id);
  $this->db->where('is_cat_delete', 0);
	$this->db->where('is_subcat_delete', 0);
	$this->db->where('is_subcate2_delete', 0);
  $this->db->where('is_active', 1);
	$this->db->order_by('id', 'DESC');
  $cate_products= $this->db->get();
  $base_url=base_url();

if(!empty($cate_products)){
  $i=1; foreach($cate_products->result() as $data) {

if($product_id != $data->id) {

  $this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$data->id);
		$this->db->where('is_active', 1);
  $type_data= $this->db->get();

  if(!empty($type_data)){
  foreach ($type_data->result() as $type) {

		$this->db->select('*');
	$this->db->from('tbl_units');
	$this->db->where('id',$type->unit_id);
	$this->db->where('is_active', 1);
	$ptoduct_unit_data= $this->db->get()->row();

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











  $products[]=  array (
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
		'image1'=>$base_url.$data->image1,
		'image2'=>$base_url.$data->image2,
		'image3'=>$base_url.$data->image3,
		'image4'=>$base_url.$data->image4,
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

}
