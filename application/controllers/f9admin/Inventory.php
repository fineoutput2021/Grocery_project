<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Inventory extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

           public function inventory_categories(){

              if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
               $this->db->from('tbl_category');
                //$this->db->where('id',$usr);
                $data['category_data']= $this->db->get();
                $this->load->view('admin/common/header_view',$data);
                $this->load->view('admin/inventory/inventory_categories');
                $this->load->view('admin/common/footer_view');

            }
            else{

               redirect("login/admin_login","refresh");
            }

          }

          public function view_inventory_products($category_id){

             if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
               $this->db->from('tbl_product');
               $this->db->where('category_id',base64_decode($category_id));
               $data['product_data']= $this->db->get();
               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/inventory/view_inventory_products');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }




         public function view_inventory($product_id){

            if(!empty($this->session->userdata('admin_data'))){


              $data['product_id']= $product_id;
                           $this->db->select('*');
               $this->db->from('tbl_inventory');
               $this->db->where('product_id',base64_decode($product_id));
               $data['inventory_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/inventory/view_inventory');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_inventory($product_id){

                 if(!empty($this->session->userdata('admin_data'))){
                   $data['product_id'] = $product_id;
                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/inventory/add_inventory');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function add_offline_order($product_id){

                  if(!empty($this->session->userdata('admin_data'))){
                    $data['product_id'] = $product_id;
                    $this->load->view('admin/common/header_view',$data);
                    $this->load->view('admin/inventory/add_offline_order');
                    $this->load->view('admin/common/footer_view');

                }
                else{

                   redirect("login/admin_login","refresh");
                }

                }



                             public function add_offline_order_data()

                               {

                                 if(!empty($this->session->userdata('admin_data'))){


                             $this->load->helper(array('form', 'url'));
                             $this->load->library('form_validation');
                             $this->load->helper('security');
                             if($this->input->post())
                             {
                               // print_r($this->input->post());
                               // exit;
                  $this->form_validation->set_rules('product_id', 'product_id', 'required');
                  $this->form_validation->set_rules('unit_id', 'unit_id', 'required');
                  $this->form_validation->set_rules('stock', 'stock', 'required');
                   if($this->form_validation->run()== TRUE)
                               {
                  $product_id=$this->input->post('product_id');

                  $unit_id=$this->input->post('unit_id');
                  $stock=$this->input->post('stock');


                    $this->db->select('*');
                    $this->db->from('tbl_product');
                    $this->db->where('id',$product_id);
                    $product_data_dsa = $this->db->get()->row();
                    $product_unit_type = $product_data_dsa->product_unit_type;

                  if($product_unit_type == 1){
                    $unit_id = 0;
                  }

                                   $ip = $this->input->ip_address();
                                   date_default_timezone_set("Asia/Calcutta");
                                   $cur_date=date("Y-m-d H:i:s");
                                   $addedby=$this->session->userdata('admin_id');

                           $last_id = 0;


                             $this->db->select('*');
                                   $this->db->from('tbl_inventory');
                                   $this->db->where('product_id',$product_id);
                                   $this->db->where('unit_id',$unit_id);
                                   $dsa= $this->db->get()->row();
                                   if(!empty($dsa)){

                                     $db_pro_stock = $dsa->stock;
                                     if($db_pro_stock >= $stock){
                                       $total_pro_stock = $db_pro_stock - $stock;

                                       $data_update = array(
                                         'stock'=>$total_pro_stock
                                        );
                                       $this->db->where('id', $dsa->id);
                                       $last_id=$this->db->update('tbl_inventory', $data_update);

                                             $data_transaction_insert2 = array(
                                                    'product_id'=>$product_id,
                                                    'unit_id'=>$unit_id,
                                                    'stock'=>$stock,
                                                    'type'=>2,
                                                       'ip' =>$ip,
                                                       'added_by' =>$addedby,
                                                       'is_active' =>1,
                                                       'date'=>$cur_date
                                                       );


                                             $this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);


                                     }else{

                                   $this->session->set_flashdata('emessage','Insufficient Stock ! Please reduce stock and try again.');
                                   redirect($_SERVER['HTTP_REFERER']);

                                     }
                                   }
                                 else{
                                   $this->session->set_flashdata('emessage','No stock added in Inventory');
                                   redirect($_SERVER['HTTP_REFERER']);
                                 }

                                       if($last_id!=0){
                                         $pu_cat_id = 0;
                                          $this->db->select('*');
                                                $this->db->from('tbl_product');
                                                $this->db->where('id',$product_id);
                                                $pu_dsa= $this->db->get()->row();
                                                if(!empty($pu_dsa)){
                                                  $pu_cat_id =  $pu_dsa->category_id;
                                                }
                                               $this->session->set_flashdata('smessage','Offline Order Added successfully');
                                               redirect("dcadmin/product/view_product/".base64_encode($pu_cat_id),"refresh");
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


               public function update_inventory($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('id',$id);
                            $data['inventory_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/inventory/update_inventory');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_inventory_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('product_id', 'product_id', 'required');


  $this->form_validation->set_rules('unit_id', 'unit_id', 'required');

  $this->form_validation->set_rules('stock', 'stock', 'required');





               if($this->form_validation->run()== TRUE)
               {
  $product_id=$this->input->post('product_id');
  $unit_id=$this->input->post('unit_id');
  $stock=$this->input->post('stock');

  $this->db->select('*');
  $this->db->from('tbl_product');
  $this->db->where('id',$product_id);
  $product_data_dsa = $this->db->get()->row();
  $product_unit_type = $product_data_dsa->product_unit_type;

if($product_unit_type == 1){
  $unit_id = 0;
}
                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){


             $this->db->select('*');
                   $this->db->from('tbl_inventory');
                   $this->db->where('product_id',$product_id);
                   $this->db->where('unit_id',$unit_id);
                   $dsa= $this->db->get()->row();
                   if(!empty($dsa)){

                     $db_pro_stock = $dsa->stock;
                     $total_pro_stock = $db_pro_stock + $stock;
                     $data_update = array(
                       'stock'=>$total_pro_stock
                      );
                     $this->db->where('id', $dsa->id);
                     $last_id=$this->db->update('tbl_inventory', $data_update);


                      $data_transaction_insert2 = array(
                             'product_id'=>$product_id,
                             'unit_id'=>$unit_id,
                             'stock'=>$stock,
                             'type'=>1,
                                'ip' =>$ip,
                                'added_by' =>$addedby,
                                'is_active' =>1,
                                'date'=>$cur_date
                                );


                      $this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);
                   }
                 else{
                   $data_insert = array(
                          'product_id'=>$product_id,
                          'unit_id'=>$unit_id,
                          'stock'=>$stock,
                             'ip' =>$ip,
                             'added_by' =>$addedby,
                             'is_active' =>1,
                             'date'=>$cur_date
                             );


                   $last_id=$this->base_model->insert_table("tbl_inventory",$data_insert,1);


                   $data_transaction_insert = array(
                          'product_id'=>$product_id,
                          'unit_id'=>$unit_id,
                          'stock'=>$stock,
                          'type'=>1,
                             'ip' =>$ip,
                             'added_by' =>$addedby,
                             'is_active' =>1,
                             'date'=>$cur_date
                             );


                   $this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert,1);


                 }






           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_inventory');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();





           $data_insert = array(
                  'product_id'=>$product_id,
  'unit_id'=>$unit_id,
  'stock'=>$stock,

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_inventory', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/inventory/view_inventory/".base64_encode($product_id),"refresh");
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

               public function updateinventoryStatus($idd,$t){

                        if(!empty($this->session->userdata('admin_data'))){


                          $data['user_name']=$this->load->get_var('user_name');

                          // echo SITE_NAME;
                          // echo $this->session->userdata('image');
                          // echo $this->session->userdata('position');
                          // exit;
                          $id=base64_decode($idd);
                          $pu_prod_id = 0;
                           $this->db->select('*');
                                 $this->db->from('tbl_inventory');
                                 $this->db->where('id',$id);
                                 $pu_dsa= $this->db->get()->row();
                                 if(!empty($pu_dsa)){
                                   $pu_prod_id =  $pu_dsa->product_id;
                                 }
                          if($t=="active"){

                            $data_update = array(
                        'is_active'=>1

                        );

                        $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_inventory', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/inventory/view_inventory/".base64_encode($pu_prod_id),"refresh");
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
                         $zapak=$this->db->update('tbl_inventory', $data_update);

                             if($zapak!=0){
                             redirect("dcadmin/inventory/view_inventory/".base64_encode($pu_prod_id),"refresh");
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



                               public function view_inventory_transactions(){

                                  if(!empty($this->session->userdata('admin_data'))){



                                     $this->db->select('*');
                                     $this->db->from('tbl_inventory_transaction');
                                     $data['inventory_transactions_data']= $this->db->get();

                                    $this->load->view('admin/common/header_view',$data);
                                    $this->load->view('admin/inventory/view_inventory_transactions');
                                    $this->load->view('admin/common/footer_view');

                                }
                                else{

                                   redirect("login/admin_login","refresh");
                                }

                                }


               public function delete_inventory($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);
                        $pu_prod_id = 0;
                         $this->db->select('*');
                               $this->db->from('tbl_inventory');
                               $this->db->where('id',$id);
                               $pu_dsa= $this->db->get()->row();
                               if(!empty($pu_dsa)){
                                 $pu_prod_id =  $pu_dsa->product_id;
                               }
                       if($this->load->get_var('position')=="Super Admin"){



 $zapak=$this->db->delete('tbl_inventory', array('id' => $id));
 if($zapak!=0){

        redirect("dcadmin/inventory/view_inventory/".base64_encode($pu_prod_id),"refresh");
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
