<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class LoginController extends CI_Controller{
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

			$this->form_validation->set_rules('refer_user_id', 'refer_user_id', 'xss_clean');
			$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
			$this->form_validation->set_rules('firstname', 'firstname', 'required|xss_clean');
			$this->form_validation->set_rules('lastname', 'lastname', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|is_unique[tbl_users.email]');
			$this->form_validation->set_rules('password', 'password', 'required|xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');


			if($this->form_validation->run()== TRUE)
			{

      $refer_user_id=$this->input->post('refer_user_id');
      $device_id=$this->input->post('device_id');

			$firstname=$this->input->post('firstname');
			$lastname=$this->input->post('lastname');
			$email=$this->input->post('email');
			$passw=$this->input->post('password');
			$phone_number=$this->input->post('phone');

			  $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
			  $cur_date=date("Y-m-d H:i:s");


if(empty($refer_user_id)){

//without sharable app

			$data_insert = array('first_name'=>$firstname,
													 'last_name'=>$lastname,
			                     'device_id'=>$device_id,

			    'email'=>$email,
			    'password'=>md5($passw),
			    'contact'=>$phone_number,
			    'wallet'=>0,

			    'ip' =>$ip,

			    'is_active' =>1,
			    'date'=>$cur_date

			    );

}else{

	//after share app signup

	//add wallet gift amount to reffered new user for signup

	$data_insert = array('first_name'=>$firstname,
											 'last_name'=>$lastname,
											 'device_id'=>$device_id,

			'email'=>$email,
			'password'=>md5($passw),
			'contact'=>$phone_number,
			'wallet'=>0,

			'ip' =>$ip,

			'is_active' =>1,
			'date'=>$cur_date

			);


//update wallet amount of user who share and refer app to new user
// 			      			$this->db->select('*');
// 			$this->db->from('tbl_users');
// 			$this->db->where('id',$refer_user_id);
// 			$usr_data= $this->db->get()->row();
//
// if(!empty($usr_data)){
// 	$wallet_balance= $usr_data->wallet;
// 	$last_wallet_amount= $wallet_balance + 20;
//
// 			$data_updatesss= array (
// 				'wallet'=>$last_wallet_amount,
//
//
// 			);
//
// 			$this->db->where('id', $usr_data->id);
// 			$updated_wallet_user_id=$this->db->update('tbl_users', $data_updatesss);
//
// 		}

}



			$last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

			if($last_id!=0)
			{

//start reffered user and new signup user mapping
				$data_insert = array(
														'user_id'=>$refer_user_id,

									'last_id'=>$last_id,
									'ip'=>$ip,

									'date'=>$cur_date

									);



				$mapping_last_id=$this->base_model->insert_table("tbl_user_share_and_refer",$data_insert,1) ;

//end reffered user and new signup user mapping



			 // user id update in cart tabel time of signup

			  $this->db->select('*');
			  $this->db->from('tbl_cart');
			  $this->db->where('device_id',$device_id);
			  // $device_cart_data= $this->db->get()->row();
			  $device_cart_data= $this->db->get();


			  if(!empty($device_cart_data)){
					foreach ($device_cart_data as $device) {
						// code...

			        $data_updates= array (
			          'user_id'=>$last_id,


			        );

			        $this->db->where('device_id', $device_id);
			        $update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
								}
			      }




						// user id update in wishlist tabel time of signup

	 				  // $this->db->select('*');
	 				  // $this->db->from('tbl_wishlist');
	 				  // $this->db->where('device_id',$device_id);
	 				  // // $device_wish_data= $this->db->get()->row();
	 				  // $device_wish_data= $this->db->get();
						//
	 				  // if(!empty($device_wish_data)){
						// 	foreach ($device_wish_data as $device_wish) {
	 				  //       $data_updates= array (
	 				  //         'user_id'=>$last_id,
						//
						//
	 				  //       );
						//
	 				  //       $this->db->where('device_id', $device_id);
	 				  //       $update_last_cart_id=$this->db->update('tbl_wishlist', $data_updates);
						// 	  	}
	 				  //     }

			      //user id update in user_address tabel  time of signup

			                  $this->db->select('*');
			      $this->db->from('tbl_user_address');
			      $this->db->where('device_id',$device_id);
			      $device_user_addr_data= $this->db->get();

			      if(!empty($device_user_addr_data)){
			        foreach ($device_user_addr_data as $user_addrs) {


			            $data_updatess= array (
			              'user_id'=>$last_id,


			            );

			            $this->db->where('device_id', $device_id);
			            $update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
			              }
			          }


								$this->db->select('*');
								$this->db->from('tbl_users');
								$this->db->where('id',$last_id);
								// $this->db->where('mac_id',$mac_id);
								$user_data= $this->db->get()->row();


								$data= array (
									'id'=>$user_data->id,
									'name'=>$user_data->first_name,
									'lastname'=>$user_data->last_name,
									'device_id'=>$device_id,
													'email'=>$user_data->email,
													'password'=>$user_data->password,
													'contact'=>$user_data->contact,
													'wallet'=>$user_data->wallet

								);



			$res = array('message'=>"success",
			'status'=>200,
			'data'=>$data

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
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');
$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
$this->form_validation->set_rules('password', 'password', 'required|xss_clean');


if($this->form_validation->run()== TRUE)
{
//$app_authentication_code=$this->input->post('app_authentication_code');
$device_id=$this->input->post('device_id');
$device_token=$this->input->post('device_token');
$email=$this->input->post('email');
$passw=$this->input->post('password');
$pass=md5($passw);


$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

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


//device token update in tbl_users_device_token tabel every time of signin

      			$this->db->select('*');
$this->db->from('tbl_users_device_token');
$this->db->where('user_id',$user_data->id);
$device_t_data= $this->db->get()->row();

			if(!empty($device_t_data)){

				$data_update_usr= array (
					'device_token'=>$device_token,


				);

				$this->db->where('id', $device_t_data->id);
				$update_last_id=$this->db->update('tbl_users_device_token', $data_update_usr);

			}else{

				$data_insert_usr_device_token= array (
					'mac_id'=> $device_id,
					'device_token'=>$device_token,
					'user_id'=>$user_data->id,
					'create_at'=>$cur_date


				);

				$user_d_token_last_id=$this->base_model->insert_table("tbl_users_device_token",$data_insert_usr_device_token,1);
			}



//device id update in users tabel every time of signin

      $data_update= array (
        'device_id'=>$device_id,


      );

      $this->db->where('id', $user_data->id);
      $update_last_id=$this->db->update('tbl_users', $data_update);

    //  user id update in cart tabel every time of signin

      $this->db->select('*');
      $this->db->from('tbl_cart');
      $this->db->where('device_id',$device_id);
      // $mac_cart_data= $this->db->get()->row();
      $mac_cart_data= $this->db->get();

      if(!empty($mac_cart_data)){
				foreach ($mac_cart_data->result() as $device) {

            $data_updates= array (
              'user_id'=>$user_data->id,

            );

            $this->db->where('device_id', $device->device_id);
            $update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
							}
          }

					// user id update in wishlist tabel every time of signin

					// $this->db->select('*');
					// $this->db->from('tbl_wishlist');
					// $this->db->where('device_id',$device_id);
					// // $device_wish_data= $this->db->get()->row();
					// $device_wish_data= $this->db->get();
					//
					// if(!empty($device_wish_data)){
					// 	foreach ($device_wish_data as $device_wish) {
					// 			$data_updates= array (
					// 				'user_id'=>$user_data->id,
					//
					//
					// 			);
					//
					// 			$this->db->where('device_id', $device_id);
					// 			$update_last_cart_id=$this->db->update('tbl_wishlist', $data_updates);
					// 			}
					// 		}



					//user id update in user_address tabel every time of signin

											$this->db->select('*');
					$this->db->from('tbl_user_address');
					$this->db->where('device_id',$device_id);
					$device_user_addr_data= $this->db->get();

					if(!empty($device_user_addr_data)){
						foreach ($device_user_addr_data as $user_addrs) {


								$data_updatess= array (
									'user_id'=>$user_data->id,


								);

								$this->db->where('device_id', $device_id);
								$update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
									}
							}


      $data= array (
				'id'=>$user_data->id,
				'name'=>$user_data->first_name,
				'lastname'=>$user_data->last_name,
				'device_id'=>$device_id,
                'email'=>$user_data->email,
								'password'=>$user_data->password,
								'contact'=>$user_data->contact,
								'wallet'=>$user_data->wallet

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




//Send OTP Api for UnnatiRetail app

public function send_otp()

{

// if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('contact_no', 'contact_no', 'required|xss_clean');



if($this->form_validation->run()== TRUE)
{

$contact_no=$this->input->post('contact_no');

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=1;

// SEND OTP ON MOBILE NUMBER
$OTP = $this->get_random_password(6,6);

// $msg="Welcome to govindretail.com and Your One Time Password (OTP) for Login Into your account is.".$OTP ;
//
// // $msg="Welcome to unnatiretail.com and Your One Time Password (OTP) for Login Into your account is.".$OTP ;
//
// $curl = curl_init();
//
// curl_setopt_array($curl, array(
//  CURLOPT_URL => "https://2factor.in/API/V1/19c91945-d70a-11ea-9fa5-0200cd936042/SMS/".$contact_no."/".$OTP."/OTP2",
//  CURLOPT_RETURNTRANSFER => true,
//  CURLOPT_ENCODING => "",
//  CURLOPT_MAXREDIRS => 10,
//  CURLOPT_TIMEOUT => 30,
//  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//  CURLOPT_CUSTOMREQUEST => "GET",
//  CURLOPT_SSL_VERIFYHOST => 0,
//  CURLOPT_SSL_VERIFYPEER => 0,
// ));
//
// $response = curl_exec($curl);
// $err = curl_error($curl);
// // echo $err;  print_r($response); print_r($curl);die();
// //echo $contact_no; echo $err; print_r($response); print_r($curl); die();
// curl_close($curl);
//
// if ($err) {
//  echo "cURL Error #:" . $err;
// } else
// {
// // echo $response;
// }




//message code
		$msg= "Welcome to unnatiretail.com and Your One Time Password (OTP) for Login Into your account is ".$OTP." , Aa2iembQTRk" ;

		// $msg= base64_encode(base64_encode($msgs));
		// $msg="Thank you for making payment of Rs 10." ;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		 CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?authkey=339861AKpaCRSF605ddc19P1&mobiles=".$contact_no."&country=91&message=".$msg."&sender=EXAMCH&route=4",
		 CURLOPT_RETURNTRANSFER => true,
		 CURLOPT_ENCODING => "",
		 CURLOPT_MAXREDIRS => 10,
		 CURLOPT_TIMEOUT => 30,
		 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		 CURLOPT_CUSTOMREQUEST => "GET",
		 CURLOPT_SSL_VERIFYHOST => 0,
		 CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		// echo $err;  print_r($response); print_r($curl);die();
		//echo $contact_no; echo $err; print_r($response); print_r($curl); die();
		curl_close($curl);

		if ($err) {
		 echo "cURL Error #:" . $err;
		} else
		{
		// echo $response;
		}







//save otp in table
$otp_data_insert = array(

			 'contact_no'=>$contact_no,
			 'otp'=>$OTP,
				 'ip' =>$ip,
				 'added_by' =>$addedby,
				 'is_active' =>1,
				 'date'=>$cur_date

				 );


$last_id=$this->base_model->insert_table("tbl_otp",$otp_data_insert,1) ;






$res = array('message'=>"success",
			'status'=>200,
			'id'=>$last_id
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


}



//varify otp OTP Api for UnnatiRetail app
public function varify_otp()

{

// if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('contact_no', 'contact_no', 'required|xss_clean');
$this->form_validation->set_rules('otp', 'otp', 'required|xss_clean');
$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');




if($this->form_validation->run()== TRUE)
{

$device_id=$this->input->post('device_id');
$device_token=$this->input->post('device_token');
$contact_no= $this->input->post('contact_no');
$input_otp= $this->input->post('otp');

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=1;

      			$this->db->select('*');
$this->db->from('tbl_otp');
$this->db->where('otp',$input_otp);
$this->db->where('contact_no',$contact_no);
$otp_data= $this->db->get()->row();

if(!empty($otp_data)){
		if($otp_data->otp == $input_otp){


			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('contact',$contact_no);
$user_data= $this->db->get()->row();

if(!empty($user_data)){
	$user_status= 1;


		$user_id= $user_data->id;
		$first_name=$user_data->first_name;
		$last_name=$user_data->last_name;
		$email=$user_data->email;
		$contact_no=$user_data->contact;
		$password=$user_data->password;
		$wallet_balance=$user_data->wallet;

		if(!empty($password)){
			$passwrd= $password;
		}else{
			$passwrd= "";
		}



		//device token update in tbl_users_device_token tabel every time of signin

		      			$this->db->select('*');
		$this->db->from('tbl_users_device_token');
		$this->db->where('user_id',$user_id);
		$device_t_data= $this->db->get()->row();

					if(!empty($device_t_data)){

						$data_update_usr= array (
							'device_token'=>$device_token,


						);

						$this->db->where('id', $device_t_data->id);
						$update_last_id=$this->db->update('tbl_users_device_token', $data_update_usr);

					}else{

						$data_insert_usr_device_token= array (
							'mac_id'=> $device_id,
							'device_token'=>$device_token,
							'user_id'=>$user_id,
							'create_at'=>$cur_date


						);

						$user_d_token_last_id=$this->base_model->insert_table("tbl_users_device_token",$data_insert_usr_device_token,1);
					}


		//device id update in users tabel every time of signin
		      $data_update= array (
		        'device_id'=>$device_id,


		      );

		      $this->db->where('id', $user_id);
		      $update_last_id=$this->db->update('tbl_users', $data_update);

		    //  user id update in cart tabel every time of signin

		      $this->db->select('*');
		      $this->db->from('tbl_cart');
		      $this->db->where('device_id',$device_id);
		      // $mac_cart_data= $this->db->get()->row();
		      $mac_cart_data= $this->db->get();

		      if(!empty($mac_cart_data)){
						foreach ($mac_cart_data->result() as $device) {

		            $data_updates= array (
		              'user_id'=>$user_id,

		            );

		            $this->db->where('device_id', $device->device_id);
		            $update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
									}
		          }


							//user id update in user_address tabel every time of signin

													$this->db->select('*');
							$this->db->from('tbl_user_address');
							$this->db->where('device_id',$device_id);
							$device_user_addr_data= $this->db->get();

							if(!empty($device_user_addr_data)){
								foreach ($device_user_addr_data as $user_addrs) {


										$data_updatess= array (
											'user_id'=>$user_data->id,


										);

										$this->db->where('device_id', $device_id);
										$update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
											}
									}





}else{
	$user_status= 0;
	$user_id= "";
	$first_name= "";
	$last_name= "";
	$email= "";
	$passwrd= "";
	$contact_no= "";
	$wallet_balance= "";
}


			$res = array('message'=>"success",
						'status'=>200,
						'user_status'=>$user_status,
						'user_id'=>$user_id,
						'firstname'=>$first_name,
						'lastname'=>$last_name,
						'email'=>$email,
						'password'=>$passwrd,
						'contact'=>$contact_no,
						'wallet'=>$wallet_balance,
						);

			echo json_encode($res);


		}else{

			$res = array('message'=>"OTP Not Matched.",
						'status'=>201
						);

			echo json_encode($res); exit;
		}
}else{

	$res = array('message'=>"Wrong OTP Entered.",
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



//Register by OTP Api for UnnatiRetail app

public function register_by_otp()

{

// if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('refer_user_id', 'refer_user_id', 'xss_clean');
$this->form_validation->set_rules('contact_no', 'contact_no', 'required|is_unique[tbl_users.contact]|xss_clean');
$this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean');
$this->form_validation->set_rules('last_name', 'last_name', 'required|xss_clean');
$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|is_unique[tbl_users.email]');
$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');



if($this->form_validation->run()== TRUE)
{

$refer_user_id=$this->input->post('refer_user_id');
$device_id=$this->input->post('device_id');
$device_token=$this->input->post('device_token');
$contact_no=$this->input->post('contact_no');
$first_name=$this->input->post('first_name');
$last_name=$this->input->post('last_name');
$email=$this->input->post('email');

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=1;


$passwrd=$this->random_string_password(8);
$pass=md5($passwrd);


if(empty($refer_user_id)){

//without sharable signup
$user_data_insert = array(

			 'device_id'=>$device_id,
			 'first_name'=>$first_name,
			 'last_name'=>$last_name,
			 'email'=>$email,
			 'contact'=>$contact_no,
			 'password'=>$pass,
				 'ip' =>$ip,
				 'added_by' =>$addedby,
				 'is_active' =>1,
				 'date'=>$cur_date

				 );

	} else{

//after share app signup

//add wallet gift amount to reffered new user for signup
						$user_data_insert = array(

									 'device_id'=>$device_id,
									 'first_name'=>$first_name,
									 'last_name'=>$last_name,
									 'email'=>$email,
									 'contact'=>$contact_no,
									 'password'=>$pass,
									 'wallet'=>0,
										 'ip' =>$ip,
										 'added_by' =>$addedby,
										 'is_active' =>1,
										 'date'=>$cur_date

										 );


//update wallet amount of user who share and refer app to new user
			 			// $this->db->select('*');
			 			// $this->db->from('tbl_users');
			 			// $this->db->where('id',$refer_user_id);
			 			// $usr_data= $this->db->get()->row();
						//
					  // if(!empty($usr_data)){
						//
						// 	$wallet_balance= $usr_data->wallet;
						// 	$last_wallet_amount= $wallet_balance + 20;
						//
					 	// 		$data_updatesss= array (
					 	// 			'wallet'=>$last_wallet_amount,
						//
						//
					 	// 		);
						//
					 	// 		$this->db->where('id', $usr_data->id);
					 	// 		$updated_wallet_user_id=$this->db->update('tbl_users', $data_updatesss);
						//
					 	// 	}

	 }



$last_id=$this->base_model->insert_table("tbl_users",$user_data_insert,1) ;



if($last_id != 0){


	//device token insert with last_user_id in tbl_users_device_token tabel e

							$this->db->select('*');
	$this->db->from('tbl_users_device_token');
	$this->db->where('user_id',$last_id);
	$device_t_data= $this->db->get()->row();

				if(empty($device_t_data)){

					$data_insert_usr_device_token= array (
						'mac_id'=> $device_id,
						'device_token'=>$device_token,
						'user_id'=>$last_id,
						'create_at'=>$cur_date


					);

					$user_d_token_last_id=$this->base_model->insert_table("tbl_users_device_token",$data_insert_usr_device_token,1);

				}



	//start reffered user and new signup user mapping
					$data_insert = array(
															'user_id'=>$refer_user_id,

										'last_id'=>$last_id,
										'ip'=>$ip,

										'date'=>$cur_date

										);



					$mapping_last_id=$this->base_model->insert_table("tbl_user_share_and_refer",$data_insert,1) ;

	//end reffered user and new signup user mapping


	// user id update in cart tabel time of signup

	 $this->db->select('*');
	 $this->db->from('tbl_cart');
	 $this->db->where('device_id',$device_id);
	 // $device_cart_data= $this->db->get()->row();
	 $device_cart_data= $this->db->get();


	 if(!empty($device_cart_data)){
		 foreach ($device_cart_data as $device) {
			 // code...

				 $data_updates= array (
					 'user_id'=>$last_id,


				 );

				 $this->db->where('device_id', $device_id);
				 $update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
					 }
			 }


			 //user id update in user_address tabel  time of signup

									 $this->db->select('*');
			 $this->db->from('tbl_user_address');
			 $this->db->where('device_id',$device_id);
			 $device_user_addr_data= $this->db->get();

			 if(!empty($device_user_addr_data)){
				 foreach ($device_user_addr_data as $user_addrs) {


						 $data_updatess= array (
							 'user_id'=>$last_id,


						 );

						 $this->db->where('device_id', $device_id);
						 $update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
							 }
					 }










      			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$last_id);
$user= $this->db->get()->row();

if(!empty($user)){

	$data= array (
		'id'=>$user->id,
		'firstname'=>$user->first_name,
		'lastname'=>$user->last_name,
		'email'=>$user->email,
		'password'=>$user->password,
						'contact'=>$user->contact,
						'wallet'=>$user->wallet

	);


	$res = array('message'=>"success",
				'status'=>200,
				'data'=>$data
				);

	echo json_encode($res); exit;
}



}else{

	$res = array('message'=>'Error Occured.',
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

echo json_encode($res);


}


}






//google register login api

public function google_signup()

{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('refer_user_id', 'refer_user_id', 'xss_clean');
$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');
$this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean');
$this->form_validation->set_rules('last_name', 'last_name', 'required|xss_clean');
// $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|is_unique[tbl_users.email]');
$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');

// $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
// $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');


if($this->form_validation->run()== TRUE)
{

$refer_user_id=$this->input->post('refer_user_id');
$device_id=$this->input->post('device_id');
$device_token=$this->input->post('device_token');

$name=$this->input->post('first_name');
$last_name=$this->input->post('last_name');
$email=$this->input->post('email');
$image=$this->input->post('image');
// $passw=$this->input->post('password');
// $phone_number=$this->input->post('phone');




//---------------image1------------------------------------------------



// 			$image_upload_folder = FCPATH . "assets/frontend/socialuploads/";
// 	if (!file_exists($image_upload_folder)){
// 		mkdir($image_upload_folder, DIR_WRITE_MODE, true);
// 	}
// $new_file_name="product1".date("Ymdhms");
// $this->upload_config = array(
// 	'upload_path'   => $image_upload_folder,
// 	'file_name' => $new_file_name,
// 	'allowed_types' =>'pdf|jpg|jpeg|png',
// 	'max_size'      => 25000
// );
// $this->upload->initialize($this->upload_config);
// if (!$this->upload->do_upload($img1))
// {
// 	$upload_error = $this->upload->display_errors();
// 	// echo json_encode($upload_error);
// 	echo $upload_error;
// }
// else
// {
// 	$file_info = $this->upload->data();
// 	$videoNAmePath = "assets/admin/products/".$new_file_name.$file_info['file_ext'];
// 	$file_info['new_name']=$videoNAmePath;
// 	// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
// 	$nnnn1=$file_info['file_name'];
// 	// echo json_encode($file_info);
// }



	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");



if(empty($refer_user_id)){

$data_insert = array('first_name'=>$name,
										 'last_name'=>$last_name,
										 'device_id'=>$device_id,

		'email'=>$email,
		'image'=>$image,
		'status'=>"GOOGLE",

		'ip' =>$ip,

		'is_active' =>1,
		'date'=>$cur_date

		);

}else{

//after share app signup

//add wallet gift amount to reffered new user for signup
	$data_insert = array('first_name'=>$name,
											 'last_name'=>$last_name,
											 'device_id'=>$device_id,

			'email'=>$email,
			'image'=>$image,
			'status'=>"GOOGLE",
			'wallet'=>0,

			'ip' =>$ip,

			'is_active' =>1,
			'date'=>$cur_date

			);

//update wallet amount of user who share and refer app to new user
				 			// $this->db->select('*');
				 			// $this->db->from('tbl_users');
				 			// $this->db->where('id',$refer_user_id);
				 			// $usr_data= $this->db->get()->row();
							//
						  // if(!empty($usr_data)){
							//
							// 	$wallet_balance= $usr_data->wallet;
							// 	$last_wallet_amount= $wallet_balance + 20;
							//
						 	// 		$data_updatesss= array (
						 	// 			'wallet'=>$last_wallet_amount,
							//
						 	// 		);
							//
						 	// 		$this->db->where('id', $usr_data->id);
						 	// 		$updated_wallet_user_id=$this->db->update('tbl_users', $data_updatesss);
							//
						 	// 	}

}


      			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('status',"GOOGLE");
$this->db->where('email',$email);
$google_user_data= $this->db->get()->row();

if(empty($google_user_data)){


	$this->db->select('*');
	$this->db->from('tbl_users');
	$this->db->where('email',$email);
	$usr_data= $this->db->get()->row();
	if(empty($usr_data)){

$last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

$user_status= 0;

//start reffered user and new signup user mapping
				$data_insert = array(
														'user_id'=>$refer_user_id,

									'last_id'=>$last_id,
									'ip'=>$ip,

									'date'=>$cur_date

									);



				$mapping_last_id=$this->base_model->insert_table("tbl_user_share_and_refer",$data_insert,1) ;

//end reffered user and new signup user mapping


}else{

	$res = array('message'=>"You are already registered with this email.Please login with this email and password.",
	'status'=>201
	);

	echo json_encode($res); exit;

}


}else{
	// $last_id = $google_user_data->id;

	if($google_user_data->contact == null && $google_user_data->contact == ""){
		$last_id = $google_user_data->id;
		$user_status= 0;
	}else{
		$last_id = $google_user_data->id;
		$user_status= 1;
	}


}

if($last_id!=0)
{


	//device token update in tbl_users_device_token tabel every time of signin

	      			$this->db->select('*');
	$this->db->from('tbl_users_device_token');
	$this->db->where('user_id',$last_id);
	$device_t_data= $this->db->get()->row();

				if(!empty($device_t_data)){

					$data_update_usr= array (
						'device_token'=>$device_token,


					);

					$this->db->where('id', $device_t_data->id);
					$update_last_id=$this->db->update('tbl_users_device_token', $data_update_usr);

				}else{

					$data_insert_usr_device_token= array (
						'mac_id'=> $device_id,
						'device_token'=>$device_token,
						'user_id'=>$last_id,
						'create_at'=>$cur_date


					);

					$user_d_token_last_id=$this->base_model->insert_table("tbl_users_device_token",$data_insert_usr_device_token,1);
				}



 // user id update in cart tabel time of signup

	$this->db->select('*');
	$this->db->from('tbl_cart');
	$this->db->where('device_id',$device_id);
	// $device_cart_data= $this->db->get()->row();
	$device_cart_data= $this->db->get();


	if(!empty($device_cart_data)){
		foreach ($device_cart_data as $device) {
			// code...

				$data_updates= array (
					'user_id'=>$last_id,


				);

				$this->db->where('device_id', $device_id);
				$update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
					}
			}




			// user id update in wishlist tabel time of signup

			// $this->db->select('*');
			// $this->db->from('tbl_wishlist');
			// $this->db->where('device_id',$device_id);
			// // $device_wish_data= $this->db->get()->row();
			// $device_wish_data= $this->db->get();
			//
			// if(!empty($device_wish_data)){
			// 	foreach ($device_wish_data as $device_wish) {
			// 			$data_updates= array (
			// 				'user_id'=>$last_id,
			//
			//
			// 			);
			//
			// 			$this->db->where('device_id', $device_id);
			// 			$update_last_cart_id=$this->db->update('tbl_wishlist', $data_updates);
			// 			}
			// 		}

			//user id update in user_address tabel  time of signup

									$this->db->select('*');
			$this->db->from('tbl_user_address');
			$this->db->where('device_id',$device_id);
			$device_user_addr_data= $this->db->get();

			if(!empty($device_user_addr_data)){
				foreach ($device_user_addr_data as $user_addrs) {


						$data_updatess= array (
							'user_id'=>$last_id,


						);

						$this->db->where('device_id', $device_id);
						$update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
							}
					}


					$this->db->select('*');
					$this->db->from('tbl_users');
					$this->db->where('id',$last_id);
					// $this->db->where('mac_id',$mac_id);
					$user_data= $this->db->get()->row();


					if($user_data->password == null){
						$passwrd= "";
					}else{
						$passwrd= $user_data->password;
					}

					if($user_data->contact == null){
						$contct= "";
					}else{
						$contct= $user_data->contact;
					}


					$data= array (
						'id'=>$user_data->id,
						'name'=>$user_data->first_name,
						'lastname'=>$user_data->last_name,
						'device_id'=>$device_id,
										'email'=>$user_data->email,
										'password'=>$passwrd,
										'contact'=>$contct,
										'status'=>$user_data->status,
										'image'=>$user_data->image,
										'wallet'=>$user_data->wallet,
										'user_status'=>$user_status

					);



$res = array('message'=>"success",
'status'=>200,
'data'=>$data

);

echo json_encode($res); exit;

}else{

$res = array('message'=>"failed",
'status'=>201
);

echo json_encode($res); exit;

}






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




//facebook register login api

public function facebook_signup()

{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('refer_user_id', 'refer_user_id', 'xss_clean');
$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');
$this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean');
$this->form_validation->set_rules('last_name', 'last_name', 'required|xss_clean');
// $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|is_unique[tbl_users.email]');
$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');

// $this->form_validation->set_rules('password', 'password', 'required|xss_clean');
// $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');


if($this->form_validation->run()== TRUE)
{

$refer_user_id=$this->input->post('refer_user_id');
$device_id=$this->input->post('device_id');
$device_token=$this->input->post('device_token');

$name=$this->input->post('first_name');
$last_name=$this->input->post('last_name');
$email=$this->input->post('email');
$image=$this->input->post('image');
// $passw=$this->input->post('password');
// $phone_number=$this->input->post('phone');




//---------------image1------------------------------------------------



// 			$image_upload_folder = FCPATH . "assets/frontend/socialuploads/";
// 	if (!file_exists($image_upload_folder)){
// 		mkdir($image_upload_folder, DIR_WRITE_MODE, true);
// 	}
// $new_file_name="product1".date("Ymdhms");
// $this->upload_config = array(
// 	'upload_path'   => $image_upload_folder,
// 	'file_name' => $new_file_name,
// 	'allowed_types' =>'pdf|jpg|jpeg|png',
// 	'max_size'      => 25000
// );
// $this->upload->initialize($this->upload_config);
// if (!$this->upload->do_upload($img1))
// {
// 	$upload_error = $this->upload->display_errors();
// 	// echo json_encode($upload_error);
// 	echo $upload_error;
// }
// else
// {
// 	$file_info = $this->upload->data();
// 	$videoNAmePath = "assets/admin/products/".$new_file_name.$file_info['file_ext'];
// 	$file_info['new_name']=$videoNAmePath;
// 	// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
// 	$nnnn1=$file_info['file_name'];
// 	// echo json_encode($file_info);
// }



	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");


if(empty($refer_user_id)){

//without sharable signup

$data_insert = array('first_name'=>$name,
										 'last_name'=>$last_name,
										 'device_id'=>$device_id,

		'email'=>$email,
		'image'=>$image,
		'status'=>"FACEBOOK",

		'ip' =>$ip,

		'is_active' =>1,
		'date'=>$cur_date

		);

}else{

	//after share app signup

	//add wallet gift amount to reffered new user for signup
				$data_insert = array('first_name'=>$name,
														 'last_name'=>$last_name,
														 'device_id'=>$device_id,

						'email'=>$email,
						'image'=>$image,
						'status'=>"FACEBOOK",
						'wallet'=>0,

						'ip' =>$ip,

						'is_active' =>1,
						'date'=>$cur_date

						);

	//update wallet amount of user who share and refer app to new user
					 			// $this->db->select('*');
					 			// $this->db->from('tbl_users');
					 			// $this->db->where('id',$refer_user_id);
					 			// $usr_data= $this->db->get()->row();
								//
							  // if(!empty($usr_data)){
								//
								// 	$wallet_balance= $usr_data->wallet;
								// 	$last_wallet_amount= $wallet_balance + 20;
								//
							 	// 		$data_updatesss= array (
							 	// 			'wallet'=>$last_wallet_amount,
								//
							 	// 		);
								//
							 	// 		$this->db->where('id', $usr_data->id);
							 	// 		$updated_wallet_user_id=$this->db->update('tbl_users', $data_updatesss);
								//
							 	// 	}

	}




      			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('status',"FACEBOOK");
$this->db->where('email',$email);
$facebook_user_data= $this->db->get()->row();

if(empty($facebook_user_data)){

	$this->db->select('*');
	$this->db->from('tbl_users');
	$this->db->where('email',$email);
	$usr_data= $this->db->get()->row();
	if(empty($usr_data)){

$last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

$user_status= 0;
//start reffered user and new signup user mapping
				$data_insert = array(
														'user_id'=>$refer_user_id,

									'last_id'=>$last_id,
									'ip'=>$ip,

									'date'=>$cur_date

									);



				$mapping_last_id=$this->base_model->insert_table("tbl_user_share_and_refer",$data_insert,1) ;

//end reffered user and new signup user mapping


}else{

	$res = array('message'=>"You are already registered with this email.Please login with this email and password.",
	'status'=>201
	);

	echo json_encode($res); exit;

}

}else{
	// $last_id = $facebook_user_data->id;

	if($facebook_user_data->contact == null && $facebook_user_data->contact == ""){
		$last_id = $facebook_user_data->id;
		$user_status= 0;
	}else{
		$last_id = $facebook_user_data->id;
		$user_status= 1;
	}

}

if($last_id!=0)
{


	//device token update in tbl_users_device_token tabel every time of signin

	      			$this->db->select('*');
	$this->db->from('tbl_users_device_token');
	$this->db->where('user_id',$last_id);
	$device_t_data= $this->db->get()->row();

				if(!empty($device_t_data)){

					$data_update_usr= array (
						'device_token'=>$device_token,


					);

					$this->db->where('id', $device_t_data->id);
					$update_last_id=$this->db->update('tbl_users_device_token', $data_update_usr);

				}else{

					$data_insert_usr_device_token= array (
						'mac_id'=> $device_id,
						'device_token'=>$device_token,
						'user_id'=>$last_id,
						'create_at'=>$cur_date


					);

					$user_d_token_last_id=$this->base_model->insert_table("tbl_users_device_token",$data_insert_usr_device_token,1);
				}



 // user id update in cart tabel time of signup

	$this->db->select('*');
	$this->db->from('tbl_cart');
	$this->db->where('device_id',$device_id);
	// $device_cart_data= $this->db->get()->row();
	$device_cart_data= $this->db->get();


	if(!empty($device_cart_data)){
		foreach ($device_cart_data as $device) {
			// code...

				$data_updates= array (
					'user_id'=>$last_id,


				);

				$this->db->where('device_id', $device_id);
				$update_last_cart_id=$this->db->update('tbl_cart', $data_updates);
					}
			}




			// user id update in wishlist tabel time of signup

			// $this->db->select('*');
			// $this->db->from('tbl_wishlist');
			// $this->db->where('device_id',$device_id);
			// // $device_wish_data= $this->db->get()->row();
			// $device_wish_data= $this->db->get();
			//
			// if(!empty($device_wish_data)){
			// 	foreach ($device_wish_data as $device_wish) {
			// 			$data_updates= array (
			// 				'user_id'=>$last_id,
			//
			//
			// 			);
			//
			// 			$this->db->where('device_id', $device_id);
			// 			$update_last_cart_id=$this->db->update('tbl_wishlist', $data_updates);
			// 			}
			// 		}

			//user id update in user_address tabel  time of signup

									$this->db->select('*');
			$this->db->from('tbl_user_address');
			$this->db->where('device_id',$device_id);
			$device_user_addr_data= $this->db->get();

			if(!empty($device_user_addr_data)){
				foreach ($device_user_addr_data as $user_addrs) {


						$data_updatess= array (
							'user_id'=>$last_id,


						);

						$this->db->where('device_id', $device_id);
						$update_last_cart_id=$this->db->update('tbl_user_address', $data_updatess);
							}
					}


					$this->db->select('*');
					$this->db->from('tbl_users');
					$this->db->where('id',$last_id);
					// $this->db->where('mac_id',$mac_id);
					$user_data= $this->db->get()->row();



					if($user_data->password == null){
						$passwrd= "";
					}else{
						$passwrd= $user_data->password;
					}

					if($user_data->contact == null){
						$contct= "";
					}else{
						$contct= $user_data->contact;
					}



					$data= array (
						'id'=>$user_data->id,
						'name'=>$user_data->first_name,
						'last_name'=>$user_data->last_name,
						'device_id'=>$device_id,
										'email'=>$user_data->email,
										'password'=>$passwrd,
										'contact'=>$contct,
										'status'=>$user_data->status,
										'image'=>$user_data->image,
										'wallet'=>$user_data->wallet,
										'user_status'=>$user_status

					);



$res = array('message'=>"success",
'status'=>200,
'data'=>$data

);

echo json_encode($res); exit;

}else{

$res = array('message'=>"failed",
'status'=>201
);

echo json_encode($res); exit;

}






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





//update phone in social user signup
public function googleOrfacebookSignUp()

{

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('device_id', 'device_id', 'required|xss_clean');
$this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean');
$this->form_validation->set_rules('user_id', 'user_id', 'required|xss_clean');
$this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');




if($this->form_validation->run()== TRUE)
{

$device_id=$this->input->post('device_id');
$user_id=$this->input->post('user_id');
$device_token=$this->input->post('device_token');


$phone_number=$this->input->post('phone');

	$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
	$cur_date=date("Y-m-d H:i:s");

$passwrd=$this->random_string_password(8);
$pass=md5($passwrd);

// die();


	$this->db->select('*');
	$this->db->from('tbl_users');
	$this->db->where('id',$user_id);
	// $this->db->where('mac_id',$mac_id);
	$user_data= $this->db->get()->row();

if(!empty($user_data)){

	$data_updatess= array (
		'contact'=>$phone_number,
		'password'=>$pass

	);


      			$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('contact',$phone_number);
$user_cntct_data= $this->db->get()->row();
if(empty($user_cntct_data)){

	$this->db->where('id', $user_data->id);
	$update_last_user_id=$this->db->update('tbl_users', $data_updatess);

}else{

	$res = array('message'=>"This phone number is already exist.",
	'status'=>201
	);

	echo json_encode($res); exit;

}






}

if($update_last_user_id!=0)
{

					$this->db->select('*');
					$this->db->from('tbl_users');
					$this->db->where('id',$user_id);
					// $this->db->where('mac_id',$mac_id);
					$user_datass= $this->db->get()->row();


					if($user_datass->password == null){
						$passwrd= "";
					}else{
						$passwrd= $user_datass->password;
					}

					if($user_datass->contact == null){
						$contct= "";
					}else{
						$contct= $user_datass->contact;
					}



					$data= array (
						'id'=>$user_datass->id,
						'name'=>$user_datass->first_name,
						'lastname'=>$user_datass->last_name,
						'device_id'=>$device_id,
		                'email'=>$user_datass->email,
										'password'=>$passwrd,
										'contact'=>$contct,
										'wallet'=>$user_datass->wallet

		      );



$res = array('message'=>"success",
'status'=>200,
'data'=>$data

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


//generate unique password string
function random_string_password($length_of_string)
{

    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length_of_string);
}




//forgot password  api

public function forgot_password_process(){
// if(empty($this->session->userdata('user_data'))){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post()){

$this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');

	if($this->form_validation->run()== TRUE){
$email=$this->input->post('email');

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('email',$email);
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
$n1=$da->first_name ;
$n2=$da->id;
$auth_code=$this->generateRandomString();
$j=0;
for ($i=0; $i < 100; $i++) {

$this->db->select('*');
$this->db->from('tbl_user_forget_password');
$this->db->where('auth_code',$auth_code);
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
$auth_code=$this->generateRandomString();
}else{
 break;
}
}

$data_insert = array('auth_code'=>$auth_code,
		'link_status'=>0,
		'status'=>0,
		'user_id'=>$n2,
		'ip' =>$ip,
		'date'=>$cur_date
		);

$last_id=$this->base_model->insert_table("tbl_user_forget_password",$data_insert,1);

if($last_id!=0){

$config = Array(
			 'protocol' => 'smtp',
			 'smtp_host' => 'mail.fineoutput.website',
			 'smtp_port' => 26,
			 'smtp_user' => 'info@fineoutput.website', // change it to yours
			 'smtp_pass' => 'info@fineoutput2019', // change it to yours
			 'mailtype' => 'html',
			 'charset' => 'iso-8859-1',
			 'wordwrap' => TRUE
		 );
$to=$email;
$data['name'] = $n1;


$link=base_url().'customer/forget_password_verify/'.base64_encode($auth_code);
$data['link'] =$link;

$message = 	$this->load->view('frontend/emails/forgot-password',$data,TRUE);

// $message = 'Hello '.$n1.'<br/><br/>
// you have requested to reset your password, Here is the link<br/>'.$link.'<br/>click on the link and reset your password. Please remember that link can be used only once<br/><br/>Thanks';
$this->load->library('email', $config);
$this->email->set_newline("");
$this->email->from('info@fineoutput.website'); // change it to yours
$this->email->to($to);// change it to yours
$this->email->subject('Reset your password');
$this->email->message($message);
if($this->email->send()){
 // echo 'Email sent.';
}else{
 // show_error($this->email->print_debugger());
}


$res = array('message'=>"Email sent successfully",
'status'=>200,


);

echo json_encode($res); exit;

}
else{

	$res = array('message'=>"Sorry error occured",
	'status'=>201,


	);

	echo json_encode($res); exit;


}
}else{

	$res = array('message'=>"Sorry Email Id not registered, Please sign up first",
	'status'=>201,


	);

	echo json_encode($res); exit;

}
	}else{


		$res = array('message'=>validation_errors(),
		'status'=>201,


		);

		echo json_encode($res); exit;

}

}else{

	$res = array('message'=>"Please insert some data, No data available",
	'status'=>201,


	);

	echo json_encode($res); exit;


}
// }else{
// 	redirect("home","refresh");
// }

// echo json_encode($res);
}








// GENERATE OTP
public function get_random_password($chars_min=6, $chars_max=6, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
{
    $length = rand($chars_min, $chars_max);
    $selection = '123456789';
    if($include_numbers) {
        $selection .= "1234567890";
    }
    if($include_special_chars) {
        $selection .= "!@";
    }

    $password = "";
    for($i=0; $i<$length; $i++) {
        $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
        $password .=  $current_letter;
    }

  return $password;

}



function generateRandomString($length = 20) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%$@*!';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


}
