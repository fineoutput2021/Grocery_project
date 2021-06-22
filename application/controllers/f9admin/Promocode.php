<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'core/CI_finecontrol.php');
class Promocode extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
}

public function view_promocode(){


             if(!empty($this->session->userdata('admin_data'))){


               $data['user_name']=$this->load->get_var('user_name');

               // echo SITE_NAME;
               // echo $this->session->userdata('image');
               // echo $this->session->userdata('position');
               // exit;
               $this->db->select('*');
               $this->db->from('tbl_promocode');
               //$this->db->where('',);
               $data['promocode']= $this->db->get();

               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/promocode/view_promocode');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }


   }

      public function add_promocode(){

          if(!empty($this->session->userdata('admin_data'))){


            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;


            $this->load->view('admin/common/header_view',$data);
            $this->load->view('admin/promocode/add_promocode');
            $this->load->view('admin/common/footer_view');

        }
        else{

           redirect("login/admin_login","refresh");
        }

        }

        public function update_promocode($idd){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

               $id=base64_decode($idd);
              $data['promocode_id']=$idd;

                    $this->db->select('*');
                     $this->db->from('tbl_promocode');
                     $this->db->where('id',$id);
                     $data['promocode_data']= $this->db->get()->row();


              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/promocode/update_promocode');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

public function add_promocode_data($t,$iw="")

        {

          if(!empty($this->session->userdata('admin_data'))){


    $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->helper('security');
      if($this->input->post())
      {
        // print_r($this->input->post());
        // exit;
  $this->form_validation->set_rules('promocode', 'promocode', 'required|xss_clean|trim');
  $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
  $this->form_validation->set_rules('percent', 'percent', 'required|xss_clean|trim');
  $this->form_validation->set_rules('minimum_amount', 'minimum_amount', 'required|xss_clean|trim');
  $this->form_validation->set_rules('maximum_gift_amount', 'maximum_gift_amount', 'required|xss_clean|trim');
  $this->form_validation->set_rules('expiry_date', 'expiry_date', 'required|xss_clean|trim');


        if($this->form_validation->run()== TRUE)
        {
          $promocode=$this->input->post('promocode');
          $type=$this->input->post('type');
          $percent=$this->input->post('percent');
          $minimum_amount=$this->input->post('minimum_amount');
          $maximum_gift_amount=$this->input->post('maximum_gift_amount');
          $expiry_date=$this->input->post('expiry_date');


            $cur_date=date("Y-m-d H:i:s");

            $addedby=$this->session->userdata('admin_id');

    $typ=base64_decode($t);
    if($typ==1){

    $data_insert = array('promocode'=>$promocode,
              'type'=>$type,
              'percent'=>$percent,
              'minimum_amount' =>$minimum_amount,
              'maximum_gift_amount'=>$maximum_gift_amount,
              'expiry_date'=>$expiry_date,
              'date'=>$cur_date,
              'added_by' =>$addedby,
              'is_active' =>1,
              );
        $last_id=$this->base_model->insert_table("tbl_promocode",$data_insert,1) ;

    }
    if($typ==2){

      $idw=base64_decode($iw);


      $data_update = array('promocode'=>$promocode,
                'type'=>$type,
                'percent'=>$percent,
                'minimum_amount' =>$minimum_amount,
                'maximum_gift_amount'=>$maximum_gift_amount,
                'expiry_date'=>$expiry_date,
                'date'=>$cur_date,
                'added_by' =>$addedby,
                'is_active' =>1,
                );
      $this->db->where('id', $idw);
      $last_id=$this->db->update('tbl_promocode', $data_update);
    }
                        if($last_id!=0){
                          $message = '';
                          if($typ==2){
                            $message = 'Data updated successfully';
                          }else{
                            $message = 'Data inserted successfully';
                          }
                        $this->session->set_flashdata('smessage',$message);

                        redirect("dcadmin/promocode/view_promocode","refresh");

                            }else{

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

        public function updatepromocodeStatus($idd,$t){

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
                $zapak=$this->db->update('tbl_promocode', $data_update);

                     if($zapak!=0){
                     redirect("dcadmin/promocode/view_promocode","refresh");
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
                  $zapak=$this->db->update('tbl_promocode', $data_update);

                      if($zapak!=0){
                      redirect("dcadmin/promocode/view_promocode","refresh");
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



        public function delete_promocode($idd){

               if(!empty($this->session->userdata('admin_data'))){


                 $data['user_name']=$this->load->get_var('user_name');

                 $id=base64_decode($idd);

                if($this->load->get_var('position')=="Super Admin"){


                  $zapak=$this->db->delete('tbl_promocode', array('id' => $id));
if($zapak!=0){
$this->session->set_flashdata('emessage','Data Deleted Successfully');

redirect("dcadmin/promocode/view_promocode","refresh");
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



public function validatePromoCode(){


   $data['data'] = '';

     // POST data
     if($this->input->post()){
       $userInput_promoCode = $this->input->post('userInput_promoCode');
       $order_final_amount = $this->input->post('order_final_amount');

       $user_id = $this->session->userdata('customer_id');
       if(!empty($userInput_promoCode) ){

         $this->db->select('*');
               $this->db->from('tbl_promocode');
               $this->db->where('promocode',$userInput_promoCode);
               $dsa= $this->db->get();
               $da=$dsa->row();
               if(!empty($da)){
                 $db_expiry_date = $da->expiry_date;
                 $db_promocode_type = $da->type;
                 $db_promocode_minimum_amount = $da->minimum_amount;
                 $db_promocode_percent = $da->percent;
                $db_promocode_maximum_gift_amount = $da->maximum_gift_amount;
                $cur_date=date("Y-m-d");

                 if($cur_date <= $db_expiry_date){
                   if($db_promocode_type == 1){
                    //if type its one time check in order_applied
                      $this->db->select('*');
                            $this->db->from('tbl_promocode_applied');
                            $this->db->where('user_id',$user_id);
                            $this->db->where('promocode_id',$da->id);
                            $dsa= $this->db->get();
                            $da=$dsa->row();
                            if(!empty($da)){
                              $data['data'] = false;
                              $data['response_msg'] = 'You\'ve already applied this promocode.';
                              echo json_encode($data);
                              return false;
                            }
                  }

                          if($order_final_amount >= $db_promocode_minimum_amount ){

                            if($db_promocode_percent <= 100){
                              $calc = $db_promocode_percent / 100;
                              $deduction_amount = $calc * $order_final_amount;

                              if($deduction_amount > $db_promocode_maximum_gift_amount){
                                $deduction_amount = $db_promocode_maximum_gift_amount;
                              }

                              $calculated_final_amount = $order_final_amount - (int) $deduction_amount;
                              $data['data'] = true;
                              $data['response_msg'] = 'Promocode applied successfully.';
                              $data['calculated_final_amount'] = $calculated_final_amount;
                              $data['deduction_amount'] = (int) $deduction_amount;
                              echo json_encode($data);
                              return true;

                          }else{
                              $data['data'] = false;
                              $data['response_msg'] = 'Invalid Promocode';
                              echo json_encode($data);
                              return false;
                          }


                          }else{
                            $data['data'] = false;
                            $data['response_msg'] = 'Your order amount should be greater than '.$db_promocode_minimum_amount.' to apply this promo code.';
                            echo json_encode($data);
                            return false;
                          }



}else{
$data['data'] = false;
$data['response_msg'] = 'Promocode is expired!';
echo json_encode($data);
return false;
}
               }
             else{
               $data['data'] = false;
               $data['response_msg'] = 'Invalid Promocode !';
               echo json_encode($data);
               return false;
             }

       }else{
       $data['data'] = false;
       $data['response_msg'] = 'Promocode Cannot be empty';
       echo json_encode($data);
       return false;
     }
    }
   echo json_encode($data);

}




}
