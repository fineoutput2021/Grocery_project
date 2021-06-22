<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Delivery_slots extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_delivery_slots(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

                           $this->db->select('*');
               $this->db->from('tbl_delivery_slots');
               //$this->db->where('id',$usr);
               $data['delivery_slots_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/delivery_slots/view_delivery_slots');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_delivery_slots(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/delivery_slots/add_delivery_slots');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_delivery_slots($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_delivery_slots');
                            $this->db->where('id',$id);
                            $data['delivery_slots_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/delivery_slots/update_delivery_slots');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_delivery_slots_data($t,$iw=""){

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {

  $this->form_validation->set_rules('from_time', 'from_time', 'required');
  $this->form_validation->set_rules('to_time', 'to_time', 'required');
  $this->form_validation->set_rules('orders_limit', 'orders_limit', 'required');

       if($this->form_validation->run()== TRUE)
               {
  $from_time=$this->input->post('from_time');
  $to_time=$this->input->post('to_time');
  $orders_limit=$this->input->post('orders_limit');

                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){

             $ts_arr1 = array();
             $ts_arr2 = array();
              $this->db->select('*');
             $this->db->from('tbl_delivery_slots');
             $ds_d1= $this->db->get();
             foreach($ds_d1->result() as $dd1) {

             $db_from_time =$dd1->from_time;
             $db_to_time =$dd1->to_time;

             for($ts=(int)$db_from_time;$ts<=(int)$db_to_time;$ts++){

               $ts_arr1[] = $ts;

             }
           }
           for($user_ts=(int)$from_time;$user_ts<=(int)$to_time;$user_ts++){

             $ts_arr2[] = $user_ts;

           }

           if(empty(array_intersect($ts_arr1, $ts_arr2))){



           $data_insert = array(
                  'from_time'=>$from_time,
  'to_time'=>$to_time,
  'orders_limit'=>$orders_limit,
                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_delivery_slots",$data_insert,1) ;
}else{

  $this->session->set_flashdata('emessage',"This slot is already taken");
redirect($_SERVER['HTTP_REFERER']);


}
           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_delivery_slots');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();





           $data_insert = array(
                  'from_time'=>$from_time,
  'to_time'=>$to_time,
  'orders_limit'=>$orders_limit,

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_delivery_slots', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/delivery_slots/view_delivery_slots","refresh");
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

               public function updatedelivery_slotsStatus($idd,$t){

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
                       $zapak=$this->db->update('tbl_delivery_slots', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/delivery_slots/view_delivery_slots","refresh");
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
                         $zapak=$this->db->update('tbl_delivery_slots', $data_update);

                             if($zapak!=0){
                             redirect("dcadmin/delivery_slots/view_delivery_slots","refresh");
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



               public function delete_delivery_slots($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

 $zapak=$this->db->delete('tbl_delivery_slots', array('id' => $id));
 if($zapak!=0){

        redirect("dcadmin/delivery_slots/view_delivery_slots","refresh");
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
                      }

      ?>
