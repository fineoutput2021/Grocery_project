<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Notifications extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_notifications(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');
              //$user_id= $this->session->userdata('admin_data');
              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;


                                          $this->db->select('*');
                                          $this->db->from('tbl_notification');
                                          $this->db->where('is_read',0);
                                        $notification_data= $this->db->get();
                                        //print_r($notification_data->result());

                                      if(!empty($notification_data)){
                                        foreach($notification_data->result() as $notify){
                                          $id=$notify->id;

                                          $data_update = array(
                                          'is_read'=>1
                                          );

                                          $this->db->where('id', $id);
                                          $this->db->where('is_read', 0);
                                          $updated_notification=$this->db->update('tbl_notification', $data_update);

                                        }
                                      }


              $this->db->select('*');
               $this->db->from('tbl_notification');
               //$this->db->where('user_id',$user_id);
               $this->db->order_by('id','DESC');
               $data['notification_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/notification/view_notification');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }



               // public function update_notification_status(){
               //
               //     // if(!empty($this->session->userdata('admin_data'))){
               //
               //
               //       $data['user_name']=$this->load->get_var('user_name');
               //
               //       // echo SITE_NAME;
               //       // echo $this->session->userdata('image');
               //       // echo $this->session->userdata('position');
               //       // exit;
               //
               //
               //
               //              $this->db->select('*');
               //              $this->db->from('tbl_notification');
               //              $this->db->where('is_read',0);
               //            $notification_data= $this->db->get();
               //            //print_r($notification_data->result());
               //
               //          if(!empty($notification_data)){
               //            foreach($notification_data->result() as $notify){
               //              $id=$notify->id;
               //
               //              $data_update = array(
               //              'is_read'=>1
               //              );
               //
               //              $this->db->where('id', $id);
               //              $this->db->where('is_read', 0);
               //              $updated_notification=$this->db->update('tbl_notification', $data_update);
               //
               //            }
               //          }
               //          echo json_encode($updated_notification);
               //
               //   // }
               //   // else{
               //   //
               //   //    redirect("login/admin_login","refresh");
               //   // }
               //
               //   }


                      }

      ?>
