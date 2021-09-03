<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class ApiController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}



			public function signup()

			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
			$this->form_validation->set_rules('name', 'name', 'required|customAlpha|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('password', 'password', 'required|xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');


			if($this->form_validation->run()== TRUE)
			{
			$device_id=$this->input->post('device_id');
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			$passw=$this->input->post('password');
			$phone_number=$this->input->post('phone');

			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");




			$data_insert = array('first_name'=>$name,
			                     'device_id'=>$device_id,

			    'email'=>$email,
			    'password'=>md5($passw),
			    'contact'=>$phone_number,

			    'ip' =>$ip,

			    'is_active' =>1,
			    'date'=>$cur_date

			    );





			$last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

			if($last_id!=0)
			{

			  //email id update in cart1 tabel every time of signin
				//
			  // $this->db->select('*');
			  // $this->db->from('tbl_cart1');
			  // $this->db->where('mac_id',$mac_id);
			  // $mac_cart_data= $this->db->get()->row();
				//
			  // if(!empty($mac_cart_data)){
			  //       $data_updates= array (
			  //         'email'=>$email,
				//
				//
			  //       );
				//
			  //       $this->db->where('mac_id', $mac_id);
			  //       $update_last_cart_id=$this->db->update('tbl_cart1', $data_updates);
			  //     }
				//
			  //     //email id update in user_address tabel every time of signin
				//
			  //                 $this->db->select('*');
			  //     $this->db->from('tbl_user_address');
			  //     $this->db->where('mac_id',$mac_id);
			  //     $mac_user_addr_data= $this->db->get();
				//
			  //     if(!empty($mac_user_addr_data)){
			  //       foreach ($mac_user_addr_data as $user_addrs) {
				//
				//
			  //           $data_updatess= array (
			  //             'email'=>$email,
				//
				//
			  //           );
				//
			  //           $this->db->where('mac_id', $mac_id);
			  //           $update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
			  //             }
			  //         }




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



//Signin Api for Oswal app
public function signin()

{

// if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
$this->form_validation->set_rules('password', 'password', 'required|xss_clean');


if($this->form_validation->run()== TRUE)
{
//$app_authentication_code=$this->input->post('app_authentication_code');
$device_id=$this->input->post('device_id');
$email=$this->input->post('email');
$passw=$this->input->post('password');
$pass=md5($passw);

// if($this->form_validation->run()== TRUE)
// {



// $typ=base64_decode($t);
$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('email',$email);
// $this->db->where('mac_id',$mac_id);
$user_data= $this->db->get()->row();

if(!empty($user_data)){

if($email == $user_data->email)
{

    if($pass == $user_data->password){

//device id update in users tabel every time of signin

      $data_update= array (
        'device_id'=>$device_id,


      );

      $this->db->where('id', $user_data->id);
      $update_last_id=$this->db->update('tbl_users', $data_update);

      //email id update in cart1 tabel every time of signin

      //             $this->db->select('*');
      // $this->db->from('tbl_cart1');
      // $this->db->where('mac_id',$mac_id);
      // $mac_cart_data= $this->db->get()->row();
			//
      // if(!empty($mac_cart_data)){
      //       $data_updates= array (
      //         'email'=>$email,
			//
			//
      //       );
			//
      //       $this->db->where('mac_id', $mac_id);
      //       $update_last_cart_id=$this->db->update('tbl_cart1', $data_updates);
      //     }




      $data= array (
				'id'=>$user_data->id,
				'name'=>$user_data->name,
                'email'=>$user_data->email,
								'password'=>$user_data->password

      );
      $res = array('message'=>"success",
            'status'=>200,
            'data'=> $data,
            );

      echo json_encode($res);

    }else{
      $res = array('message'=>"Password does not matched!",
            'status'=>201
            );

      echo json_encode($res); exit;

    }



}

else
{
  $res = array('message'=>"Email does not matched!",
        'status'=>201
        );

  echo json_encode($res); exit;
}


}
else{


$res = array('message'=>"User does not exist.",
'status'=>201
);

echo json_encode($res);

}


// }else{
//
//   $res = array('message'=>"app_authentication_code does not matched.",
//         'status'=>201
//         );
//
//   echo json_encode($res);
// }



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



//category , recent category and trending category Get API

public function home_category()

{

// if(!empty($this->session->userdata('admin_data'))){
//$data= [];

$this->db->select('*');
$this->db->from('tbl_ecom_category');
//$this->db->where('id',$usr);
$categories= $this->db->limit(4)->get();
$base_url=base_url();

$i=1; foreach($categories->result() as $data) {

				$category[]= array (
						'id'=>$data->id,
					'name'=>$data->name,
					'short_desc'=>$data->short_dis,
					'long_desc'=>$data->long_desc,
					'url'=>$data->url,
					'image'=>$base_url."assets/admin/major_category/".$data->image,
					'is_active'=>$data->is_active,
				);







}

$types= [];
$this->db->select('*');
$this->db->from('tbl_ecom_products');
$this->db->order_by('rand()');
$this->db->limit(10);
//$this->db->where('id',$usr);
//$this->db->order_by('id', 'RANDOM');
$trendings= $this->db->get();


$i=1; foreach($trendings->result() as $data) {

			$this->db->select('*');
$this->db->from('tbl_type');
$this->db->where('product_id',$data->id);
$type_data= $this->db->get();
// print_r($type_data->result()); die();
if(!empty($type_data)){
foreach ($type_data->result() as $type) {

$types[]= array(
'type_id'=>$type->id,
'type_name'=>$type->type_name,
'type_category_id'=>$type->category_id,
'type_product_id'=>$type->product_id,
'type_mrp'=>$type->mrp,
'gst_percentage'=>$type->gst_percentage,
'gst_percentage_price'=>$type->gst_percentage_price,
'selling_price'=>$type->selling_price,
'type_weight'=>$type->weight,
'type_rate'=>$type->rate,

);



}
}
else{
$types[]= [];
}

$trending[]= array  (
	'id'=>$data->id,
	'category_id'=>$data->category_id,
'name'=>$data->name,
'long_desc'=>$data->long_desc,
'url'=>$data->url,
'image1'=>$base_url."assets/admin/products/".$data->img1,
'image2'=>$base_url."assets/admin/products/".$data->img2,
'image3'=>$base_url."assets/admin/products/".$data->img3,
'image4'=>$base_url."assets/admin/products/".$data->img4,
'is_active'=>$data->is_active,
'type'=>$types
);
$types= [];
// print_r($trending)


	}


$typedata= [];
$this->db->select('*');
$this->db->from('tbl_ecom_products');
$this->db->order_by("id", "desc");
//$this->db->where('id',$usr);
//$this->db->order_by('id', 'RANDOM');
$recents= $this->db->get();

$i=1; foreach($recents->result() as $data) {

$this->db->select('*');
$this->db->from('tbl_type');
$this->db->where('product_id',$data->id);
$type_data= $this->db->get();
if(!empty($type_data)){
foreach ($type_data->result() as $type) {

$typedata[]= array(
	'type_id'=>$type->id,
	'type_name'=>$type->type_name,
	'type_category_id'=>$type->category_id,
	'type_product_id'=>$type->product_id,
	'type_mrp'=>$type->mrp,
	'gst_percentage'=>$type->gst_percentage,
	'gst_percentage_price'=>$type->gst_percentage_price,
	'selling_price'=>$type->selling_price,
	'type_weight'=>$type->weight,
	'type_rate'=>$type->rate,
);

}
}else{
$typedata[]= [];
}


$recent[]=  array (
	'id'=>$data->id,
	'category_id'=>$data->category_id,
'name'=>$data->name,
'long_desc'=>$data->long_desc,
'url'=>$data->url,
'image1'=>$base_url."assets/admin/products/".$data->img1,
'image2'=>$base_url."assets/admin/products/".$data->img2,
'image3'=>$base_url."assets/admin/products/".$data->img3,
'image4'=>$base_url."assets/admin/products/".$data->img4,
'is_active'=>$data->is_active,
'type'=>$typedata
);

$typedata= [];

}

// $data['categories']= $all_categories;
// $data['trending']= $trending_categories;
// $data['recent']= $recent_categories;

$data= array (
'categories'=>$category,
'trending'=>$trending,
'recent'=>$recent,

);




$res = array('message'=>"success",
'status'=>200,
'data'=> $data,
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

//demo-product list----------------

public function product_list(){

      			$this->db->select('*');
						$this->db->from('tbl_product');
						$plist= $this->db->get();
						$pro = $plist->row();

						$burl= base_url();

						if(!empty($pro)){
						foreach ($plist->result() as $list) {
						$data[] = array('product_id'=> $list->id,
							'name'=> $list->name,
							'category_id'=> $list->category_id,
							'subcategory_id'=> $list->subcategory_id,
							'subcategory2_id'=> $list->subcategory2_id,
							'short_description'=> $list->short_description,
							'long_description'=> $list->long_description,
							'image1'=> $burl."assets/uploads/product/".$list->image1,
							'image2'=> $burl."assets/uploads/product/".$list->image2,
							'image3'=> $burl."assets/uploads/product/".$list->image3,
							'image4'=> $burl."assets/uploads/product/".$list->image4,
							'app_pro_image'=> $burl."assets/uploads/productApp/".$list->app_pro_image,
							'product_unit_type'=> $list->product_unit_type,
							'expire_date'=> $list->expire_date,
							'discount_tag'=> $list->discount_tag,
							'is_cat_delete'=> $list->is_cat_delete,
							'is_subcat_delete'=> $list->is_subcat_delete,
							'is_subcate2_delete'=> $list->is_subcate2_delete,
							'ip'=> $list->ip,
							'date'=> $list->date,
							'added_by'=> $list->added_by,
							'is_active'=> $list->is_active,
							'app_main_image'=> $burl."assets/uploads/productAppMainImg/".$list->app_main_image,
							'app_image1'=>  $burl."assets/uploads/productAppImg/".$list->app_image1,
							'app_image2'=> $burl."assets/uploads/productAppImg/".$list->app_image2,
							'app_image3'=> $burl."assets/uploads/productAppImg/".$list->app_image3,
							'app_image4'=> $burl."assets/uploads/productAppImg/".$list->app_image4
						);
					}//loop end

						$res = array('message'=>"success",
						'status'=>200,
						'product'=> $data
						);
						echo json_encode($res);
						exit;
					}
					else{
						$res = array('message'=>"No data found",
						'status'=>201
						);
						echo json_encode($res);
						exit;
					}

}//fun productlist end

//product detail-----

public function product_detail(){

	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	$this->load->helper('security');
	if($this->input->post())
	{

	$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');


	if($this->form_validation->run()== TRUE)
	{
	//$app_authentication_code=$this->input->post('app_authentication_code');
	$product_id=$this->input->post('product_id');

	$this->db->select('*');
	            $this->db->from('tbl_product');
	            $this->db->where('id',$product_id);
	            $dsa= $this->db->get();
	            $list=$dsa->row();
							$burl= base_url();
							$data = array('product_id'=> $list->id,
								'name'=> $list->name,
								'category_id'=> $list->category_id,
								'subcategory_id'=> $list->subcategory_id,
								'subcategory2_id'=> $list->subcategory2_id,
								'short_description'=> $list->short_description,
								'long_description'=> $list->long_description,
								'image1'=> $burl."assets/uploads/product/".$list->image1,
								'image2'=> $burl."assets/uploads/product/".$list->image2,
								'image3'=> $burl."assets/uploads/product/".$list->image3,
								'image4'=> $burl."assets/uploads/product/".$list->image4,
								'app_pro_image'=> $burl."assets/uploads/productApp/".$list->app_pro_image,
								'product_unit_type'=> $list->product_unit_type,
								'expire_date'=> $list->expire_date,
								'discount_tag'=> $list->discount_tag,
								'is_cat_delete'=> $list->is_cat_delete,
								'is_subcat_delete'=> $list->is_subcat_delete,
								'is_subcate2_delete'=> $list->is_subcate2_delete,
								'ip'=> $list->ip,
								'date'=> $list->date,
								'added_by'=> $list->added_by,
								'is_active'=> $list->is_active,
								'app_main_image'=> $burl."assets/uploads/productAppMainImg/".$list->app_main_image,
								'app_image1'=>  $burl."assets/uploads/productAppImg/".$list->app_image1,
								'app_image2'=> $burl."assets/uploads/productAppImg/".$list->app_image2,
								'app_image3'=> $burl."assets/uploads/productAppImg/".$list->app_image3,
								'app_image4'=> $burl."assets/uploads/productAppImg/".$list->app_image4
							);

							$res = array('message'=>"success",
							'status'=>200,
							'product'=> $data
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

	}//post if end
	else{
		$res = array('message'=>'Please insert some data, No data available',
		'status'=>201
		);

		echo json_encode($res);


	}

}//fun end


}
