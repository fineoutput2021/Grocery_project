<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Delivery_users extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_delivery_users(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

                           $this->db->select('*');
               $this->db->from('tbl_delivery_users');
               //$this->db->where('id',$usr);
               $data['delivery_users_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/delivery_users/view_delivery_users');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_delivery_users(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/delivery_users/add_delivery_users');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_delivery_users($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_delivery_users');
                            $this->db->where('id',$id);
                            $data['delivery_users_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/delivery_users/update_delivery_users');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_delivery_users_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('name', 'name', 'required');
  $this->form_validation->set_rules('email', 'email', 'required');
  $this->form_validation->set_rules('password', 'password', 'required');
  $this->form_validation->set_rules('change_password', 'change_password', '');






               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
  $email=$this->input->post('email');
  $password=$this->input->post('password');
  $change_password=$this->input->post('change_password');


                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){



           $data_insert = array(
                  'name'=>$name,
  'email'=>$email,
  'password'=>md5($password),

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_delivery_users",$data_insert,1) ;

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_delivery_users');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();


if(!empty($change_password)){


             $data_insert = array(
                    'name'=>$name,
    'email'=>$email,
    'password'=>md5($change_password)
                       );
}else{

             $data_insert = array(
                    'name'=>$name,
    'email'=>$email

                       );
}

             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_delivery_users', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/delivery_users/view_delivery_users","refresh");
                              }
                               else
                                   {

                                    $this->session->set_flashdata('emessage','Sorry error occured');
                                    redirect($_SERVER['HTTP_REFERER']);
                                  }
               }
             else{

        $this->session->set_flashdata('emessage',validation_errors());
      redirect($_SERVER['HTTP_REFERER']);

             }

             }
           else{

 $this->session->set_flashdata('emessage','Please insert some data, No data available');
      redirect($_SERVER['HTTP_REFERER']);

           }
           }
           else{

       redirect("login/admin_login","refresh");


           }

           }

               public function updatedelivery_usersStatus($idd,$t){

                        if(!empty($this->session->userdata('admin_data'))){


                          $data['user_name']=$this->load->get_var('user_name');

                          // echo SITE_NAME;
                          // echo $this->session->userdata('image');
                          // echo $this->session->userdata('position');
                          // exit;
                          $id=base64_decode($idd);

                          if($t=="active"){

                            $data_update = array(
                        'is_active'=>1

                        );

                        $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_delivery_users', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/delivery_users/view_delivery_users","refresh");
                                    }
                                    else
                                    {
        $this->session->set_flashdata('emessage','Sorry error occured');
          redirect($_SERVER['HTTP_REFERER']);
                                    }
                          }
                          if($t=="inactive"){
                            $data_update = array(
                         'is_active'=>0

                         );

                         $this->db->where('id', $id);
                         $zapak=$this->db->update('tbl_delivery_users', $data_update);

                             if($zapak!=0){
                             redirect("dcadmin/delivery_users/view_delivery_users","refresh");
                                     }
                                     else
                                     {

                $this->session->set_flashdata('emessage','Sorry error occured');
                  redirect($_SERVER['HTTP_REFERER']);
                                     }
                          }



                      }
                      else{

                         redirect("login/admin_login","refresh");

                      }

                      }



               public function delete_delivery_users($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

 $zapak=$this->db->delete('tbl_delivery_users', array('id' => $id));
 if($zapak!=0){

        redirect("dcadmin/delivery_users/view_delivery_users","refresh");
                }
                else
                {
                   $this->session->set_flashdata('emessage','Sorry error occured');
                   redirect($_SERVER['HTTP_REFERER']);
                }
            }
            else{
             $this->session->set_flashdata('emessage','Sorry you not a super admin you dont have permission to delete anything');
               redirect($_SERVER['HTTP_REFERER']);
            }


                            }
                            else{

                        redirect("login/admin_login","refresh");

                            }

                            }

                            public function login_process(){

                            $this->load->helper(array('form', 'url'));
                            $this->load->library('form_validation');
                            $this->load->helper('security');

                            if($this->input->post())
                            {
                            // $referer = $this->input->get('referer');
                            // if(empty($referer)){
                            // $referer = '';
                            // }
                            $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
                            $this->form_validation->set_rules('password', 'password', 'required|xss_clean|trim');
                            $this->form_validation->set_rules('device_token', 'device_token', 'required|xss_clean|trim');
                            $this->form_validation->set_rules('mac_id', 'mac_id', 'required|xss_clean|trim');
                            if($this->form_validation->run()== TRUE)
                            {

                            $email=$this->input->post('email');
                            $passw=$this->input->post('password');
                            $device_token=$this->input->post('device_token');
                            $mac_id=$this->input->post('mac_id');

                            $pass=md5($passw);

                            date_default_timezone_set("Asia/Calcutta");
                            $cur_date=date("Y-m-d H:i:s");

                            $this->db->select('*');
                            $this->db->from('tbl_delivery_users');
                            $this->db->where('email',$email);
                            // $this->db->where('password',$pass);
                            $da_customer= $this->db->get();
                            $da=$da_customer->row();
                            if(!empty($da)){

                            $db_name=$da->name;
                            $db_email=$da->email;
                            $db_password=$da->password;
                            //$db=$da->password;


                            if($db_password==$pass){
                            // $db_contact=$da->contact;
                            $db_id=$da->id;

//update device token coloumn

$data_update1 = array(
'device_token'=>$device_token,

);

$this->db->where('id', $db_id);
$updateData=$this->db->update('tbl_delivery_users', $data_update1);

// insert/update device token by mac_id in tbl_delivery_users_device_token tbl

            $this->db->select('*');
$this->db->from('tbl_delivery_users_device_token');
$this->db->where('mac_id',$mac_id);
$mac_id_data= $this->db->get()->row();

if(empty($mac_id_data)){

//insert Data

  $data_inserts = array(
  'email'=>$email,
  'mac_id'=>$mac_id,
  'device_token'=>$device_token,
  'date'=>$cur_date,

  );


  $updateData=$this->db->insert('tbl_delivery_users_device_token', $data_inserts);

}
else{

  $id=$mac_id_data->id;

  $data_update2 = array(
  'device_token'=>$device_token,

  );

  $this->db->where('id', $id);
  $updateData=$this->db->update('tbl_delivery_users_device_token', $data_update2);
}



                            // $this->session->set_userdata('user_data',1);
                            // $this->session->set_userdata('customer_name', $db_first_name);
                            // $this->session->set_userdata('customer_id', $db_id);

                            //	redirect("home","refresh");
                            $data['status']="success";
                            $data['user_id']=$db_id;
                            $data['user_name']= $db_name;
                            $data['response_msg'] = "Successfully Logged in!";
                            // $data['referer'] = $referer;
                            }
                            else{
                            $data['status']="error";
                            $data['response_msg']='Invalid Password';

                            }
                            }
                            else{
                            $data['response_msg']='Invalid Credentials!';
                            $data['status']="error";

                            }
                            }
                            else{
                            $data['status']="error";
                            $data['response_msg']=validation_errors();
                            }
                            echo json_encode($data);
                            }
                            }

//logout process celivery app

public function logout_process(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');

if($this->input->post())
{
// $referer = $this->input->get('referer');
// if(empty($referer)){
// $referer = '';
// }

$this->form_validation->set_rules('mac_id', 'mac_id', 'required|xss_clean|trim');
if($this->form_validation->run()== TRUE)
{


$mac_id=$this->input->post('mac_id');



date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

$this->db->select('*');
$this->db->from('tbl_delivery_users_device_token');
$this->db->where('mac_id',$mac_id);
$mac_id_data= $this->db->get()->row();

if(!empty($mac_id_data)){

  $id=$mac_id_data->id;

  $data_update2 = array(
  'device_token'=>"",

  );

  $this->db->where('id', $id);
  $updateData=$this->db->update('tbl_delivery_users_device_token', $data_update2);
if($updateData != 0){

  $data['status']="success";

  $data['response_msg'] = "Successfully Logout!";
}


}else{
  $data['status']="error";
  $data['response_msg']=" delevery user not exist!";
}



}
else{
$data['status']="error";
$data['response_msg']=validation_errors();
}
echo json_encode($data);
}
}





                            public function view_profile(){

                            $this->load->helper(array('form', 'url'));
                            $this->load->library('form_validation');
                            $this->load->helper('security');
                            if($this->input->post())
                            {

                            $this->form_validation->set_rules('delivery_user_id', 'delivery_user_id', 'required|xss_clean|trim');

                            if($this->form_validation->run()== TRUE)
                            {

                            $delivery_user_id=$this->input->post('delivery_user_id');

                            $this->db->select('*');
                            $this->db->from('tbl_delivery_users');
                            $this->db->where('id',$delivery_user_id);
                            $da_user_dsa= $this->db->get()->row();


                              $data["user_data"] = $da_user_dsa;
                              $data['status']="success";
                              $data['response_msg'] = "User Fetched Successfully!";

                            }
                            else{
                            $data['status']="error";
                            $data['response_msg']=validation_errors();
                            }
                            echo json_encode($data);
                            }
                            }

                            public function orders(){

                            $this->load->helper(array('form', 'url'));
                            $this->load->library('form_validation');
                            $this->load->helper('security');
                            if($this->input->post())
                            {

                            $this->form_validation->set_rules('delivery_user_id', 'delivery_user_id', 'required|xss_clean|trim');

                            if($this->form_validation->run()== TRUE)
                            {

                            $delivery_user_id=$this->input->post('delivery_user_id');

$query = "SELECT tr.order_id ,o.delivery_status,o.order_status, o.payment_type , tr.status, DATE_FORMAT(tr.date, '%D %b %Y') as date , o.total_amount ,u.contact ,  CONCAT(u.first_name, ' ' , u.last_name) as customer_name , ua.address , ua.doorflat , ua.area , ua.landmark , ua.city , ua.state , ua.zipcode , ua.latitude , ua.longitude  FROM tbl_transfer_orders tr ";
$query = $query . "INNER JOIN tbl_order1 o ON o.id = tr.order_id ";
$query = $query . "INNER JOIN tbl_users u ON o.user_id = u.id ";
$query = $query . "INNER JOIN tbl_user_address ua ON o.address_id = ua.id ";
$query = $query . "where tr.delivery_user_id = ".$delivery_user_id;
$query = $query . " ORDER BY tr.id desc";


                          $da_orders_dsa= $this->db->query($query);

                              $data["orders_data"] = $da_orders_dsa->result();
                              $data['status']="success";
                              $data['response_msg'] = "Orders Fetched Successfully!";

                            }
                            else{
                            $data['status']="error";
                            $data['response_msg']=validation_errors();
                            }
                            echo json_encode($data);
                            }
                            }


                  public function products(){

                  $this->load->helper(array('form', 'url'));
                  $this->load->library('form_validation');
                  $this->load->helper('security');
                  if($this->input->post())
                  {

                  $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean|trim');

                  if($this->form_validation->run()== TRUE)
                  {

                  $order_id=$this->input->post('order_id');
                  $base_url = base_url();
                  $query = "SELECT p.name as product_name , CONCAT('".$base_url."' , p.image1)  as product_image ,  u.name as unit_name ,  o2.quantity , o2.amount FROM tbl_order2 o2 ";
                  $query = $query . " INNER JOIN tbl_product p ON p.id = o2.product_id";
                  $query = $query . " INNER JOIN tbl_units u ON u.id = o2.unit_id";
                  $query = $query . " where o2.main_id = ".$order_id;
                  $query = $query . " ORDER BY o2.id desc";


                  $da_orders_dsa= $this->db->query($query);

                  $data["products_data"] = $da_orders_dsa->result();
                  $data['status']="success";
                  $data['response_msg'] = "Products Fetched Successfully!";

                  }
                  else{
                  $data['status']="error";
                  $data['response_msg']=validation_errors();
                  }
                  echo json_encode($data);
                  }
                  }


        public function updateDeliveryStatus_accept($id){

            $data_update = array(
        'delivery_status'=>2
          );

        $this->db->where('id', $id);
       $zapak=$this->db->update('tbl_order1', $data_update);

             if($zapak!=0){
               $data['status']="success";
               $data['response_msg'] = "Order has dispatched!";
                     }
                     else{
                        $data['status']="error";
                        $data['response_msg']='Sorry error occured';
                     }
           echo json_encode($data);
          }

          public function updateDeliveryStatus_finish($id){

              $data_update = array(
          'delivery_status'=>3
            );

          $this->db->where('id', $id);
         $zapak=$this->db->update('tbl_order1', $data_update);

               if($zapak!=0){
                 $data['status']="success";
                 $data['response_msg'] = "Order has Delivered!";
                       }
                       else{
                          $data['status']="error";
                          $data['response_msg']='Sorry error occured';
                       }
             echo json_encode($data);
            }






    }
      ?>
