<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Category extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_category(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

              $this->db->select('*');
               $this->db->from('tbl_category');
               //$this->db->where('id',$usr);
               $this->db->order_by("sort_id", "asc");
               $data['category_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/category/view_category');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_category(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/category/add_category');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_category($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_category');
                            $this->db->where('id',$id);
                            $data['category_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/category/update_category');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_category_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('name', 'name', 'required|xss_clean');
  $this->form_validation->set_rules('sort_id', 'sort_id', 'required|trim|xss_clean');
  $this->form_validation->set_rules('subtext1', 'subtext1', 'required|trim|xss_clean');
  $this->form_validation->set_rules('subtext2', 'subtext2', 'required|trim|xss_clean');


               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
   $sort_id=$this->input->post('sort_id');
   $subtext1=$this->input->post('subtext1');
   $subtext2=$this->input->post('subtext2');


//check input sort_id exist for other category or not

// die();



                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){

$img1='image';
         $image_upload_folder = FCPATH . "assets/uploads/category/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="category".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img1))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);

           $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/category/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn1=$videoNAmePath;

                         // echo json_encode($file_info);
                     }


//home app image upload

$img2='appimage';
         $image_upload_folder = FCPATH . "assets/uploads/categoryAppImg/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="categoryAppImg".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img2))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);

           $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/categoryAppImg/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnnn=$file_info['file_name'];
                         $nnnn2=$videoNAmePath;

                         // echo json_encode($file_info);
                     }





                     $this->db->select('sort_id');
                   $this->db->from('tbl_category');
                   $this->db->where('sort_id',$sort_id);
                   $sort_iddd= $this->db->get()->row();

if(empty($sort_iddd)){



           $data_insert = array(
                  'name'=>$name,
                  'image'=>$nnnn1,
                  'app_image'=>$nnnn2,
                  'sort_id'=>$sort_id,
                  'subtext1'=>$subtext1,
                  'subtext2'=>$subtext2,
                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_category",$data_insert,1);
      }else{

           $this->session->set_flashdata('emessage',"This sort id is already exist for other category.");
           redirect($_SERVER['HTTP_REFERER']);
      }

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_category');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();



//home app image upload

$img2='appimage';

         $image_upload_folder = FCPATH . "assets/uploads/categoryAppImg/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="categoryAppImg".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img2))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);

           // $this->session->set_flashdata('emessage',$upload_error);
             // redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/categoryAppImg/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnnn=$file_info['file_name'];
                         $nnnn2=$videoNAmePath;

                         // echo json_encode($file_info);
                     }




 if(!empty($da)){ $img = $da ->app_image;
if(!empty($img)) { if(empty($nnnn2)){ $nnnn2 = $img; }
}else{ if(empty($nnnn2)){ $nnnn2= ""; } } }




$img1='image';

         $image_upload_folder = FCPATH . "assets/uploads/category/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="category".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img1))
                     {
                         $upload_error = $this->upload->display_errors();
                         // echo json_encode($upload_error);

           // $this->session->set_flashdata('emessage',$upload_error);
             // redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/category/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn1=$videoNAmePath;

                         // echo json_encode($file_info);
                     }




 if(!empty($da)){ $img = $da ->image;
if(!empty($img)) { if(empty($nnnn1)){ $nnnn1 = $img; } }else{ if(empty($nnnn1)){ $nnnn1= ""; } } }

$this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('id',$idw);
$so_id= $this->db->get()->row();

//if($so_id->sort_id == $sort_id){
if($sort_id == $so_id->sort_id){

           $data_insert = array(
                  'name'=>$name,
  'image'=>$nnnn1,
  'app_image'=>$nnnn2,
  'sort_id'=>$sort_id,
  'subtext1'=>$subtext1,
  'subtext2'=>$subtext2,

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_category', $data_insert);
        }
else{
  $this->db->select('sort_id');
$this->db->from('tbl_category');
$this->db->where('sort_id',$sort_id);
$sort_iddds= $this->db->get()->row();
      if(empty($sort_iddds)){

        $data_insert = array(
               'name'=>$name,
              'image'=>$nnnn1,
              'sort_id'=>$sort_id,

                  );
          $this->db->where('id', $idw);
          $last_id=$this->db->update('tbl_category', $data_insert);

      }
        else{

             $this->session->set_flashdata('emessage',"This sort id is already exist for other category.");
             redirect($_SERVER['HTTP_REFERER']);
        }
}
          // }
}

                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/category/view_category","refresh");
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

               public function updatecategoryStatus($idd,$t){

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
                       $zapak=$this->db->update('tbl_category', $data_update);

                            if($zapak!=0){

//update status of products related to this category


$this->db->select('id');
$this->db->from('tbl_product');
$this->db->where("category_id",$id);
$this->db->where("is_active", 0);
$category_products_data= $this->db->get();

if(!empty($category_products_data)){
 foreach ($category_products_data->result()  as $cat_product) {

   $data_update_de= array(
    'is_active'=>1
   );

   $this->db->where('id', $cat_product->id);
   $this->db->where("is_active", 0);
   $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
 }
}






                            redirect("dcadmin/category/view_category","refresh");
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
                         $zapak=$this->db->update('tbl_category', $data_update);

                             if($zapak!=0){

   //update status of products related to this category

   $this->db->select('id');
   $this->db->from('tbl_product');
   $this->db->where("category_id",$id);
   $this->db->where("is_active", 1);
   $category_products_data= $this->db->get();

   if(!empty($category_products_data)){
    foreach ($category_products_data->result()  as $cat_product) {

      $data_update_de= array(
       'is_active'=>0
      );

      $this->db->where('id', $cat_product->id);
      $this->db->where("is_active", 1);
      $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
    }
   }



                             redirect("dcadmin/category/view_category","refresh");
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



               public function delete_category($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     $this->db->select('image');
                     $this->db->from('tbl_category');
                     $this->db->where('id',$id);
                     $dsa= $this->db->get();
                     $da=$dsa->row();
                     $img=$da->image;

 $zapak=$this->db->delete('tbl_category', array('id' => $id));
 if($zapak!=0){

   $this->db->select('id');
   $this->db->from('tbl_product');
   $this->db->where("category_id",$id);
   $this->db->where("is_cat_delete", 0);
   $category_products_data= $this->db->get();

if(!empty($category_products_data)){
    foreach ($category_products_data->result()  as $cat_product) {

      $data_update_de= array(
        'is_cat_delete' => 1
      );

      $this->db->where('id', $cat_product->id);
      $this->db->where("is_cat_delete", 0);
      $isdeletedCategory=$this->db->update('tbl_product', $data_update_de);
    }
}



        $path = FCPATH .$img;
          unlink($path);
        redirect("dcadmin/category/view_category","refresh");
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
