<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Users extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_users(){

            if(!empty($this->session->userdata('admin_data'))){



               $this->db->select('*');
               $this->db->from('tbl_users');
               $this->db->where('is_hidden',0);
               $data['users_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/users/view_users');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

          public function view_user_cart($id){

             if(!empty($this->session->userdata('admin_data'))){

               $idd= base64_decode($id);


                $this->db->select('*');
                $this->db->from('tbl_cart');
                $this->db->where('user_id',$idd);
                $data['users_cart_data']= $this->db->get();

               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/users/view_user_cart');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }



// cart categories

public function view_cart_cate($id){

   if(!empty($this->session->userdata('admin_data'))){

$data['user_id'] = $id;
     $idd= base64_decode($id);



      $this->db->select('*');
      $this->db->from('tbl_category');
      // $this->db->where('user_id',$idd);
      $this->db->where('is_active',1);
      $data['category_data']= $this->db->get();

     $this->load->view('admin/common/header_view',$data);
     $this->load->view('admin/users/view_cart_category');
     $this->load->view('admin/common/footer_view');

 }
 else{

    redirect("login/admin_login","refresh");
 }

 }



 // cart categories

 public function view_cart_product($user_id,$cat_id){

    if(!empty($this->session->userdata('admin_data'))){

 $data['user_id'] = $user_id;
 $data['category_id'] = $cat_id;

      $cat_idd= base64_decode($cat_id);



       $this->db->select('*');
       $this->db->from('tbl_product');
       $this->db->where('category_id',$cat_idd);
       // $this->db->where('category_id',$cat_idd);
       $this->db->where('is_cat_delete',0);
       $this->db->where('is_active',1);
       $data['product_data']= $this->db->get();

      $this->load->view('admin/common/header_view',$data);
      $this->load->view('admin/users/view_cart_product');
      $this->load->view('admin/common/footer_view');

  }
  else{

     redirect("login/admin_login","refresh");
  }

  }



          public function view_user_address($user_id){

             if(!empty($this->session->userdata('admin_data'))){
                $this->db->select('*');
                $this->db->from('tbl_user_address');
                $this->db->where('user_id',base64_decode($user_id));
                $data['user_address_data']= $this->db->get();

               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/users/view_user_address');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }



              public function add_users(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/users/add_users');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }


public function add_wallet_blance($id){

   if(!empty($this->session->userdata('admin_data'))){
$data['user_ids']= $id;
     $this->load->view('admin/common/header_view');
     $this->load->view('admin/users/add_wallet_blance', $data);
     $this->load->view('admin/common/footer_view');

 }
 else{

    redirect("login/admin_login","refresh");
 }

 }



public function add_wallet_amount_process($idd)

  {

    if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
  // print_r($this->input->post());
  // exit;
$this->form_validation->set_rules('amount', 'amount', 'required|xss_clean|trim');





  if($this->form_validation->run()== TRUE)
  {
$amount=$this->input->post('amount');

      $ip = $this->input->ip_address();
      date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");
      $addedby=$this->session->userdata('admin_id');


$u_id=base64_decode($idd);


$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$u_id);
$dsa=$this->db->get();
$da=$dsa->row();



if(!empty($da)){

$org_wlt_amu= $da->wallet;
$new_wlt_amu= $org_wlt_amu + $amount;

$data_insert = array(
     'wallet'=>$new_wlt_amu


        );
$this->db->where('id', $u_id);
$last_id=$this->db->update('tbl_users', $data_insert);

}


          if($last_id!=0){

            $transaction_data_insert = array(
                 'type'=> 2,
                 'wallet_amount'=>$amount,
                 'ip'=>$ip,
                 'date'=>$cur_date,
                 'added_by'=>$addedby,
                 'user_id'=>$u_id,



                    );

             $last_id=$this->base_model->insert_table("tbl_wallet_transaction",$transaction_data_insert,1) ;

                  $this->session->set_flashdata('smessage','Data inserted successfully');
                  redirect("dcadmin/users/view_users","refresh");
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


//wallet transaction view
public function view_wallet_transaction(){

   if(!empty($this->session->userdata('admin_data'))){
      $this->db->select('*');
      $this->db->from('tbl_wallet_transaction');
      $data['transaction_data']= $this->db->get();

     $this->load->view('admin/common/header_view',$data);
     $this->load->view('admin/users/view_wallet_transaction');
     $this->load->view('admin/common/footer_view');

 }
 else{

    redirect("login/admin_login","refresh");
 }

 }



               public function update_users($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_users');
                            $this->db->where('id',$id);
                            $data['users_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/users/update_users');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_users_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('first_name', 'first_name', 'required|xss_clean|trim');
  $this->form_validation->set_rules('last_name', 'last_name', 'required|xss_clean|trim');
  $this->form_validation->set_rules('email', 'email', 'is_unique[tbl_users.email]|xss_clean|trim');
  $this->form_validation->set_rules('contact', 'contact', 'is_unique[tbl_users.contact]|required|xss_clean|trim');
  $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');





               if($this->form_validation->run()== TRUE)
               {
  $first_name=$this->input->post('first_name');
  $last_name=$this->input->post('last_name');
  $email=$this->input->post('email');
  $contact=$this->input->post('contact');
  $password=$this->input->post('password');

                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           if($typ==1){



           $data_insert = array(
                  'first_name'=>$first_name,
  'last_name'=>$last_name,
  'email'=>$email,
  'contact'=>$contact,
  'password'=>md5($password),

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_users');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();





           $data_insert = array(
                  'first_name'=>$first_name,
  'last_name'=>$last_name,
  'email'=>$email,
  'contact'=>$contact,
  'password'=>md5($password),

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_users', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/users/view_users","refresh");
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

               public function updateusersStatus($idd,$t){

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
                       $zapak=$this->db->update('tbl_users', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/users/view_users","refresh");
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
                         $zapak=$this->db->update('tbl_users', $data_update);

                             if($zapak!=0){
                             redirect("dcadmin/users/view_users","refresh");
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



               public function delete_users($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     // $this->db->select('image');
                     // $this->db->from('tbl_users');
                     // $this->db->where('id',$id);
                     // $dsa= $this->db->get();
                     // $da=$dsa->row();
                     // $img=$da->image;

 $zapak=$this->db->delete('tbl_users', array('id' => $id));
 if($zapak!=0){
        // $path = FCPATH .$img;
        //   unlink($path);
        redirect("dcadmin/users/view_users","refresh");
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


//add to cart

public function add_to_cart_data()

  {

    if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
  // print_r($this->input->post());
  // exit;
$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('part', 'unit_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('qty', 'quantity', 'required|xss_clean|trim');
$this->form_validation->set_rules('userId', 'userId', 'required|xss_clean|trim');






  if($this->form_validation->run()== TRUE)
  {
$product_id=$this->input->post('product_id');
$unit_id=$this->input->post('part');
$qty=$this->input->post('qty');
$user_id=$this->input->post('userId');
$userId=base64_decode($user_id);



      $ip = $this->input->ip_address();
      date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");
      $addedby=$this->session->userdata('admin_id');

// $typ=base64_decode($t);

if($qty ==  0){

// echo $delivery_date;
// echo $today_date;
// echo "yes"; die();
  $this->session->set_flashdata('emessage',"0 Quantity Is not allowed.");
       redirect($_SERVER['HTTP_REFERER']);

}




$unit_id_inv_id = 0;
$check_quantity = 0;










$data_insert = array(
     'product_id'=>$product_id,
'unit_id'=>$unit_id,
'quantity'=>$qty,
'user_id'=>$userId,


        'ip' =>$ip,
        'added_by' =>$addedby,
        'date'=>$cur_date
        );


            $this->db->select('*');
$this->db->from('tbl_admin_cart');
$this->db->where('user_id',$userId);
$this->db->where('product_id',$product_id);
$ad_cart= $this->db->get()->row();

if(empty($ad_cart)){


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
    $this->db->where('unit_id',$unit_id);
    $product_unit_dsa = $this->db->get()->row();

    if(!empty($product_unit_dsa)){
        $db_ratio = $product_unit_dsa->ratio;
        $check_quantity = $db_ratio * $qty;
    }

  }

  if($product_unit_type == 2){
  $unit_id_inv_id = $unit_id;
  $check_quantity = $qty;
  }
  }


//inventory check

  $this->db->select('*');
  $this->db->from('tbl_inventory');
  $this->db->where('product_id',$product_id);
  $this->db->where('unit_id',$unit_id_inv_id);
  $tbl_inventory_dsa_data =  $this->db->get()->row();

    if(!empty($tbl_inventory_dsa_data)){
      $db_qty = $tbl_inventory_dsa_data->stock;

      if($check_quantity <= $db_qty){


$last_id=$this->base_model->insert_table("tbl_admin_cart",$data_insert,1) ;



}else{

  $this->session->set_flashdata('emessage','Product is out of stock.');
  redirect($_SERVER['HTTP_REFERER']);

}
}else{

  $this->session->set_flashdata('emessage','Product is out of stock.');
  redirect($_SERVER['HTTP_REFERER']);

}



}else{

  $this->session->set_flashdata('emessage','This product is already in your cart');
  redirect($_SERVER['HTTP_REFERER']);

}

          if($last_id!=0){
                  $this->session->set_flashdata('smessage','Product added to cart successfully');
                  // redirect("dcadmin/users/view_cart_product","refresh");
                  redirect($_SERVER['HTTP_REFERER']);
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




//update cart

public function update_admin_cart_data()

  {

    if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
  // print_r($this->input->post());
  // exit;
$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('part', 'unit_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('qty', 'quantity', 'required|xss_clean|trim');
$this->form_validation->set_rules('userId', 'userId', 'required|xss_clean|trim');






  if($this->form_validation->run()== TRUE)
  {
$product_id=$this->input->post('product_id');
$unit_id=$this->input->post('part');
$qty=$this->input->post('qty');
$user_id=$this->input->post('userId');
$userId=base64_decode($user_id);



      $ip = $this->input->ip_address();
      date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");
      $addedby=$this->session->userdata('admin_id');

// $typ=base64_decode($t);

if($qty ==  0){

// echo $delivery_date;
// echo $today_date;
// echo "yes"; die();
  $this->session->set_flashdata('emessage',"0 Quantity Is not allowed.");
       redirect($_SERVER['HTTP_REFERER']);

}




$unit_id_inv_id = 0;
$check_quantity = 0;










$data_updates = array(
     // 'product_id'=>$product_id,
'unit_id'=>$unit_id,
'quantity'=>$qty,
// 'user_id'=>$userId,


        // 'ip' =>$ip,
        // 'added_by' =>$addedby,
        // 'date'=>$cur_date
        );


            $this->db->select('*');
$this->db->from('tbl_admin_cart');
$this->db->where('user_id',$userId);
$this->db->where('product_id',$product_id);
$ad_cart= $this->db->get()->row();

if(!empty($ad_cart)){

$cart_id= $ad_cart->id;

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
    $this->db->where('unit_id',$unit_id);
    $product_unit_dsa = $this->db->get()->row();

    if(!empty($product_unit_dsa)){
        $db_ratio = $product_unit_dsa->ratio;
        $check_quantity = $db_ratio * $qty;
    }

  }

  if($product_unit_type == 2){
  $unit_id_inv_id = $unit_id;
  $check_quantity = $qty;
  }
  }


//inventory check

  $this->db->select('*');
  $this->db->from('tbl_inventory');
  $this->db->where('product_id',$product_id);
  $this->db->where('unit_id',$unit_id_inv_id);
  $tbl_inventory_dsa_data =  $this->db->get()->row();

    if(!empty($tbl_inventory_dsa_data)){
      $db_qty = $tbl_inventory_dsa_data->stock;

      if($check_quantity <= $db_qty){




$this->db->where('id', $cart_id);
$this->db->where('product_id', $product_id);
$last_id=$this->db->update('tbl_admin_cart', $data_updates);



}else{

  $this->session->set_flashdata('emessage','Product is out of stock.');
  redirect($_SERVER['HTTP_REFERER']);

}
}else{

  $this->session->set_flashdata('emessage','Product is out of stock.');
  redirect($_SERVER['HTTP_REFERER']);

}



}else{

  $this->session->set_flashdata('emessage','This product is already in your cart');
  redirect($_SERVER['HTTP_REFERER']);

}

          if($last_id!=0){
                  $this->session->set_flashdata('smessage','Product added to cart successfully');
                  // redirect("dcadmin/users/view_cart_product","refresh");
                  redirect($_SERVER['HTTP_REFERER']);
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




public function view_admin_user_cart($id){

   if(!empty($this->session->userdata('admin_data'))){

     $idd= base64_decode($id);
$data['id']=$idd;

      $this->db->select('*');
      $this->db->from('tbl_admin_cart');
      $this->db->where('user_id',$idd);
      $data['users_cart_data']= $this->db->get();

      $this->load->view('admin/common/header_view',$data);
      $this->load->view('admin/users/view_admin_user_cart');
      $this->load->view('admin/common/footer_view');
 }
 else{

    redirect("login/admin_login","refresh");
 }

 }

public function checkout_admin($idd){

                 if(!empty($this->session->userdata('admin_data'))){

 $id=base64_decode($idd);
$data['id']=$idd;

                            $this->db->select('*');
                $this->db->from('tbl_user_address');
                $this->db->where('user_id',$id);
                $data['address']= $this->db->get();


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/users/checkout_admin');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }


            public function checkout_data($t)

              {

      if(!empty($this->session->userdata('admin_data'))){


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
$this->form_validation->set_rules('address_id', 'address_id', 'trim|xss_clean');
$this->form_validation->set_rules('address', 'address', 'xss_clean|trim');
$this->form_validation->set_rules('slot_id', 'slot_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('delivery_date', 'delivery_date', 'required|trim|xss_clean');
$this->form_validation->set_rules('payment', 'payment', 'required|xss_clean');
$this->form_validation->set_rules('promocode', 'promocode', 'trim|xss_clean');

              if($this->form_validation->run()== TRUE)
              {

                $user_id= base64_decode($t);
                 $user_id=base64_decode($user_id);

                $address_id=$this->input->post('address_id');
                $address=$this->input->post('new_address');
                $slot_id=$this->input->post('slot_id');
                $delivery_date=$this->input->post('delivery_date');
                $payment=$this->input->post('payment');
                $applied_promocode=$this->input->post('promocode');

if(empty($address)){
// echo "no address"; die();
  $adr_id=$address_id;
}
else{
  // echo "yes address"; die();
  $data_insertss = array(
            'address'=>$address,
            'user_id'=>$user_id,


            );





$adr_id=$this->base_model->insert_table("tbl_user_address",$data_insertss,1) ;


}

// echo "out address"; die();


$today_date= date("Y-m-d");
//datecheck
if($delivery_date ==  $today_date){

// echo $delivery_date;
// echo $today_date;
// echo "yes"; die();
  $this->session->set_flashdata('emessage',"Sorry! Today's date is not allowed for delivery, Please select another date.");
       redirect($_SERVER['HTTP_REFERER']);

}


// echo "no"; die();




                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');




                  $slot_order_limit = 0;
                  $this->db->select('*');
                        $this->db->from('tbl_delivery_slots');
                        $this->db->where('id',$slot_id);
                        $slot_data= $this->db->get()->row();
                        if(!empty($slot_data)){
                          $slot_order_limit = $slot_data->orders_limit;
                        }

                  $this->db->select('*');
                  $this->db->from('tbl_order1');
                  $this->db->where('order_status',1);
                  $this->db->where('delivery_slot_id',$slot_id);
                  $this->db->where('delivery_date',$delivery_date);

                  $ordered_slots = $this->db->get()->num_rows();

                //slot-check
                  if($slot_order_limit > $ordered_slots){

// echo $user_id; die();

                  //insert into order1 tabel



                    $data_insert = array(
                    'user_id'=>$user_id,
                    'address_id'=>$adr_id,
                    'payment_type'=>$payment,
                    'payment_status'=>1,
                    'order_status'=>2,
                    'delivery_slot_id'=>$slot_id,
                    'delivery_date'=>$delivery_date,
                    'date'=>$cur_date,
                    'last_update_date'=>$cur_date,
                    'ip'=>$ip,
                    'total_amount' =>0,
                    'checkout_from' =>2

                       );


                $order1_last_id=$this->base_model->insert_table("tbl_order1",$data_insert,1);


                //inventory-checked with cart tabel Products

                $this->db->select('*');
                $this->db->from('tbl_admin_cart');
                $this->db->where('user_id',$user_id);
                $user_cart= $this->db->get();

                // print_r($user_cart->result()); die();
                $total_amount = 0;
                foreach($user_cart->result() as $item) {
                $selling_price = 0;
                $loop_item_product_id = $item->product_id;
                $loop_item_unit_id = $item->unit_id;
                $stock = $item->quantity;
                $this->db->select('*');
                $this->db->from('tbl_product');
                $this->db->where('id',$loop_item_product_id);
                $product_data_dsa = $this->db->get()->row();
                if(!empty($product_data_dsa)){
                $product_unit_type = $product_data_dsa->product_unit_type;

                if($product_unit_type == 1){
                  $loop_item_unit_id = 0;

                  $this->db->select('*');
                  $this->db->from('tbl_product_units');
                  $this->db->where('product_id',$loop_item_product_id);
                  $this->db->where('unit_id',$item->unit_id);
                  $product_unit_dsa = $this->db->get()->row();

                    if(!empty($product_unit_dsa)){
                    $db_ratio = $product_unit_dsa->ratio;
                      $stock = $db_ratio * $item->quantity;
                    }

                }
                }

                $this->db->select('*');
                $this->db->from('tbl_inventory');
                $this->db->where('unit_id',$loop_item_unit_id);
                $this->db->where('product_id',$loop_item_product_id);
                $dsa= $this->db->get()->row();
                if(!empty($dsa)){





                $db_pro_stock = $dsa->stock;
                if($db_pro_stock >= $stock){

                $total_pro_stock = $db_pro_stock - $stock;

                $data_update = array(
                'stock'=>$total_pro_stock
                );
                $this->db->where('id', $dsa->id);
                $this->db->update('tbl_inventory', $data_update);

                $data_transaction_insert2 = array(
                'product_id'=>$item->product_id,
                'unit_id'=>$item->unit_id,
                'stock'=>$stock,
                'type'=>3,
                'ip' =>$ip,
                'added_by' =>$user_id,
                'is_active' =>1,
                'date'=>$cur_date
                );


                $this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);





                //insert into order2 tabel

                $this->db->select('*');
                    $this->db->from('tbl_product_units');
                    $this->db->where('unit_id',$item->unit_id);
                    $this->db->where('product_id',$item->product_id);
                    $pu_data= $this->db->get()->row();
                    if(!empty($pu_data)){

                       $selling_price = $pu_data->selling_price * $item->quantity ;
                    }

                $order2_insert = array(
                'main_id'=>$order1_last_id,
                'product_id'=>$item->product_id,
                'unit_id'=>$item->unit_id,
                'quantity'=>$item->quantity,
                'date'=>$cur_date,
                'amount' =>$selling_price,
                'ip'=> $this->input->ip_address()
                 );
                  $this->base_model->insert_table("tbl_order2",$order2_insert,1) ;

                  $total_amount  = $total_amount + $selling_price;



                }
                else{

                  $this->session->set_flashdata('emessage',"Sorry! This product is out of stock");
                       redirect($_SERVER['HTTP_REFERER']);
                }
                }
                else{


                  $this->session->set_flashdata('emessage',"Sorry! This product's inventory is not exist");
                       redirect($_SERVER['HTTP_REFERER']);

                }


                }
                // echo $total_amount; die();
                // $order1_last_id;



                //promocode
                if(!empty($applied_promocode)){


                    $total_amount = $this->isValidPromocode($order1_last_id,$total_amount,$applied_promocode,$user_id);
                }

                // echo "hsy";
                // echo $total_amount; die();

                if($total_amount <= 100 ){
                $deliveryCharge= 30;
                $amount_subtotal= $total_amount + $deliveryCharge;

                $data_update = array(
                   'total_amount'=>$amount_subtotal,
                   'delivery_charge'=>$deliveryCharge
                  );

                }else{
                $deliveryCharge= 0;
                $amount_subtotal= $total_amount;
                $data_update = array(
                 'total_amount'=>$amount_subtotal,
                 'delivery_charge'=>$deliveryCharge
                );
                }



                $this->db->where('id', $order1_last_id);
                $this->db->update('tbl_order1', $data_update);

                $check= 	$this->db->delete('tbl_admin_cart', array('user_id' => $user_id));

                // 	$this->db->select('*');
                // 	$this->db->from('tbl_cart');
                // 	$this->db->where("user_id",$user_id);
                // 	//$this->db->where("is_cat_delete", 0);
                // 	$cart_products_data= $this->db->get();
                //
                // if(!empty($cart_products_data)){
                // // echo "wes"; die();
                // 	 foreach ($cart_products_data->result()  as $cart_product) {
                //
                //
                // $data['cart_deleted']= $this->db->delete('tbl_cart', array('id' => $cart_product->id));
                // 		 // $this->db->where('id', $cat_product->id);
                // 		 // $this->db->where("is_cat_delete", 0);
                // 		 // $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
                // 	 }
                // }


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

                  $this->db->select('*');
                        $this->db->from('tbl_users');
                        $this->db->where('id',$user_id);
                        $user_data= $this->db->get()->row();
                $email = '';
                        if(!empty($user_data)){
                          $email =  $user_data->email;
                        }

                  $to=$email;

                  $email_data = array("order1_id"=>$order1_last_id
                  );

                  $message = 	$this->load->view('frontend/emails/order-success',$email_data,TRUE);
                  // $message = 	"HELLO";
                  $this->load->library('email', $config);
                  $this->email->set_newline("");
                  $this->email->from('info@fineoutput.website'); // change it to yours
                  $this->email->to($to);// change it to yours
                  $this->email->subject('Order Placed Successfully');
                  $this->email->message($message);
                  if($this->email->send()){
                  //  echo 'Email sent.';
                  }else{
                  // show_error($this->email->print_debugger());
                  }

$var_user= base64_encode($user_id);

                  $this->session->set_flashdata('smessage',"order Success.");
                    redirect("dcadmin/Users/view_cart_cate/".$var_user,"refresh");

                     }
                     else{


                       $this->session->set_flashdata('emessage',"Sorry! This slot is not available for Delivery.Please select another date and try again.");
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


public function delete_admin_cart($id){

   if(!empty($this->session->userdata('admin_data'))){

     $idd= base64_decode($id);


      $this->db->select('*');
      $this->db->from('tbl_admin_cart');
      $this->db->where('id',$idd);
      $ad_user_cart_d= $this->db->get()->row();

if(!empty($ad_user_cart_d)){
  $zapak=$this->db->delete('tbl_admin_cart', array('id' => $idd));

}
  if($zapak != 0){
    $this->session->set_flashdata('smessage','Product removed from cart successfully');
    redirect($_SERVER['HTTP_REFERER']);
  }else{
    $this->session->set_flashdata('emessage','Sorry error occured');
    redirect($_SERVER['HTTP_REFERER']);
  }



 }
 else{

    redirect("login/admin_login","refresh");
 }

 }


//valid promocode check

public function isValidPromocode($inputOrderId,$final_amount,$userInput_promoCode,$userId){

                $user_id = $userId;
                $db_promocode_id = 0;
                    $this->db->select('*');
                    $this->db->from('tbl_promocode');
                    $this->db->where('promocode',$userInput_promoCode);
                    $dsa= $this->db->get();
                    $da=$dsa->row();
                    if(!empty($da)){
                      $db_promocode_id = $da->id;
                      $db_expiry_date = $da->expiry_date;
                      $db_promocode_type = $da->type;
                      $db_promocode_minimum_amount = $da->minimum_amount;
                      $db_promocode_percent = $da->percent;
                     $db_promocode_maximum_gift_amount = $da->maximum_gift_amount;
                     $cur_date=date("Y-m-d");

                      if($cur_date <= $db_expiry_date){
                        if($db_promocode_type == 1){
                                 $this->db->select('*');
                                 $this->db->from('tbl_promocode_applied');
                                 $this->db->where('user_id',$user_id);
                                 $this->db->where('promocode_id',$da->id);
                                 $dsa= $this->db->get();
                                 $da=$dsa->row();
                                 if(!empty($da)){
                                   return $final_amount;
                                 }
                       }

                               if($final_amount >= $db_promocode_minimum_amount ){

                                 if($db_promocode_percent <= 100){
                                   $calc = $db_promocode_percent / 100;
                                   $deduction_amount = $calc * $final_amount;

                                   if($deduction_amount > $db_promocode_maximum_gift_amount){
                                     $deduction_amount = $db_promocode_maximum_gift_amount;
                                   }

                                   $calculated_final_amount = $final_amount - (int) $deduction_amount;
                                   $current_date=date("Y-m-d");
                                  $data_insert = array(
                                            'user_id'=>$user_id,
                                            'order_id'=>$inputOrderId,
                                            'promocode_id'=>$db_promocode_id,
                                            'date'=>$current_date

                                            );
                                          $this->base_model->insert_table("tbl_promocode_applied",$data_insert,1) ;



                                   return $calculated_final_amount;

                               }else{
                                 return $final_amount;
                               }


                               }else{
                                 return $final_amount;
                               }



             }else{
               return $final_amount;
             }
                    }else{
                      return $final_amount;
                    }

            }




}

      ?>
