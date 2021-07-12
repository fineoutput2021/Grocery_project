<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Sub_category2 extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_sub_category2(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

                           $this->db->select('*');
               $this->db->from('tbl_sub_category2');
               //$this->db->where('id',$usr);
               $data['sub_category2_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/sub_category2/view_sub_category2');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_sub_category2(){

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
                   $this->load->view('admin/sub_category2/add_sub_category2');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_sub_category2($idd){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                            $this->db->select('*');
                            $this->db->from('tbl_sub_category2');
                            $this->db->where('id',$id);
                            $data['sub_category2_data']= $this->db->get()->row();


                            $this->db->select('*');
                             $this->db->from('tbl_category');
                             $this->db->where('is_active', 1);
                             $data['category_data']= $this->db->get();

                             $this->db->select('*');
                              $this->db->from('tbl_subcategory');
                              $this->db->where('is_cat_delete',0);
                              $this->db->where('is_active', 1);
                              $data['subcategory_data']= $this->db->get();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/sub_category2/update_sub_category2');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_sub_category2_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
  $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('subtext1', 'subtext1', 'required|xss_clean|trim');





               if($this->form_validation->run()== TRUE)
               {
  $name=$this->input->post('name');
  $category_id=$this->input->post('category_id');
  $subcategory_id=$this->input->post('subcategory_id');
  $subtext1=$this->input->post('subtext1');

                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

           $typ=base64_decode($t);
           $last_id = 0;
           if($typ==1){



$img4='image';


           $file_check=($_FILES['image']['error']);
if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/sub_category2/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="sub_category2".date("Ymdhms");
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

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/sub_category2/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn4=$videoNAmePath;

                         // echo json_encode($file_info);
                     }
        }



           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'subtext1'=>$subtext1,
  'image'=>$nnnn4,

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_sub_category2",$data_insert,1) ;

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_sub_category2');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();



$img4='image';


           $file_check=($_FILES['image']['error']);
if($file_check!=4){

         $image_upload_folder = FCPATH . "assets/uploads/sub_category2/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="sub_category2".date("Ymdhms");
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

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                     }
                     else
                     {

                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/sub_category2/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn4=$videoNAmePath;

                         // echo json_encode($file_info);
                     }
        }



 if(!empty($da)){ $img = $da ->image;
if(!empty($img)) { if(empty($nnnn4)){ $nnnn4 = $img; } }else{ if(empty($nnnn4)){ $nnnn4= ""; } } }

           $data_insert = array(
                  'name'=>$name,
  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'subtext1'=>$subtext1,
  'image'=>$nnnn4,

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_sub_category2', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/sub_category2/view_sub_category2","refresh");
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

               public function updatesub_category2Status($idd,$t){

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
                       $zapak=$this->db->update('tbl_sub_category2', $data_update);

                            if($zapak!=0){


          //update status of products related to this subcategory2


          $this->db->select('id');
          $this->db->from('tbl_product');
          $this->db->where("subcategory2_id",$id);
          $this->db->where("is_active", 0);
          $subcategory2_products_data= $this->db->get();

          if(!empty($subcategory2_products_data)){
           foreach ($subcategory2_products_data->result()  as $subcat2_product) {

             $data_update_de= array(
              'is_active'=>1
             );

             $this->db->where('id', $subcat2_product->id);
             $this->db->where("is_active", 0);
             $isdeletedSubCategory2=$this->db->update('tbl_product', $data_update_de);
           }
          }


                            redirect("dcadmin/sub_category2/view_sub_category2","refresh");
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
                         $zapak=$this->db->update('tbl_sub_category2', $data_update);

                             if($zapak!=0){


       //update status of products related to this subcategory2

       $this->db->select('id');
       $this->db->from('tbl_product');
       $this->db->where("subcategory2_id",$id);
       $this->db->where("is_active", 1);
       $subcategory2_products_data= $this->db->get();

       if(!empty($subcategory2_products_data)){
        foreach ($subcategory2_products_data->result()  as $subcat2_product) {

          $data_update_de= array(
           'is_active'=>0
          );

          $this->db->where('id', $subcat2_product->id);
          $this->db->where("is_active", 1);
          $isdeletedSubCategory2=$this->db->update('tbl_product', $data_update_de);
        }
       }




                             redirect("dcadmin/sub_category2/view_sub_category2","refresh");
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



               public function delete_sub_category2($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     $this->db->select('image');
                     $this->db->from('tbl_sub_category2');
                     $this->db->where('id',$id);
                     $dsa= $this->db->get();
                     $da=$dsa->row();
                     $img=$da->image;

 $zapak=$this->db->delete('tbl_sub_category2', array('id' => $id));
 if($zapak!=0){



   //update delete status for subcategory2

             $this->db->select('id');
             $this->db->from('tbl_product');
             $this->db->where("subcategory2_id",$id);
             $this->db->where("is_subcate2_delete", 0);
             $subcategory2_products_data= $this->db->get();

          if(!empty($subcategory2_products_data)){
              foreach ($subcategory2_products_data->result()  as $subcat2_product) {

                $data_update_de= array(
                  'is_subcate2_delete' => 1
                );

                $this->db->where('id', $subcat2_product->id);
                $this->db->where("is_subcate2_delete", 0);
                $isdeletedSubCategory2=$this->db->update('tbl_product', $data_update_de);
              }
          }



        $path = FCPATH .$img;
          unlink($path);
        redirect("dcadmin/sub_category2/view_sub_category2","refresh");
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


                            public function get_subcateg_data(){
                 					 	//$this->load->view('layout/header');

                 					 	 $category_id= trim($this->input->post('category_id'));


                 					 	      			$this->db->select('*');
                 					 	$this->db->from('tbl_subcategory');
                 					 	$this->db->where('category_id',$category_id);
                 					 	$subcategorylist= $this->db->get();

                 					 	 // print_r($subcategorylist->result()); die();

                 					 	if(!empty($subcategorylist)){
                 					 		$data['data']=true;
                 					 			$data['cate_id']=$category_id;
                 					 		$data['subcategorylist']=$subcategorylist->result();
                 					  // echo json_encode($data); exit;
                 					 	}
                 					 	else{
                 					 		$data['data']=false;
                 					 		$data['cate_id']=$category_id;
                 					 	$data['subcategorylist']="";
                 					  // echo json_encode($data); exit;
                 					 	}
                 					 echo json_encode($data);
                 					 	// $this->load->view('add_adress',$data);
                 					 }







                      }

      ?>
