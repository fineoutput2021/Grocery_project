<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Sub_Category extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_sub_category(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

              $this->db->select('*');
               $this->db->from('tbl_subcategory');
               //$this->db->where('id',$usr);

               $data['subcategory_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/subcategory/view_subcategory');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_subcategory(){

                 if(!empty($this->session->userdata('admin_data'))){

                    $this->db->select('*');
                  $this->db->from('tbl_category');
                  //$this->db->where('',);
                  $data['category_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/subcategory/add_subcategory');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_subcategory($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_subcategory');
                            $this->db->where('id',$id);
                            $data['subcategory_data']= $this->db->get()->row();

                              $this->db->select('*');
                            $this->db->from('tbl_category');
                            //$this->db->where('',);
                            $data['category_data']= $this->db->get();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/subcategory/update_subcategory');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_subcategory_data($t,$iw="")

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
  $this->form_validation->set_rules('subtext1', 'subtext1', 'trim|xss_clean');



               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
   $category_id=$this->input->post('category_id');
   $subtext1=$this->input->post('subtext1');

                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){
$img1='image';
         $image_upload_folder = FCPATH . "assets/uploads/subcategory/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="subcategory".date("Ymdhms");
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

                         $videoNAmePath = "assets/uploads/subcategory/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn1=$videoNAmePath;

                         // echo json_encode($file_info);
                     }

           $data_insert = array(
                  'name'=>$name,
                  'image'=>$nnnn1,
                  'subtext1'=>$subtext1,

                  'category_id'=>$category_id,
                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_subcategory",$data_insert,1);


           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_subcategory');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();

$img1='image';

         $image_upload_folder = FCPATH . "assets/uploads/subcategory/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="subcategory".date("Ymdhms");
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

                         $videoNAmePath = "assets/uploads/subcategory/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn1=$videoNAmePath;

                         // echo json_encode($file_info);
                     }




 if(!empty($da)){ $img = $da ->image;
if(!empty($img)) { if(empty($nnnn1)){ $nnnn1 = $img; } }else{ if(empty($nnnn1)){ $nnnn1= ""; } } }

            $data_insert = array(
               'name'=>$name,
              'image'=>$nnnn1,
              'subtext1'=>$subtext1,
              'category_id'=>$category_id,

                  );
          $this->db->where('id', $idw);
          $last_id=$this->db->update('tbl_subcategory', $data_insert);



          // }
}

                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/Sub_category/view_sub_category","refresh");
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

           public function updatesubcategoryStatus($idd,$t){

                    if(!empty($this->session->userdata('admin_data'))){


                      $data['user_name']=$this->load->get_var('user_name');

                      // echo SITE_NAME;
                      // echo $this->session->userdata('image');
                      // echo $this->session->userdata('position');
                      // exit;
                      $id=base64_decode($idd);

          if($this->load->get_var('position')=="Super Admin"){

                      if($t=="active"){
                        $data_update = array(
                       'is_active'=>1

                    );

                    $this->db->where('id', $id);
                   $zapak=$this->db->update('tbl_subcategory', $data_update);

                        if($zapak!=0){


    //update status of products related to this subcategory


    $this->db->select('id');
    $this->db->from('tbl_product');
    $this->db->where("subcategory_id",$id);
    $this->db->where("is_active", 0);
    $subcategory_products_data= $this->db->get();

    if(!empty($subcategory_products_data)){
     foreach ($subcategory_products_data->result()  as $subcat_product) {

       $data_update_de= array(
        'is_active'=>1
       );

       $this->db->where('id', $subcat_product->id);
       $this->db->where("is_active", 0);
       $isdeletedSubCategory=$this->db->update('tbl_product', $data_update_de);
     }
    }


                           $this->session->set_flashdata('smessage','Status successfully Updated');
                        redirect("dcadmin/Sub_category/view_sub_category","refresh");
                                }
                                else
                                {
                                  $this->session->set_flashdata('emessage','Error Occured');
                                    redirect($_SERVER['HTTP_REFERER']);
                                }
                      }
                      if($t=="inactive"){
                        $data_update = array(
                     'is_active'=>0

                     );

                     $this->db->where('id', $id);
                     $zapak=$this->db->update('tbl_subcategory', $data_update);

                         if($zapak!=0){


       //update status of products related to this subcategory

       $this->db->select('id');
       $this->db->from('tbl_product');
       $this->db->where("subcategory_id",$id);
       $this->db->where("is_active", 1);
       $subcategory_products_data= $this->db->get();

       if(!empty($subcategory_products_data)){
        foreach ($subcategory_products_data->result()  as $subcat_product) {

          $data_update_de= array(
           'is_active'=>0
          );

          $this->db->where('id', $subcat_product->id);
          $this->db->where("is_active", 1);
          $isdeletedSubCategory=$this->db->update('tbl_product', $data_update_de);
        }
       }



                           $this->session->set_flashdata('smessage','Status successfully Updated');

                         redirect("dcadmin/Sub_category/view_sub_category","refresh");
                                 }
                                 else
                                 {

                     $this->session->set_flashdata('emessage','Error Occured');
                       redirect($_SERVER['HTTP_REFERER']);
                                 }
                      }
                   }
                   else{
                     $this->session->set_flashdata('emessage','Sorry you dont have Permission to change admin, Only Super admin can change status');
                       redirect($_SERVER['HTTP_REFERER']);
                   }


                  }
                  else{

                      redirect("login/admin_login","refresh");
                  }

                  }

                  public function delete_subcategory($idd){

                                 if(!empty($this->session->userdata('admin_data'))){


                                   $data['user_name']=$this->load->get_var('user_name');

                                   // echo SITE_NAME;
                                   // echo $this->session->userdata('image');
                                   // echo $this->session->userdata('position');
                                   // exit;
                  $id=base64_decode($idd);

                                  if($this->load->get_var('position')=="Super Admin"){

                              $this->db->select('id');
                                $this->db->from('tbl_subcategory');
                                $this->db->where('id',$id);
                                $dsa= $this->db->get();
                                $da=$dsa->row();
                                $id=$da->id;

                  $zapak=$this->db->delete('tbl_subcategory', array('id' => $id));
                  if($zapak!=0){


//update delete status for subcategory

          $this->db->select('id');
          $this->db->from('tbl_product');
          $this->db->where("subcategory_id",$id);
          $this->db->where("is_subcat_delete", 0);
          $subcategory_products_data= $this->db->get();

       if(!empty($subcategory_products_data)){
           foreach ($subcategory_products_data->result()  as $subcat_product) {

             $data_update_de= array(
               'is_subcat_delete' => 1
             );

             $this->db->where('id', $subcat_product->id);
             $this->db->where("is_subcat_delete", 0);
             $isdeletedSubCategory=$this->db->update('tbl_product', $data_update_de);
           }
       }




                  //      $path = FCPATH . "assets/public/slider/".$id;
                  // unlink($path);
                  redirect("dcadmin/Sub_category/view_sub_category","refresh");
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
