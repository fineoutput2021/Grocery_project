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




         public function low_inventory_products(){

            if(!empty($this->session->userdata('admin_data'))){

              $cur_date=date("Y-m-d");



$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('is_active', 1);
$product_units_da= $this->db->get();

$product_type_data= [];
$i=0;
if(!empty($product_units_da)){
foreach ($product_units_da->result() as $unit_type) {
 // code...

         $this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('unit_id',$unit_type->id);
$this->db->where('is_active', 1);
$inventory_da= $this->db->get()->row();

if(!empty($inventory_da)){

if($inventory_da->stock <= 3){



$product_type_data[]= $inventory_da;



$i++;
}

}



} }

// echo "<pre>"; print_r($product_type_data); die();

$data['product_data']= $product_type_data;

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/expiry_products/view_low_inventories');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }


    }

      ?>
