<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Product_units extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_product_units($product_id){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

                           $this->db->select('*');
               $this->db->from('tbl_product_units');
                $this->db->order_by('id', 'ASC');
               $this->db->where('product_id',base64_decode($product_id));

               $data['product_units_data']= $this->db->get();

               // print_r($data['product_units_data']->result());
               // exit;

               $data['product_id'] = base64_decode($product_id);
              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/product_units/view_product_units');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_product_units($product_id){

                 if(!empty($this->session->userdata('admin_data'))){

                   $data['product_id'] = base64_decode($product_id);
                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/product_units/add_product_units');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_product_units($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_product_units');
                            $this->db->where('id',$id);
                            $data['product_units_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/product_units/update_product_units');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_product_units_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {


  $this->form_validation->set_rules('product_id', 'product_id', 'required');
  $this->form_validation->set_rules('unit_id', 'unit_id', 'required');
  $this->form_validation->set_rules('mrp', 'mrp', 'required');
  $this->form_validation->set_rules('selling_price', 'selling_price', 'required');
  $this->form_validation->set_rules('total_amount', 'total_amount', 'required');
  $typ=base64_decode($t);


  $this->form_validation->set_rules('ratio', 'ratio', 'required');


               if($this->form_validation->run()== TRUE)
               {

                 $product_id=$this->input->post('product_id');
  $unit_id=$this->input->post('unit_id');
  $mrp=$this->input->post('mrp');
  $selling_price=$this->input->post('selling_price');
    $gst_percentage=$this->input->post('gst_percentage');
      $gst_amount=$this->input->post('gst_amount');
        $total_amount=$this->input->post('total_amount');

  $ratio=$this->input->post('ratio');


                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $last_id = 0;






             $img1='image1';

           $image_upload_folder = FCPATH . "assets/admin/product_units/";
                 if (!file_exists($image_upload_folder))
                 {
                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                 }
                 $new_file_name="product_units".date("Ymdhms");
                 $this->upload_config = array(
                   'upload_path'   => $image_upload_folder,
                   'file_name' => $new_file_name,
                   'allowed_types' =>'pdf|jpg|jpeg|png',
                   'max_size'      => 25000
                 );
                 $this->upload->initialize($this->upload_config);
                 if (!$this->upload->do_upload($img1))
                 {
                   $upload_error = $this->upload->display_errors();
                   // echo json_encode($upload_error);
                   echo $upload_error;
                 }
                 else
                 {
                   $file_info = $this->upload->data();
                   $videoNAmePath = "assets/admin/product_units/".$new_file_name.$file_info['file_ext'];
                   $file_info['new_name']=$videoNAmePath;
                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                   $nnnn1=$file_info['file_name'];
                   // echo json_encode($file_info);
                 }










             $img2='image2';

           $image_upload_folder = FCPATH . "assets/admin/product_units/";
                 if (!file_exists($image_upload_folder))
                 {
                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                 }
                 $new_file_name="product_units".date("Ymdhms");
                 $this->upload_config = array(
                   'upload_path'   => $image_upload_folder,
                   'file_name' => $new_file_name,
                   'allowed_types' =>'pdf|jpg|jpeg|png',
                   'max_size'      => 25000
                 );
                 $this->upload->initialize($this->upload_config);
                 if (!$this->upload->do_upload($img2))
                 {
                   $upload_error = $this->upload->display_errors();
                   // echo json_encode($upload_error);
                   echo $upload_error;
                 }
                 else
                 {
                   $file_info = $this->upload->data();
                   $videoNAmePath = "assets/admin/product_units/".$new_file_name.$file_info['file_ext'];
                   $file_info['new_name']=$videoNAmePath;
                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                   $nnnn2=$file_info['file_name'];
                   // echo json_encode($file_info);
                 }










           $img3='image3';
           $image_upload_folder = FCPATH . "assets/admin/product_units/";
                 if (!file_exists($image_upload_folder))
                 {
                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                 }
                 $new_file_name="product_units".date("Ymdhms");
                 $this->upload_config = array(
                   'upload_path'   => $image_upload_folder,
                   'file_name' => $new_file_name,
                   'allowed_types' =>'pdf|jpg|jpeg|png',
                   'max_size'      => 25000
                 );
                 $this->upload->initialize($this->upload_config);
                 if (!$this->upload->do_upload($img3))
                 {
                   $upload_error = $this->upload->display_errors();
                   // echo json_encode($upload_error);
                   echo $upload_error;
                 }
                 else
                 {
                   $file_info = $this->upload->data();
                   $videoNAmePath = "assets/admin/product_units/".$new_file_name.$file_info['file_ext'];
                   $file_info['new_name']=$videoNAmePath;
                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                   $nnnn3=$file_info['file_name'];
                   // echo json_encode($file_info);
                 }









          $img4='image4';

           $image_upload_folder = FCPATH . "assets/admin/product_units/";
                 if (!file_exists($image_upload_folder))
                 {
                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                 }
                 $new_file_name="product_units".date("Ymdhms");
                 $this->upload_config = array(
                   'upload_path'   => $image_upload_folder,
                   'file_name' => $new_file_name,
                   'allowed_types' =>'pdf|jpg|jpeg|png',
                   'max_size'      => 25000
                 );
                 $this->upload->initialize($this->upload_config);
                 if (!$this->upload->do_upload($img4))
                 {
                   $upload_error = $this->upload->display_errors();
                   // echo json_encode($upload_error);
                   echo $upload_error;
                 }
                 else
                 {
                   $file_info = $this->upload->data();
                   $videoNAmePath = "assets/admin/product_units/".$new_file_name.$file_info['file_ext'];
                   $file_info['new_name']=$videoNAmePath;
                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                   $nnnn4=$file_info['file_name'];
                   // echo json_encode($file_info);
                 }






           //
           // $img1='image1';
           //
           //          $image_upload_folder = FCPATH . "assets/uploads/product_units/";
           //                      if (!file_exists($image_upload_folder))
           //                      {
           //                          mkdir($image_upload_folder, DIR_WRITE_MODE, true);
           //                      }
           //                      $new_file_name="product_units".date("Ymdhms").$this->generateRandomString(6);
           //                      $this->upload_config = array(
           //                              'upload_path'   => $image_upload_folder,
           //                              'file_name' => $new_file_name,
           //                              'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
           //                              'max_size'      => 25000
           //                      );
           //                      $this->upload->initialize($this->upload_config);
           //                      if (!$this->upload->do_upload($img1))
           //                      {
           //                          $upload_error = $this->upload->display_errors();
           //                          // echo json_encode($upload_error);
           // if($typ == 1){
           //            $this->session->set_flashdata('emessage',$upload_error);
           //              redirect($_SERVER['HTTP_REFERER']);
           //            }
           //                      }
           //                      else
           //                      {
           //
           //                          $file_info = $this->upload->data();
           //
           //                          $videoNAmePath = "assets/product_units/product/".$new_file_name.$file_info['file_ext'];
           //                          $file_info['new_name']=$videoNAmePath;
           //                          // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
           //                          $nnnn=$file_info['file_name'];
           //                          $nnnn4=$videoNAmePath;
           //
           //                          // echo json_encode($file_info);
           //                      }
           //
           //
           //








           if($typ==1){


             if(empty($nnnn1)){
               $nnnn1 = "";
             }
             if(empty($nnnn2)){
               $nnnn2 = "";
             }
             if(empty($nnnn3)){
               $nnnn3 = "";
             }
             if(empty($nnnn4)){
               $nnnn4 = "";
             }

             $this->db->select('*');
                   $this->db->from('tbl_product_units');
                   $this->db->where('product_id',$product_id);
                   $this->db->where('unit_id',$unit_id);
                   $da= $this->db->get()->row();
                   if(!empty($da)){
                     $this->session->set_flashdata('emessage','Unit already exists for this product');
                     redirect($_SERVER['HTTP_REFERER']);


                   }
                 else{
$inventory_unit_id = $unit_id;
$this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('id',$product_id);
      $product_data= $this->db->get()->row();
      if(!empty($product_data)){

         if($product_data->product_unit_type == 1)
        $inventory_unit_id = 0;
      }

                   $this->db->select('*');
                         $this->db->from('tbl_inventory');
                         $this->db->where('product_id',$product_id);
                         $this->db->where('unit_id',$inventory_unit_id);
                         $dsa= $this->db->get()->row();
                         if(empty($dsa)){
                         $data_insert = array(
                                'product_id'=>$product_id,
                                'unit_id'=>$inventory_unit_id,
                                'stock'=>0,
                                   'ip' =>$ip,
                                   'added_by' =>$addedby,
                                   'is_active' =>1,
                                   'date'=>$cur_date
                                   );


                         $last_id=$this->base_model->insert_table("tbl_inventory",$data_insert,1);

                       }


                              $data_insert = array(
                                'product_id'=>$product_id,
                                     'unit_id'=>$unit_id,
                     'mrp'=>$mrp,
                     'without_selling_price'=>$selling_price,
                      'gst_percentage'=>$gst_percentage,
                       'gst_amount'=>$gst_amount,
                        'selling_price'=>$total_amount,
                        'image1'=>$nnnn1,
                        'image2'=>$nnnn2,
                        'image3'=>$nnnn3,
                        'image4'=>$nnnn4,

                     'ratio'=>$ratio,
                                        'ip' =>$ip,
                                        'added_by' =>$addedby,
                                        'is_active' =>1,
                                        'date'=>$cur_date
                                        );


                              $last_id=$this->base_model->insert_table("tbl_product_units",$data_insert,1);

                 }


           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_product_units');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();




 if(!empty($da)){
   $img1 = $da->image1;
   $img2 = $da->image2;
   $img3 = $da->image3;
   $img4 = $da->image4;

 }else{
   $img1 = "";
   $img2 = "";
   $img3 = "";
   $img4 = "";

 }
 if(empty($nnnn1)){ $nnnn1 = $img1; }
 if(empty($nnnn2)){ $nnnn2 = $img2; }
 if(empty($nnnn3)){ $nnnn3 = $img3; }
 if(empty($nnnn4)){ $nnnn4 = $img4; }



           $data_insert = array(
             'product_id'=>$product_id,
                  'unit_id'=>$unit_id,
  'mrp'=>$mrp,
  'without_selling_price'=>$selling_price,
  'gst_percentage'=>$gst_percentage,
  'gst_amount'=>$gst_amount,
  'selling_price'=>$total_amount,
  'ratio'=>$ratio,
  'image1'=>$nnnn1,
  'image2'=>$nnnn2,
  'image3'=>$nnnn3,
  'image4'=>$nnnn4,

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_product_units', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/product_units/view_product_units/".base64_encode($product_id),"refresh");
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

               public function updateproduct_unitsStatus($idd,$t){

                        if(!empty($this->session->userdata('admin_data'))){


                          $data['user_name']=$this->load->get_var('user_name');

                          // echo SITE_NAME;
                          // echo $this->session->userdata('image');
                          // echo $this->session->userdata('position');
                          // exit;
                          $id=base64_decode($idd);
                          $pu_prod_id = 0;
                           $this->db->select('*');
                                 $this->db->from('tbl_product_units');
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
                       $zapak=$this->db->update('tbl_product_units', $data_update);


                            if($zapak!=0){
                            redirect("dcadmin/product_units/view_product_units/".base64_encode($pu_prod_id),"refresh");
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
                         $zapak=$this->db->update('tbl_product_units', $data_update);

                             if($zapak!=0){


 //cart delete

                $this->db->select('*');
    $this->db->from('tbl_cart');
    $this->db->where('product_id',$pu_prod_id);
    $cart_product_data= $this->db->get();

    if(!empty($cart_product_data)){
      foreach ($cart_product_data as $cart_data) {

        $cart_d_delete=$this->db->delete('tbl_cart', array('product_id' => $pu_prod_id));

      }
    }


                               redirect("dcadmin/product_units/view_product_units/".base64_encode($pu_prod_id),"refresh");
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



               public function delete_product_units($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                            $pu_prod_id = 0;
                           $this->db->select('*');
                                 $this->db->from('tbl_product_units');
                                 $this->db->where('id',$id);
                                 $pu_dsa= $this->db->get()->row();
                                 if(!empty($pu_dsa)){
                                   $pu_prod_id =  $pu_dsa->product_id;
                                 }

 $zapak=$this->db->delete('tbl_product_units', array('id' => $id));
 if($zapak!=0){


//cart delete

               $this->db->select('*');
   $this->db->from('tbl_cart');
   $this->db->where('product_id',$pu_prod_id);
   $cart_product_data= $this->db->get();

   if(!empty($cart_product_data)){
     foreach ($cart_product_data as $cart_data) {

       $cart_d_delete=$this->db->delete('tbl_cart', array('product_id' => $pu_prod_id));

     }
   }


   $this->session->set_flashdata('smessage','Product Unit Deleted Successfully');

        redirect("dcadmin/product_units/view_product_units/".base64_encode($pu_prod_id),"refresh");
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
