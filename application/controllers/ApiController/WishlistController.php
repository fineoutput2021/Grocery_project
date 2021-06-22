<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class WishlistController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}


//Wishlist add API Post
			public function add_wishlist()

			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
      $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean');
      $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');





			if($this->form_validation->run()== TRUE)
			{
			$device_id=$this->input->post('device_id');
			$user_id=$this->input->post('user_id');

      $product_id=$this->input->post('product_id');
      $category_id=$this->input->post('category_id');




			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");



        //Without Login

        $data_insert = array('device_id'=>$device_id,
                            'user_id'=>$user_id,

        					'product_id'=>$product_id,
        					'category_id'=>$category_id,

        					//'is_active' =>1,
        					'date'=>$cur_date,
        					'updated_date'=>$cur_date

        					);





        $last_id=$this->base_model->insert_table("tbl_wishlist",$data_insert,1) ;

        if($last_id!=0)
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



      //Wishlist Data Get API

      public function get_wishlist()
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

      if($this->form_validation->run()== TRUE)
      {


        $device_id=$this->input->post('device_id');
        $user_id=$this->input->post('user_id');


          $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
          $cur_date=date("Y-m-d H:i:s");






if(empty($user_id)){

//without Login 

          $this->db->select('*');
          $this->db->from('tbl_wishlist');
          $this->db->where('device_id',$device_id);
          // $this->db->where('is_active',1);
          $wishlist_data= $this->db->get();
          // print_r($cart_data->result()); die();
          $base_url=base_url();
            $product_data= [];
    if(!empty($wishlist_data)){
          $i=1; foreach($wishlist_data->result() as $datas) {

            $p1=$datas->product_id;
            $p2=$datas->category_id;




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
                    $this->db->from('tbl_ecom_products');
                    $this->db->where('id', $p1);
                    $this->db->where('category_id', $p2);
                    $products= $this->db->get()->row();
                    $base_url=base_url();




                    $this->db->select('*');
                    $this->db->from('tbl_type');
                    $this->db->where('product_id',$products->id);
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


                    $product_data[]=  array (
                    	'wishlist_id'=>$datas->id,
                      'product_id'=>$p1,
                    	'category_id'=>$p2,

                    'product_name'=>$products->name,
                    'long_desc'=>$products->long_desc,
                    'url'=>$products->url,
                    'image1'=>$base_url."assets/admin/products/".$products->img1,
                    'image2'=>$base_url."assets/admin/products/".$products->img2,
                    'image3'=>$base_url."assets/admin/products/".$products->img3,
                    'image4'=>$base_url."assets/admin/products/".$products->img4,
                    'is_active'=>$products->is_active,
                    'type'=>$typedata
                    );

                    $typedata= [];







          }

          $res = array('message'=>"success",
          'status'=>200,
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
$this->db->from('tbl_wishlist');
$this->db->where('user_id',$user_id);
// $this->db->where('is_active',1);
$wishlist_data= $this->db->get();
// print_r($cart_data->result()); die();
$base_url=base_url();
	$product_data= [];
if(!empty($wishlist_data)){
$i=1; foreach($wishlist_data->result() as $datas) {

	$p1=$datas->product_id;
	$p2=$datas->category_id;




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
					$this->db->from('tbl_ecom_products');
					$this->db->where('id', $p1);
					$this->db->where('category_id', $p2);
					$products= $this->db->get()->row();
					$base_url=base_url();




					$this->db->select('*');
					$this->db->from('tbl_type');
					$this->db->where('product_id',$products->id);
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


					$product_data[]=  array (
						'wishlist_id'=>$datas->id,
						'product_id'=>$p1,
						'category_id'=>$p2,

					'product_name'=>$products->name,
					'long_desc'=>$products->long_desc,
					'url'=>$products->url,
					'image1'=>$base_url."assets/admin/products/".$products->img1,
					'image2'=>$base_url."assets/admin/products/".$products->img2,
					'image3'=>$base_url."assets/admin/products/".$products->img3,
					'image4'=>$base_url."assets/admin/products/".$products->img4,
					'is_active'=>$products->is_active,
					'type'=>$typedata
					);

					$typedata= [];







}

$res = array('message'=>"success",
'status'=>200,
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






//Wishlist Delete API Post
			public function delete_wishlist()

			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
      $this->form_validation->set_rules('wishlist_id', 'wishlist_id', 'required|xss_clean');
      // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean');





			if($this->form_validation->run()== TRUE)
			{
			$device_id=$this->input->post('device_id');
			$user_id=$this->input->post('user_id');

      $wishlist_id=$this->input->post('wishlist_id');
      // $category_id=$this->input->post('category_id');




			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");


if(empty($user_id)){

//Without Login

				$this->db->select('*');
$this->db->from('tbl_wishlist');
//$this->db->where('id',$usr);
$this->db->where('device_id',$device_id);
$this->db->where('id',$wishlist_id);
$wishlist= $this->db->get()->row();

if(!empty($wishlist)){

	$delete_id=$this->db->delete('tbl_wishlist', array('id' => $wishlist_id));


}else{
	$delete_id= 0;
}







        if($delete_id!=0)
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
$this->db->from('tbl_wishlist');
$this->db->where('user_id',$user_id);
$this->db->where('id',$wishlist_id);
$wishlist= $this->db->get()->row();

if(!empty($wishlist)){

$delete_id=$this->db->delete('tbl_wishlist', array('id' => $wishlist_id));


}else{
$delete_id= 0;
}




if($delete_id!=0)
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


//Move to cart api

public function move_to_cart()

{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
$this->form_validation->set_rules('wishlist_id', 'wishlist_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('type_id', 'type_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('type_price', 'type_price', 'required|xss_clean|trim');
// $this->form_validation->set_rules('qty', 'qty', 'required|xss_clean|trim');




if($this->form_validation->run()== TRUE)
{
$device_id=$this->input->post('device_id');
$user_id=$this->input->post('user_id');
$wishlist_id=$this->input->post('wishlist_id');
// $category_id=$this->input->post('category_id');
// $product_id=$this->input->post('product_id');
// $type_id=$this->input->post('type_id');
// $type_price=$this->input->post('type_price');
// $qty=$this->input->post('qty');

// $total_qty_price= $type_price * $qty ;

	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");


if(empty($user_id)){


      			$this->db->select('*');
$this->db->from('tbl_wishlist');
//$this->db->where('id',$usr);
$this->db->where('device_id',$device_id);
$this->db->where('id',$wishlist_id);
$wishlist= $this->db->get()->row();

if(!empty($wishlist)){
	$product_id= $wishlist->product_id;
	$category_id= $wishlist->category_id;
}


$this->db->select('*');
$this->db->from('tbl_cart');
// $this->db->where('user_id',$user_id);
$this->db->where('device_id',$device_id);
$this->db->where('product_id',$product_id);
$cartt_data= $this->db->get()->row();

if(empty($cartt_data)){

	$this->db->select('*');
	$this->db->from('tbl_ecom_products');
	// $this->db->where('user_id',$user_id);
	// $this->db->where('device_id',$device_id);
	$this->db->where('id',$product_id);
	$this->db->where('category_id',$category_id);
	$prod_data= $this->db->get()->row();




// $typedata= [];
// 	$this->db->select('*');
//   $this->db->from('tbl_type');
//   $this->db->where('product_id',$prod_data->id);
//   $type_data= $this->db->get();
//
//   if(!empty($type_data)){
//   foreach ($type_data->result() as $type) {
//
//   $typedata[]= array(
//   	'type_id'=>$type->id,
//   	'type_name'=>$type->type_name,
//   	'type_category_id'=>$type->category_id,
//   	'type_product_id'=>$type->product_id,
//   	'type_mrp'=>$type->mrp,
//   	'gst_percentage'=>$type->gst_percentage,
//   	'gst_percentage_price'=>$type->gst_percentage_price,
//   	'selling_price'=>$type->selling_price,
//   	'type_weight'=>$type->weight,
//   	'type_rate'=>$type->rate,
//   );
//
//   }
//   }else{
//   $typedata[]= [];
//   }

//single type data

	$this->db->select('*');
  $this->db->from('tbl_type');
  $this->db->where('product_id',$prod_data->id);
  $typess_data= $this->db->get()->row();

$type_pric= $typess_data->selling_price;
$quan= 1;
$total_qty_price= $type_pric * $quan;

$data_insert = array(
										 'device_id'=>$device_id,

		'user_id'=>$user_id,
		'category_id'=>$category_id,
		'product_id'=>$product_id,
		'type_id'=>$typess_data->id,
		'type_price'=>$type_pric,
		'quantity'=>$quan,
		'total_qty_price'=>$total_qty_price,
		'ip' =>$ip,

		'curr_date'=>$cur_date,
		'updated_date'=>$cur_date,

		);





$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;



if($last_id!=0)
{

		$del_id=$this->db->delete('tbl_wishlist', array('id' => $wishlist_id));

		$res = array('message'=>"success",
		'status'=>200
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


}
// elseif ($qty == 0) {
//
//   $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));
//
//
// }
else{

	$res = array('message'=>"This Product Already Exist In Cart",
	'status'=>200
	);

	echo json_encode($res); exit;


}




}else{

echo "1";


	      			$this->db->select('*');
	$this->db->from('tbl_wishlist');
	//$this->db->where('id',$usr);
	$this->db->where('user_id',$user_id);
	$this->db->where('id',$wishlist_id);
	$wishlist= $this->db->get()->row();

if(!empty($wishlist)){


	if(!empty($wishlist)){
		$product_id= $wishlist->product_id;
		$category_id= $wishlist->category_id;
	}
	else{
		$product_id= "";
		$category_id= "";
	}


	$this->db->select('*');
	$this->db->from('tbl_cart');
	// $this->db->where('user_id',$user_id);
	$this->db->where('user_id',$user_id);
	$this->db->where('product_id',$product_id);
	$cartt_data= $this->db->get()->row();

	if(empty($cartt_data)){

		$this->db->select('*');
		$this->db->from('tbl_ecom_products');
		// $this->db->where('user_id',$user_id);
		// $this->db->where('device_id',$device_id);
		$this->db->where('id',$product_id);
		$this->db->where('category_id',$category_id);
		$prod_data= $this->db->get()->row();

		if(!empty($prod_data)){
			$pro_id= $prod_data->id;
			// $category_id= $wishlist->category_id;
		}
		else{
			$pro_id= "";
			// $category_id= "";
		}


	// $typedata= [];
	// 	$this->db->select('*');
	//   $this->db->from('tbl_type');
	//   $this->db->where('product_id',$prod_data->id);
	//   $type_data= $this->db->get();
	//
	//   if(!empty($type_data)){
	//   foreach ($type_data->result() as $type) {
	//
	//   $typedata[]= array(
	//   	'type_id'=>$type->id,
	//   	'type_name'=>$type->type_name,
	//   	'type_category_id'=>$type->category_id,
	//   	'type_product_id'=>$type->product_id,
	//   	'type_mrp'=>$type->mrp,
	//   	'gst_percentage'=>$type->gst_percentage,
	//   	'gst_percentage_price'=>$type->gst_percentage_price,
	//   	'selling_price'=>$type->selling_price,
	//   	'type_weight'=>$type->weight,
	//   	'type_rate'=>$type->rate,
	//   );
	//
	//   }
	//   }else{
	//   $typedata[]= [];
	//   }

	//single type data

		$this->db->select('*');
	  $this->db->from('tbl_type');
	  $this->db->where('product_id',$pro_id);
	  $typess_data= $this->db->get()->row();

if(!empty($prod_data)){
	$typ_id= $typess_data->id;
	$type_pric= $typess_data->selling_price;
	$quan= 1;
	$total_qty_price= $type_pric * $quan;
}else{
	$typ_id= "";
	$type_pric= "";
	$quan= "";
	$total_qty_price= "";
}
	$data_insert = array(
											 'device_id'=>$device_id,

			'user_id'=>$user_id,
			'category_id'=>$category_id,
			'product_id'=>$product_id,
			'type_id'=>$typ_id,
			'type_price'=>$type_pric,
			'quantity'=>$quan,
			'total_qty_price'=>$total_qty_price,
			'ip' =>$ip,

			'curr_date'=>$cur_date,
			'updated_date'=>$cur_date,

			);





	$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;



	if($last_id!=0)
	{

			$del_id=$this->db->delete('tbl_wishlist', array('id' => $wishlist_id));

			$res = array('message'=>"success",
			'status'=>200
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


	}
	// elseif ($qty == 0) {
	//
	//   $last_id=$this->db->delete('tbl_cart', array('id' => $cartt_data->id));
	//
	//
	// }
	else{

		$res = array('message'=>"This Product Already Exist In Cart",
		'status'=>200
		);

		echo json_encode($res); exit;


	}

}else{


	$res = array('message'=>" Wishlist Empty",
	'status'=>200
	);

	echo json_encode($res); exit;


}
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








}
