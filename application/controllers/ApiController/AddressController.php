<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class AddressController extends CI_Controller{
		function __construct()
			{
				parent::__construct();
				$this->load->model("admin/login_model");
				$this->load->model("admin/base_model");
				$this->load->helper('form');
				// $this->load->library('recaptcha');

			}



			public function add_address()
			{

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{

			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|trim');
      $this->form_validation->set_rules('doorflat', 'doorflat', 'required|xss_clean');
      $this->form_validation->set_rules('city', 'city', 'required|xss_clean');
      $this->form_validation->set_rules('state', 'state', 'required|xss_clean');
      $this->form_validation->set_rules('zipcode', 'zipcode', 'xss_clean');




			if($this->form_validation->run()== TRUE)
			{
			$device_id=$this->input->post('device_id');
			$user_id=$this->input->post('user_id');

      $doorflat=$this->input->post('doorflat');
      $landmark=$this->input->post('landmark');
      // $area=$this->input->post('area');
      $city=$this->input->post('city');
      $state=$this->input->post('state');
      $zipcode=$this->input->post('zipcode');
      $address=$this->input->post('address');
      // $latitude=$this->input->post('latitude');
      // $longitude=$this->input->post('longitude');
      // $location_address=$this->input->post('location_address');



			// $this->db->select('*');
			// $this->db->from('all_cities');
			// $this->db->where('city_name',$city);
			// $city_d= $this->db->get()->row();
			//
			// if(!empty($city_d)){
			//  	$city_id= $city_d->id;
			// 	$state_id= $city_d->state_id;
			//  // die();
			// }else{
			// 	$city_id= "";
			// 	$state_id= "";
			// 	// die();
			// }

// die();

			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");



        //Without Login

        $data_insert = array('device_id'=>$device_id,
                            'user_id'=>$user_id,

        					'doorflat'=>$doorflat,
        					'area'=>"",
        					'landmark'=>$landmark,
        					'city'=>$city,
        					'state'=>$state,
        					'zipcode'=>$zipcode,

        					'address' =>$address,
        					// 'latitude' =>$latitude,
        					// 'longitude' =>$longitude,
        					// 'location_address' =>$location_address,

        					//'is_active' =>1,
        					'date'=>$cur_date,
        					'updated_date'=>$cur_date

        					);





        $last_id=$this->base_model->insert_table("tbl_user_address",$data_insert,1) ;

        if($last_id!=0)
        {

					$this->db->select('*');
					$this->db->from('tbl_user_address');
					$this->db->where('device_id',$device_id);
					$this->db->where('id',$last_id);
					$addr_datas= $this->db->get()->row();


					//GET STATE NAME
				  //       $this->db->select('*');
				  //       $this->db->from('all_states');
				  //       $this->db->where('id',$addr_datas->state);
				  //       $state= $this->db->get()->row();
					//
				  // //GET CITY NAME
				  //       $this->db->select('*');
				  //       $this->db->from('all_cities');
				  //       $this->db->where('id',$addr_datas->city);
				  //       $city= $this->db->get()->row();




				                $address_data=  array (
				                	'id'=>$addr_datas->id,
				                  'device_id'=>$addr_datas->device_id,
				                	'user_id'=>$addr_datas->user_id,
				                	'address'=>$addr_datas->address,
				                'landmark'=>$addr_datas->landmark,
				                'doorflat'=>$addr_datas->doorflat,
				                // 'area'=>$addr_datas->area,
				                'latitude'=>"",
				                'longitude'=>"",
				                'location_address'=>"",
				                'city'=> $addr_datas->city,
				                'state'=>$addr_datas->state,
				                'zipcode'=>$addr_datas->zipcode,
				                'date'=>$addr_datas->date,
				                'updated_date'=>$addr_datas->updated_date,
				                'custom_address'=>$addr_datas->doorflat." ".$addr_datas->landmark." ".$addr_datas->address." ".$addr_datas->location_address." ".$addr_datas->zipcode,

				                );


        	$res = array('message'=>"success",
        					'status'=>200,
									'data'=>$address_data,

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

      public function get_address()
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


      $this->db->select('*');
      $this->db->from('tbl_user_address');
      $this->db->where('device_id',$device_id);
      // $this->db->where('is_active',1);
      $addr_data= $this->db->get();
      // print_r($cart_data->result()); die();
      $base_url=base_url();
        $address_data= [];
if(!empty($addr_data)){
      $i=1; foreach($addr_data->result() as $datas) {

  //GET STATE NAME
  //       $this->db->select('*');
  //       $this->db->from('all_states');
  //       $this->db->where('id',$datas->state);
  //       $state= $this->db->get()->row();
	//
  // //GET CITY NAME
  //       $this->db->select('*');
  //       $this->db->from('all_cities');
  //       $this->db->where('id',$datas->city);
  //       $city= $this->db->get()->row();


                $address_data[]=  array (
                	'id'=>$datas->id,
                  'device_id'=>$datas->device_id,
                	'user_id'=>$datas->user_id,
                	'address'=>$datas->address,
                'landmark'=>$datas->landmark,
                'doorflat'=>$datas->doorflat,
                'area'=>$datas->area,
                'latitude'=>$datas->latitude,
                'longitude'=>$datas->longitude,
                'location_address'=>$datas->location_address,
                'city'=> $datas->city,
                'state'=>$datas->state,
                'zipcode'=>$datas->zipcode,
                'date'=>$datas->date,
                'updated_date'=>$datas->updated_date,
								'custom_address'=>$datas->doorflat." ".$datas->landmark." ".$datas->address." ".$datas->location_address." ".$datas->zipcode,

                );









      }

      $res = array('message'=>"success",
      'status'=>200,
      'data'=> $address_data,
      );

      echo json_encode($res); exit;

}
else{
  $address_data=[];
  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $address_data,
  );

  echo json_encode($res); exit;

}

}else{


//with login


      $this->db->select('*');
      $this->db->from('tbl_user_address');
      $this->db->where('user_id',$user_id);
      // $this->db->where('is_active',1);
      $addr_data= $this->db->get();
      // print_r($cart_data->result()); die();
      $base_url=base_url();
        $address_data= [];
if(!empty($addr_data)){
      $i=1; foreach($addr_data->result() as $datas) {

  //GET STATE NAME
  //       $this->db->select('*');
  //       $this->db->from('all_states');
  //       $this->db->where('id',$datas->state);
  //       $state= $this->db->get()->row();
	//
  // //GET CITY NAME
  //       $this->db->select('*');
  //       $this->db->from('all_cities');
  //       $this->db->where('id',$datas->city);
  //       $city= $this->db->get()->row();


                $address_data[]=  array (
                	'id'=>$datas->id,
                  'device_id'=>$datas->device_id,
                	'user_id'=>$datas->user_id,
                	'address'=>$datas->address,
                'landmark'=>$datas->landmark,
                'doorflat'=>$datas->doorflat,
                'area'=>$datas->area,
                'latitude'=>$datas->latitude,
                'longitude'=>$datas->longitude,
                'location_address'=>$datas->location_address,
                'city'=> $datas->city,
                'state'=>$datas->state,
                'zipcode'=>$datas->zipcode,
                'date'=>$datas->date,
                'updated_date'=>$datas->updated_date,
								'custom_address'=>$datas->doorflat." ".$datas->landmark." ".$datas->address." ".$datas->location_address." ".$datas->zipcode,

                );









      }

      $res = array('message'=>"success",
      'status'=>200,
      'data'=> $address_data,
      );

      echo json_encode($res); exit;

}
else{
  $address_data=[];
  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $address_data,
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



//Get State and city  list


public function get_state_cities()

{
  // if(!empty($this->session->userdata('admin_data'))){





$citydata= [];
  $this->db->select('*');
  $this->db->from('all_states');
  $state_data= $this->db->get();
  $base_url=base_url();


  $i=1; foreach($state_data->result() as $data) {

  $this->db->select('*');
  $this->db->from('all_cities');
  $this->db->where('state_id',$data->id);
  $city_data= $this->db->get();
  if(!empty($city_data)){
  foreach ($city_data->result() as $city) {

  $citydata[]= array(
  	'id'=>$city->id,
  	'city_name'=>$city->city_name,
  	'state_id'=>$city->state_id,

  );

  }
  }else{
  $citydata[]= [];
  }


  $states[]=  array (
  	'id'=>$data->id,
  	'state_name'=>$data->state_name,
    // 'cities'=>$citydata
  );

  // $citydata= [];

  }

  $res = array('message'=>"success",
  'status'=>200,
  'data'=> $states,
  'cities'=> $citydata,
  );

  echo json_encode($res); exit;





  //     }
  //     else{
  //
  // redirect("login/admin_login","refresh");
  //
  //
  //     }


}





public function get_cities_statewise()

{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('state_id', 'state_id', 'required|xss_clean|trim');





if($this->form_validation->run()== TRUE)
{
$state_id=$this->input->post('state_id');




	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");












		//GET CITY NAME
					$this->db->select('*');
					$this->db->from('all_cities');
					$this->db->where('state_id',$state_id);
					$cities= $this->db->get();

$city_data=[];
if(!empty($cities)){
					foreach ($cities->result() as $city) {
						// code...

						$city_data[]= array(
							'id'=>$city->id,
							'city_name'=>$city->city_name,
							'state_id'=>$city->state_id,

						);
					}

}




		$res = array('message'=>"success",
						'status'=>200,
						'data'=>$city_data,

						);

		echo json_encode($res); exit;
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
