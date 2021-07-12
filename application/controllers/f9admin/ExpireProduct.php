<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class ExpireProduct extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_expiry_products(){

            if(!empty($this->session->userdata('admin_data'))){

              $cur_date=date("Y-m-d");
              $next_15days_after_date=  date('Y-m-d', strtotime('+15 days'));

                           $this->db->select('*');
               $this->db->from('tbl_product');
               $this->db->where('expire_date',$next_15days_after_date);
               $this->db->where('is_cat_delete', 0);
               $this->db->where('is_subcat_delete', 0);
               $this->db->where('is_subcate2_delete', 0);
               $data['product_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/expiry_products/view_expiry_products');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }


    }

      ?>
