<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Product extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_product($category_id){

            if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
               $this->db->from('tbl_product');
               $this->db->where('category_id',base64_decode($category_id));
               $data['product_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/product/view_product');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }
          public function view_product_categories(){

             if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
              $this->db->from('tbl_category');
                //$this->db->where('id',$usr);
                $data['category_data']= $this->db->get();

               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/product/view_product_categories');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }


              public function add_product(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->db->select('*');
                    $this->db->from('tbl_category');
                    $this->db->where('is_active', 1);
                    $data['category_data']= $this->db->get();

                    $this->db->select('*');
                     $this->db->from('tbl_subcategory');
                     $this->db->where('is_cat_delete',0);
                     $this->db->where('is_active', 1);
                     $data['subcategory_data']= $this->db->get();

                    $this->db->select('*');
                     $this->db->from('tbl_units');
                    $data['units_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/product/add_product');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_product($idd){

                   if(!empty($this->session->userdata('admin_data'))){

                     $this->db->select('*');
                      $this->db->from('tbl_category');
                      $this->db->where('is_active',1);
                      $data['category_data']= $this->db->get();
                     $data['user_name']=$this->load->get_var('user_name');




                     $this->db->select('*');
                      $this->db->from('tbl_units');


                     $data['units_data']= $this->db->get();

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_product');
                            $this->db->where('id',$id);
                            $data['product_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/product/update_product');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_product_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
                  $typ=base64_decode($t);
  $this->form_validation->set_rules('name', 'name', 'required');
  $this->form_validation->set_rules('category_id', 'category_id', 'required|trim|xss_clean');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim|xss_clean');
  $this->form_validation->set_rules('subcategory2_id', 'subcategory2_id', 'trim|xss_clean');
  $this->form_validation->set_rules('short_description', 'short_description', 'required|trim|xss_clean');
  $this->form_validation->set_rules('long_description', 'long_description', 'required|trim|xss_clean');

  if($typ == 1){
    // $this->form_validation->set_rules('appmainimage', 'appmainimage', 'required');
    // $this->form_validation->set_rules('appimage1', 'appimage1', 'required');
    // $this->form_validation->set_rules('appimage2', 'appimage2', 'required');
    // $this->form_validation->set_rules('image1', 'image1', 'required');
    // $this->form_validation->set_rules('image2', 'image2', 'required');
  // $this->form_validation->set_rules('product_unit_type', 'product_unit_type', 'required');
}




               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
  $category_id=$this->input->post('category_id');
  $subcategory_id=$this->input->post('subcategory_id');
  $subcategory2_id=$this->input->post('subcategory2_id');
  $short_description=$this->input->post('short_description');
  $long_description=$this->input->post('long_description');

  $expire_date=$this->input->post('expire_date');
  $discount_tag=$this->input->post('discount_tag');

// $product_unit_type=$this->input->post('product_unit_type');
                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');


$last_id = 0;


$img4='image1';

         $image_upload_folder = FCPATH . "assets/uploads/product/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="product".date("Ymdhms").$this->generateRandomString(6);
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img4))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);
if($typ == 1){
           $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
           }
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn4=$videoNAmePath;

                         // echo json_encode($file_info);
                     }




$img5='image2';


           $file_check=($_FILES['image2']['error']);
if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/product/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="product".date("Ymdhms").$this->generateRandomString(6);
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img5))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);
if($typ == 1){
           $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
           }   }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn5=$videoNAmePath;


                         // echo json_encode($file_info);
                     }
        }



$img6='image3';


           $file_check=($_FILES['image3']['error']);
if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/product/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="product".date("Ymdhms").$this->generateRandomString(6);
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img6))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);
if($typ == 1){
           // $this->session->set_flashdata('emessage',$upload_error);
           //   redirect($_SERVER['HTTP_REFERER']);
           }
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn6=$videoNAmePath;

                         // echo json_encode($file_info);
                     }
        }



$img7='image4';


           $file_check=($_FILES['image4']['error']);
if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/product/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="product".date("Ymdhms").$this->generateRandomString(6);
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img7))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);
if($typ==1){
     // $this->session->set_flashdata('emessage',$upload_error);
     //         redirect($_SERVER['HTTP_REFERER']);
           }
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn7=$videoNAmePath;

                         // echo json_encode($file_info);
                     }
        }





$appimg='appimage';


           $file_check=($_FILES['image4']['error']);
// if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/productApp/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="productApp".date("Ymdhms").$this->generateRandomString(6);
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($appimg))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);
if($typ==1){
     $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
        }
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/productApp/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnnn=$file_info['file_name'];
                         $nnnn8=$videoNAmePath;

                         // echo json_encode($file_info);
                     }
        // }


///APP Images Start

        $appmainimg='appmainimage';


                   $file_check=($_FILES['image4']['error']);
        // if($file_check!=4){

                 $image_upload_folder = FCPATH . "assets/uploads/productAppMainImg/";
                             if (!file_exists($image_upload_folder))
                             {
                                 mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                             }
                             $new_file_name="productAppMainImg".date("Ymdhms").$this->generateRandomString(6);
                             $this->upload_config = array(
                                     'upload_path'   => $image_upload_folder,
                                     'file_name' => $new_file_name,
                                     'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                                     'max_size'      => 25000
                             );
                             $this->upload->initialize($this->upload_config);
                             if (!$this->upload->do_upload($appmainimg))
                             {
                                 $upload_error = $this->upload->display_errors();
                                 // echo json_encode($upload_error);
        if($typ==1){
             $this->session->set_flashdata('emessage',$upload_error);
                     redirect($_SERVER['HTTP_REFERER']);
                }
                             }
                             else
                             {

                                 $file_info = $this->upload->data();

                                 $videoNAmePath = "assets/uploads/productAppMainImg/".$new_file_name.$file_info['file_ext'];
                                 $file_info['new_name']=$videoNAmePath;
                                 // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                                 $nnnnn=$file_info['file_name'];
                                 $nnnn9=$videoNAmePath;

                                 // echo json_encode($file_info);
                             }


//app image1
   $appimg1='appimage1';


              $file_check=($_FILES['image4']['error']);
   // if($file_check!=4){

            $image_upload_folder = FCPATH . "assets/uploads/productAppImg/";
                        if (!file_exists($image_upload_folder))
                        {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="productAppImg1".date("Ymdhms").$this->generateRandomString(6);
                        $this->upload_config = array(
                                'upload_path'   => $image_upload_folder,
                                'file_name' => $new_file_name,
                                'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                                'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($appimg1))
                        {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
   if($typ==1){
        $this->session->set_flashdata('emessage',$upload_error);
                redirect($_SERVER['HTTP_REFERER']);
           }
                        }
                        else
                        {

                            $file_info = $this->upload->data();

                            $videoNAmePath = "assets/uploads/productAppImg/".$new_file_name.$file_info['file_ext'];
                            $file_info['new_name']=$videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $nnnnn=$file_info['file_name'];
                            $nnnn10=$videoNAmePath;

                            // echo json_encode($file_info);
                        }



//app image2
   $appimg2='appimage2';


              $file_check=($_FILES['image4']['error']);
   // if($file_check!=4){

            $image_upload_folder = FCPATH . "assets/uploads/productAppImg/";
                        if (!file_exists($image_upload_folder))
                        {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="productAppImg2".date("Ymdhms").$this->generateRandomString(6);
                        $this->upload_config = array(
                                'upload_path'   => $image_upload_folder,
                                'file_name' => $new_file_name,
                                'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                                'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($appimg2))
                        {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
   if($typ==1){
        $this->session->set_flashdata('emessage',$upload_error);
                redirect($_SERVER['HTTP_REFERER']);
           }
                        }
                        else
                        {

                            $file_info = $this->upload->data();

                            $videoNAmePath = "assets/uploads/productAppImg/".$new_file_name.$file_info['file_ext'];
                            $file_info['new_name']=$videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $nnnnn=$file_info['file_name'];
                            $nnnn11=$videoNAmePath;

                            // echo json_encode($file_info);
                        }



  //app image3
     $appimg3='appimage3';


                $file_check=($_FILES['image4']['error']);
     // if($file_check!=4){

              $image_upload_folder = FCPATH . "assets/uploads/productAppImg/";
                          if (!file_exists($image_upload_folder))
                          {
                              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                          }
                          $new_file_name="productAppImg3".date("Ymdhms").$this->generateRandomString(6);
                          $this->upload_config = array(
                                  'upload_path'   => $image_upload_folder,
                                  'file_name' => $new_file_name,
                                  'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                                  'max_size'      => 25000
                          );
                          $this->upload->initialize($this->upload_config);
                          if (!$this->upload->do_upload($appimg3))
                          {
                              $upload_error = $this->upload->display_errors();
                              // echo json_encode($upload_error);
     if($typ==1){
          // $this->session->set_flashdata('emessage',$upload_error);
          //         redirect($_SERVER['HTTP_REFERER']);
             }
                          }
                          else
                          {

                              $file_info = $this->upload->data();

                              $videoNAmePath = "assets/uploads/productAppImg/".$new_file_name.$file_info['file_ext'];
                              $file_info['new_name']=$videoNAmePath;
                              // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                              $nnnnn=$file_info['file_name'];
                              $nnnn12=$videoNAmePath;

                              // echo json_encode($file_info);
                          }



  //app image4
     $appimg4='appimage4';


                $file_check=($_FILES['image4']['error']);
     // if($file_check!=4){

              $image_upload_folder = FCPATH . "assets/uploads/productAppImg/";
                          if (!file_exists($image_upload_folder))
                          {
                              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                          }
                          $new_file_name="productAppImg4".date("Ymdhms").$this->generateRandomString(6);
                          $this->upload_config = array(
                                  'upload_path'   => $image_upload_folder,
                                  'file_name' => $new_file_name,
                                  'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                                  'max_size'      => 25000
                          );
                          $this->upload->initialize($this->upload_config);
                          if (!$this->upload->do_upload($appimg4))
                          {
                              $upload_error = $this->upload->display_errors();
                              // echo json_encode($upload_error);
     if($typ==1){
          // $this->session->set_flashdata('emessage',$upload_error);
          //         redirect($_SERVER['HTTP_REFERER']);
             }
                          }
                          else
                          {

                              $file_info = $this->upload->data();

                              $videoNAmePath = "assets/uploads/productAppImg/".$new_file_name.$file_info['file_ext'];
                              $file_info['new_name']=$videoNAmePath;
                              // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                              $nnnnn=$file_info['file_name'];
                              $nnnn13=$videoNAmePath;

                              // echo json_encode($file_info);
                          }


// echo '$nnnn8';
// echo $nnnn8; die();


        if($typ==1){

if(empty($nnnn4)){
  $nnnn4 = "";
}
if(empty($nnnn5)){
  $nnnn5 = "";
}
if(empty($nnnn6)){
  $nnnn6 = "";
}
if(empty($nnnn7)){
  $nnnn7 = "";
}
//app_pro_image
if(empty($nnnn8)){
  $nnnn8 = "";
}

//app_main_image
if(empty($nnnn9)){
  $nnnn9 = "";
}

//app images
if(empty($nnnn10)){
  $nnnn10 = "";
}
if(empty($nnnn11)){
  $nnnn11 = "";
}
if(empty($nnnn12)){
  $nnnn12 = "";
}
if(empty($nnnn13)){
  $nnnn13 = "";
}


           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'subcategory2_id'=>$subcategory2_id,
  'short_description'=>$short_description,
  'long_description'=>$long_description,
  'image1'=>$nnnn4,
  'image2'=>$nnnn5,
  'image3'=>$nnnn6,
  'image4'=>$nnnn7,
  'app_pro_image'=>$nnnn8,
  'app_main_image'=>$nnnn9,
  'app_image1'=>$nnnn10,
  'app_image2'=>$nnnn11,
  'app_image3'=>$nnnn12,
  'app_image4'=>$nnnn13,
  // 'product_unit_type'=>$product_unit_type,
                     'expire_date' =>$expire_date,
                     'discount_tag' =>$discount_tag,


                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date

                     );


           $last_id=$this->base_model->insert_table("tbl_product",$data_insert,1) ;

           }

           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_product');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();



if(!empty($da)){
  $img1 = $da ->image1;
  $img2 = $da ->image2;
  $img3 = $da ->image3;
  $img4 = $da ->image4;
  //app_pro_image
  $app_proimage = $da ->app_pro_image;
  $app_mainimage = $da ->app_main_image;
  $appimage1 = $da ->app_image1;
  $appimage2 = $da ->app_image2;
  $appimage3 = $da ->app_image3;
  $appimage4 = $da ->app_image4;
}else{
  $img1 = "";
  $img2 = "";
  $img3 = "";
  $img4 = "";
  //app_pro_image
  $app_proimage = "";
  $app_mainimage = "";
  $appimage1 = "";
  $appimage2 = "";
  $appimage3 = "";
  $appimage4 = "";
}
if(empty($nnnn4)){ $nnnn4 = $img1; }
if(empty($nnnn5)){ $nnnn5 = $img2; }
if(empty($nnnn6)){ $nnnn6 = $img3; }
if(empty($nnnn7)){ $nnnn7 = $img4; }
//app_pro_image
if(empty($nnnn8)){ $nnnn8 = $app_proimage; }
if(empty($nnnn9)){ $nnnn9 = $app_mainimage; }
if(empty($nnnn10)){ $nnnn10 = $appimage1; }
if(empty($nnnn11)){ $nnnn11 = $appimage2; }
if(empty($nnnn12)){ $nnnn12 = $appimage3; }
if(empty($nnnn13)){ $nnnn13 = $appimage4; }

// echo $nnnn4;
// echo $nnnn5;
// echo $nnnn6;
// echo $nnnn7; exit;

           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'subcategory2_id'=>$subcategory2_id,
  'short_description'=>$short_description,
  'long_description'=>$long_description,
  'image1'=>$nnnn4,
  'image2'=>$nnnn5,
  'image3'=>$nnnn6,
  'image4'=>$nnnn7,
  'app_main_image'=>$nnnn9,
  'app_image1'=>$nnnn10,
  'app_image2'=>$nnnn11,
  'app_image3'=>$nnnn12,
  'app_image4'=>$nnnn13,
  'app_pro_image'=>$nnnn8,

  'expire_date' =>$expire_date,
  'discount_tag' =>$discount_tag,
);
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_product', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');

                               if($typ == 1){
                                 redirect("dcadmin/product_units/add_product_units/".base64_encode($last_id),"refresh");

                               }else{
                               redirect("dcadmin/product/view_product/".base64_encode($category_id),"refresh");
                             }}
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

               public function updateproductStatus($idd,$t){

                        if(!empty($this->session->userdata('admin_data'))){


                          $data['user_name']=$this->load->get_var('user_name');

                          $id=base64_decode($idd);

                          $pu_cat_id = 0;
                           $this->db->select('*');
                                 $this->db->from('tbl_product');
                                 $this->db->where('id',$id);
                                 $pu_dsa= $this->db->get()->row();
                                 if(!empty($pu_dsa)){
                                   $pro_id =  $pu_dsa->id;
                                   $pu_cat_id =  $pu_dsa->category_id;
                                 }
                          if($t=="active"){

                            $data_update = array(
                        'is_active'=>1

                        );

                        $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_product', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/product/view_product/".base64_encode($pu_cat_id),"refresh");
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
                         $zapak=$this->db->update('tbl_product', $data_update);

                             if($zapak!=0){

//delete cart
     $this->db->select('*');
     $this->db->from('tbl_cart');
     $this->db->where('product_id',$pro_id);
     $c_pro= $this->db->get();

     if(!empty($c_pro)){
       foreach ($c_pro->result() as $carrt) {
         $del_c_pro =$this->db->delete('tbl_cart', array('id' => $carrt->id));
       }
     }



   //delete trending product

      $this->db->select('*');
      $this->db->from('tbl_trending_products');
      $this->db->where('product_id',$pro_id);
      $tp_pro= $this->db->get();

      if(!empty($tp_pro)){
        foreach ($tp_pro->result() as $trending) {
          $del_tre_pro =$this->db->delete('tbl_trending_products', array('id' => $trending->id));
        }
      }


    //delete recent product

       $this->db->select('*');
       $this->db->from('tbl_recent_products');
       $this->db->where('product_id',$pro_id);
       $rp_pro= $this->db->get();

       if(!empty($rp_pro)){
         foreach ($rp_pro->result() as $recent) {
           $del_rece_pro =$this->db->delete('tbl_recent_products', array('id' => $recent->id));
         }
       }

    //delete offer product

       $this->db->select('*');
       $this->db->from('tbl_offer_products');
       $this->db->where('product_id',$pro_id);
       $op_pro= $this->db->get();

       if(!empty($op_pro)){
         foreach ($op_pro->result() as $offer) {
           $del_off_pro =$this->db->delete('tbl_offer_products', array('id' => $offer->id));
         }
       }



//delete home products
       $this->db->select('*');
       $this->db->from('tbl_home_products');
       $this->db->where('product_id',$pro_id);
       $h_pro= $this->db->get()->row();

      if(!empty($h_pro)){
           $del_h_pro =$this->db->delete('tbl_home_products', array('id' => $h_pro->id));
      }
                                  


                             redirect("dcadmin/product/view_product/".base64_encode($pu_cat_id),"refresh");
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



               public function delete_product($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     $this->db->select('*');
                     $this->db->from('tbl_product');
                     $this->db->where('id',$id);
                     $dsa= $this->db->get();
                     $da=$dsa->row();

                     $cat_id=$da->category_id;
                     $img1=$da->image1;
                     $img2=$da->image2;
                     $img3=$da->image3;
                     $img4=$da->image4;

                      $p_id= $da->id;

 $zapak=$this->db->delete('tbl_product', array('id' => $id));
 if($zapak!=0){

//delete cart
$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('product_id',$p_id);
$c_pro= $this->db->get();

if(!empty($c_pro)){
  foreach ($c_pro->result() as $carrt) {
    $del_c_pro =$this->db->delete('tbl_cart', array('id' => $carrt->id));
  }
}




//delete home product
   $this->db->select('*');
   $this->db->from('tbl_home_products');
   $this->db->where('product_id',$p_id);
   $h_pro= $this->db->get()->row();

   $del_h_pro =$this->db->delete('tbl_home_products', array('id' => $h_pro->id));




   if(!empty($img1)){
        $path1 = FCPATH .$img1;
          unlink($path1);
        }
        if(!empty($img2)){
          $path2 = FCPATH .$img2;
            unlink($path2);
          }
          if(!empty($img3)){
            $path3 = FCPATH .$img3;
              unlink($path3);
            }
            if(!empty($img4)){
              $path4 = FCPATH .$img4;
                unlink($path4);
              }
        redirect("dcadmin/product/view_product/".base64_encode($cat_id),"refresh");
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

                            function generateRandomString($length = 10)
                                      {
                                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                        $charactersLength = strlen($characters);
                                        $randomString = '';
                                        for ($i = 0; $i < $length; $i++) {
                                          $randomString .= $characters[rand(0, $charactersLength - 1)];
                                        }
                                        return $randomString;
                                      }
                      }

      ?>
