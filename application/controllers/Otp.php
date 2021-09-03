<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Otp extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}



public function get_otp(){

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');

  if($this->input->post())
  {
    $this->form_validation->set_rules('contact_no','contact_no','required|trim|xss_clean');

    if($this->form_validation->run()== TRUE)
    {
      $contact_no = $this->input->post('contact_no');

// echo $contact_no; die();

                $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->where('contact',$contact_no);
    $da_login= $this->db->get();
    $lgin = $da_login->row();
// echo $lgin; die();
    if(!empty($lgin)) {

      $contact_no = $lgin->contact;

      $ip = $this->input->ip_address();
    date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");

      $this->session->unset_userdata('contact_num');

      $this->session->set_userdata('contact_num',$contact_no);

      // $OTP = $this->get_random_password(6,6);
      $OTP = 123456;

      // $msg="Welcome to govindretail and Your One Time Password (OTP) for Login Into your account is.".$OTP ;

      // $msg="Welcome to aubasket.com and Your One Time Password (OTP) for Login Into your account is.".$OTP ;
			//message code
					$msg= "Welcome to unnatiretail.com and Your One Time Password (OTP) for Login Into your account is ".$OTP."." ;
					// $msg= base64_encode(base64_encode($msgs));
					// $msg="Thank you for making payment of Rs 10." ;

					$curl = curl_init();

					curl_setopt_array($curl, array(
					 CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?authkey=URL&mobiles=".$contact_no."&country=91&message=".$msg."&sender=SENDER_ID&route=4",
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



$data_insert = array(
  'contact_no'=>$contact_no,
  'otp'=>$OTP,
    'ip' =>$ip,
    'is_active' =>1,
    'date'=>$cur_date
);

$last_id=$this->base_model->insert_table("tbl_otp",$data_insert,1) ;


$this->session->unset_userdata('otp_id');

$this->session->set_userdata('otp_id',$last_id);


$this->session->set_flashdata('popup',1);
$this->session->set_flashdata('number',$contact_no);
$this->session->set_flashdata('emessage','OTP send successfully');

redirect($_SERVER['HTTP_REFERER'],"refresh");
    }
    else{
// echo "string"; die();

			$this->session->unset_userdata('contact_num');

			$this->session->set_userdata('contact_num',$contact_no);

			// $OTP = $this->get_random_password(6,6);
			$OTP = 123456;

			// $msg="Welcome to govindretail and Your One Time Password (OTP) for Login Into your account is.".$OTP ;

			// $msg="Welcome to aubasket.com and Your One Time Password (OTP) for Login Into your account is.".$OTP ;
			//message code
					$msg= "Welcome to unnatiretail.com and Your One Time Password (OTP) for Login Into your account is ".$OTP."." ;
					// $msg= base64_encode(base64_encode($msgs));
					// $msg="Thank you for making payment of Rs 10." ;

					// $curl = curl_init();
					//
					// curl_setopt_array($curl, array(
					//  CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?authkey=339861A13aKfk2FeIn60e6bf5aP1&mobiles=".$contact_no."&country=91&message=".$msg."&sender=FINEOU&route=4",
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
					// // echo $err;  print_r($response); die();
					// // echo $contact_no; echo $err; print_r($response); print_r($curl); die();
					// curl_close($curl);
					//
					// if ($err) {
					//  echo "cURL Error #:" . $err;
					// } else
					// {
					// // echo $response; die();
					// }
// echo "hi"; die();


		$data_insert = array(
		'contact_no'=>$contact_no,
		'otp'=>$OTP,
		'ip' =>$ip,
		'is_active' =>1,
		'date'=>$cur_date
		);

		$last_id=$this->base_model->insert_table("tbl_otp",$data_insert,1) ;


		$this->session->unset_userdata('otp_id');

		$this->session->set_userdata('otp_id',$last_id);



$this->session->set_flashdata('emessage','Please Enter OTP.');
$this->session->set_flashdata('popup',1);
$this->session->set_flashdata('number',$contact_no);
$this->session->set_flashdata('emessage','OTP send successfully');

      // redirect("auth/login","refresh");
    redirect($_SERVER['HTTP_REFERER']);
    // redirect("home/about","refresh");
    }

    }

    else{

    $this->session->set_flashdata('header_emessage',validation_errors());
    redirect($_SERVER['HTTP_REFERER']);

    }


  }else{

  		$this->session->set_flashdata('header_emessage','Please insert some data, No data available');
  		redirect($_SERVER['HTTP_REFERER']);

  }

}






public function verify_get_otp()
{
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {
    // $this->form_validation->set_rules('contact_no', 'contact_no', 'required|xss_clean');
    $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean');

    if($this->form_validation->run()== TRUE)
    {
      $contact_no= $this->session->userdata('contact_num');
      $otp_id= $this->session->userdata('otp_id');
      $input_otp= $this->input->post('otp');

      $ip = $this->input->ip_address();
      date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");

            $this->db->select('*');
      $this->db->from('tbl_otp');
      $this->db->where('id',$otp_id);
      $this->db->where('contact_no',$contact_no);
      $otp_data= $this->db->get()->row();

      if(!empty($otp_data)){
      if($otp_data->otp == $input_otp){
                    $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('contact',$contact_no);
        $da_lgin_otp= $this->db->get()->row();

        if(!empty($da_lgin_otp)){
          // $user_status= 1;

          $name=$da_lgin_otp->first_name;
          $contact_no=$da_lgin_otp->contact;

$this->session->set_userdata('user_data',1);
$this->session->set_userdata('user_id',$da_lgin_otp->id);
$this->session->set_userdata('user_name',$name);
$this->session->set_userdata('contact',$contact_no);

$this->session->unset_userdata('contact_num');
$this->session->unset_userdata('otp_id');


$this->session->set_flashdata('smessage','Logged in successfully');
redirect('home/index','refresh');
}else{
 // need to do signup
 $this->session->set_flashdata('emessage','Kindly Singup before login');
  redirect('home/sign_up','refresh');
}
       }else{
         $this->session->set_flashdata('emessage','Wrong OTP Entered');
				 $this->session->set_flashdata('number',$contact_no);
				 $this->session->set_flashdata('popup',1);
         redirect($_SERVER['HTTP_REFERER']);
       }
     }else{
       $this->session->set_flashdata('emessage','Some Error occured');
			 $this->session->set_flashdata('number',$contact_no);
			 $this->session->set_flashdata('popup',1);
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


public function sign_up()
{

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');


  if($this->input->post())
     {
       // print_r($this->input->post());
       // exit; // same
       	 $this->form_validation->set_rules('name', 'name', 'required');

       if($this->form_validation->run()== TRUE)
       {

        	 $name=$this->input->post('name');
  $contact_no= $this->session->userdata('contact_num');


      // exit;


          $ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
          $cur_date=date("Y-m-d H:i:s");

          // $addedby=$this->session->userdata('user_id');

  // $addedby=1;





            $data_insert = array(
                 	 'first_name'=>$name,
                 	 'contact'=>$contact_no,

                      'ip' =>$ip,
                      // 'added_by' =>$addedby,
                      'is_active' =>1,
                      'date'=>$cur_date

                      );


      $last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

if($last_id != 0){


  $this->session->set_userdata('user_data',1);
  $this->session->set_userdata('user_id',$last_id);
  $this->session->set_userdata('user_name',$name);
  $this->session->set_userdata('contact',$contact_no);


  $this->session->unset_userdata('contact_num');
  $this->session->unset_userdata('otp_id');


  $this->session->set_flashdata('smessage','Signup in successfully');
  redirect('home/index','refresh');
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

public function logout(){

  if(!empty($this->session->userdata('user_data'))){
    $this->session->unset_userdata('user_data');
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('user_name');
    $this->session->unset_userdata('contact');

    $this->session->set_flashdata('smessage','Logout successfully');
    redirect('home/index','refresh');

  }
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
