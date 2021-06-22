<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class FestiveProducts extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }


           public function view_added_home_products(){

              if(!empty($this->session->userdata('admin_data'))){

                 $this->db->select('*');
                 $this->db->from('tbl_offer_products');


                 //$this->db->where('category_id',base64_decode($category_id));
                 $data['Home_products_data']= $this->db->get();

                $this->load->view('admin/common/header_view',$data);
                $this->load->view('admin/offerproducts/view_added_home_products');
                $this->load->view('admin/common/footer_view');

            }
            else{

               redirect("login/admin_login","refresh");
            }

            }



         public function view_products(){

            if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
               $this->db->from('tbl_product');
               $this->db->where("is_active", 1);
                 $this->db->where("is_cat_delete", 0);
               //$this->db->where('category_id',base64_decode($category_id));
               $data['products_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/offerproducts/view_products');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }



          public function add_home_product($id){

             if(!empty($this->session->userdata('admin_data'))){

               $decode_id= base64_decode($id);

               $ip = $this->input->ip_address();
               date_default_timezone_set("Asia/Calcutta");
               $cur_date=date("Y-m-d H:i:s");
               $addedby=$this->session->userdata('admin_id');


                          $data_insert = array(

                                 'product_id'=>$decode_id,
                                 'ip' =>$ip,
                                 'added_by' =>$addedby,
                                 'date'=>$cur_date

                                    );


                          $last_added_id=$this->base_model->insert_table("tbl_offer_products",$data_insert,1) ;

                          if($last_added_id != 0){
                          $this->session->set_flashdata('smessage','Product Added successfully');
                          redirect("dcadmin/FestiveProducts/view_products","refresh");
                        }

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }




           public function remove_home_product($id){

              if(!empty($this->session->userdata('admin_data'))){

                $decode_id= base64_decode($id);




                           $last_removed_id = $this->db->delete('tbl_offer_products', array('product_id' => $decode_id));

                           if($last_removed_id != 0){
                           $this->session->set_flashdata('smessage','Product Removed successfully');
                           redirect("dcadmin/FestiveProducts/view_products","refresh");
                         }

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
                    //$this->db->where('id',$usr);


                    $data['category_data']= $this->db->get();

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
                      //$this->db->where('id',$usr);
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
  $this->form_validation->set_rules('category_id', 'category_id', 'required');
  $this->form_validation->set_rules('short_description', 'short_description', 'required');
  $this->form_validation->set_rules('long_description', 'long_description', 'required');
  if($typ == 1){

  $this->form_validation->set_rules('product_unit_type', 'product_unit_type', 'required');
}




               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
  $category_id=$this->input->post('category_id');
  $short_description=$this->input->post('short_description');
  $long_description=$this->input->post('long_description');

$product_unit_type=$this->input->post('product_unit_type');
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

     $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
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


           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'short_description'=>$short_description,
  'long_description'=>$long_description,
  'image1'=>$nnnn4,
  'image2'=>$nnnn5,
  'image3'=>$nnnn6,
  'image4'=>$nnnn7,
  'product_unit_type'=>$product_unit_type,
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
}else{
  $img1 = "";
  $img2 = "";
  $img3 = "";
  $img4 = "";
}
if(empty($nnnn4)){ $nnnn4 = $img1; }
if(empty($nnnn5)){ $nnnn5 = $img2; }
if(empty($nnnn6)){ $nnnn6 = $img3; }
if(empty($nnnn7)){ $nnnn7 = $img4; }

           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'short_description'=>$short_description,
  'long_description'=>$long_description,
  'image1'=>$nnnn4,
  'image2'=>$nnnn5,
  'image3'=>$nnnn6,
  'image4'=>$nnnn7);
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

 $zapak=$this->db->delete('tbl_product', array('id' => $id));
 if($zapak!=0){
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
