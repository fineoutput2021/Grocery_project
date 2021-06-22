<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Sliders2 extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}

		public function error404()
			{
					$this->load->view('errors/error404');

			}


			public function edit_slider_images($idd)
				{
					if (!empty($this->session->userdata('admin_data'))) {


						$id = base64_decode($idd);

						$data['idd'] = $idd;

						$this->db->select('*');
						$this->db->from('tbl_sliders2');
						$this->db->where('id', $id);
						$data['edit_slider_images'] = $this->db->get()->row();

						$this->load->view('admin/common/header_view', $data);
						$this->load->view('admin/slider2/edit_slider_images');
						$this->load->view('admin/common/footer_view');
					} else {

						$this->load->view('admin/login/index');
					}
				}


	function add_slider_images()
	{
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/slider2/add_slider_images');
		$this->load->view('admin/common/footer_view');
	}

		public function view_slider()
		{

			if (!empty($this->session->userdata('admin_data'))) {
				$this->db->select('*');
				$this->db->from('tbl_sliders2');
				// $this->db->where('student_shift',$cvf);
				$data['slider'] = $this->db->get();

				$this->load->view('admin/common/header_view', $data);
				$this->load->view('admin/slider2/slider');
				$this->load->view('admin/common/footer_view');
			} else {

				$this->load->view('admin/login/index');
			}
		}

		public function add_slider_images_all($t, $iw = "")
		{
			if (!empty($this->session->userdata('admin_data'))) {
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->load->library('upload');
				$this->load->helper('security');
				if ($this->input->post()) {
					// print_r($this->input->post());
					// exit;
					$this->form_validation->set_rules('image_name', 'image_name', 'required|customAlpha|xss_clean|trim');
					$this->form_validation->set_rules('link', 'link', 'xss_clean|trim');
					$this->form_validation->set_rules('device_type', 'device_type', 'required');
					$this->form_validation->set_rules('category', 'category', 'required|xss_clean|trim');
					$this->form_validation->set_rules('subcategory', 'subcategory', 'required|xss_clean|trim');



					if ($this->form_validation->run() == TRUE) {

						$image_name = $this->input->post('image_name');
						$category = $this->input->post('category');
						$subcategory = $this->input->post('subcategory');
						$link = $this->input->post('link');
						$device_type = $this->input->post('device_type');

						$img1 = 'fileToUpload1';
						$image_upload_folder = FCPATH . "assets/admin/all_img/slider_images/";
						if (!file_exists($image_upload_folder)) {
							mkdir($image_upload_folder, DIR_WRITE_MODE, true);
						}
						$new_file_name = "category_images" . date("Ymdhms");
						$this->upload_config = array(
							'upload_path'   => $image_upload_folder,
							'file_name' => $new_file_name,
							'allowed_types' => 'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png|webp',
							'max_size'      => 25000
						);
						$this->upload->initialize($this->upload_config);
						if (!$this->upload->do_upload($img1)) {
							$upload_error = $this->upload->display_errors();
							// echo json_encode($upload_error);
							// echo $upload_error;

						} else {

							$file_info = $this->upload->data();

							$videoNAmePath = "assets/admin/all_img/slider_images/" . $new_file_name . $file_info['file_ext'];
							$file_info['new_name'] = $videoNAmePath;
							// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
							$nnnn1 = $file_info['file_name'];
							// echo json_encode($file_info);
							$nnnn=$videoNAmePath;
						}


						$ip = $this->input->ip_address();
						date_default_timezone_set("Asia/Calcutta");
						$cur_date = date("Y-m-d H:i:s");
						$added_by = $this->session->userdata('admin_id');

						$typ = base64_decode($t);
						if ($typ == 1) {

							$data_insert = array(
								'image_name' => $image_name,
								'category' => $category,
								'subcategory' => $subcategory,
								'image' => $nnnn,
								'link'=>$link,
								'date' => $cur_date,
								'ip' => $ip,
								'added_by' => $added_by,
								'is_active' => 1,
								'device_type'=> $device_type

							);

							$last_id = $this->base_model->insert_table("tbl_sliders2", $data_insert, 1);
						}

						if ($typ == 2) {

							$idw = base64_decode($iw);

							if(!empty($nnnn)){
							$this->db->select('*');
							$this->db->from('tbl_sliders2');
							$this->db->where('image', $nnnn);
							$damm = $this->db->get();
							foreach ($damm->result() as $da) {
								$uid = $da->image;
								if ($uid == $idw) {
								} else {
									echo "Multiple Entry of Same Name";
									exit;
								}
							}
						}
							if(empty($nnnn)){
							$this->db->select('*');
							$this->db->from('tbl_sliders2');
							$this->db->where('id', $idw);
							$damm_img = $this->db->get()->row();
							$nnnn = $damm_img->image;
							}

							$data_insert = array(
								'image_name' => $image_name,
								'category' => $category,
								'subcategory' => $subcategory,
								'link'=>$link,
								'image' => $nnnn,
								'date' => $cur_date,
								'ip' => $ip,
								'added_by' => $added_by,
								'is_active' => 1,
								'device_type'=> $device_type
							);
							$this->db->where('id', $idw);
							$last_id = $this->db->update('tbl_sliders2', $data_insert);
						}
						if ($last_id != 0) {
							redirect("dcadmin/Sliders2/view_slider", "refresh");
						} else {

							$data['e'] = "Sorry Error Occured";

							// $this->load->view('errors/error500admin',$data);


						}
					} else {

						echo validation_errors();
						exit;
						// $this->load->view('errors/error500admin',$data);
					}
				} else {

					$data['e'] = "Please insert some data, No data available";

					// $this->load->view('errors/error500admin',$data);

				}
			} else {

				$this->load->view('admin/login/index');
			}
		}




		// slider delete class
		public function delete_slider_all($idd)
		{

			if (!empty($this->session->userdata('admin_data'))) {


				$data['user_name'] = $this->load->get_var('user_name');

				// echo SITE_NAME;
				// echo $this->session->userdata('image');
				// echo $this->session->userdata('position');
				// exit;
				$id = base64_decode($idd);

				if ($this->load->get_var('position') == "Super Admin") {

					$this->db->select('image');
					$this->db->from('tbl_sliders2');
					$this->db->where('id', $id);
					$dsa = $this->db->get();
					$da = $dsa->row();
					$img = $da->image;

					$zapak = $this->db->delete('tbl_sliders2', array('id' => $id));

					if ($zapak != 0) {
						$path = FCPATH . "assets/admin/all_img/slider_images/" . $img;

						redirect("dcadmin/Sliders2/view_slider", "refresh");
					} else {
						echo "Error";
						exit;
					}
				} else {
					$data['e'] = "Sorry You Don't Have Permission To Delete Anything.";
					// exit;
					$this->load->view('errors/error500admin', $data);
				}
			} else {

				$this->load->view('admin/login/index');
			}
		}


		public function updatesliderStatus($idd,$t){

		         if(!empty($this->session->userdata('admin_data'))){


		           $data['user_name']=$this->load->get_var('user_name');

		           // echo SITE_NAME;
		           // echo $this->session->userdata('image');
		           // echo $this->session->userdata('position');
		           // exit;
		           $id=base64_decode($idd);

		$dww=$this->session->userdata('admin_id');

		if($id==$dww){
		$this->session->set_flashdata('emessage',"Sorry You can't change status of yourself");
		  redirect($_SERVER['HTTP_REFERER']);
		}


		  if($this->load->get_var('position')=="Super Admin"){

		           if($t=="active"){
		             $data_update = array(
		         		'is_active'=>1

		         );

		         $this->db->where('id', $id);
		        $zapak=$this->db->update('tbl_sliders2', $data_update);

		             if($zapak!=0){
									 	$this->session->set_flashdata('smessage','Status successfully Updated');
		             redirect("dcadmin/Sliders2/view_slider","refresh");
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
		          $zapak=$this->db->update('tbl_sliders2', $data_update);

		              if($zapak!=0){
										$this->session->set_flashdata('smessage','Status successfully Updated');

		              redirect("dcadmin/Sliders2/view_slider","refresh");
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



					 public function get_subcateg_data(){
					 	//$this->load->view('layout/header');
						// alert("hi");

					 	 $category_id= trim($this->input->post('category_id'));

// echo "hi";exit;

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




					 public function get_subcateg2_data(){
					 	//$this->load->view('layout/header');
						// alert("hi");
$subcategory_id=$_GET['isl'];
				//	 	 $category_id= trim($this->input->post('category_id'));
					 	 //$subcategory_id= trim($this->input->post('subcategory_id'));
//echo $category_id;
// echo "hi";exit;

					 	      			$this->db->select('*');
					 	$this->db->from('tbl_sub_category2');
					// 	$this->db->where('category_id',$category_id);
					 	$this->db->where('subcategory_id',$subcategory_id);
					 	$subcategory2list= $this->db->get();

					 //	 print_r($subcategory2list->result());

					 	if(!empty($subcategory2list)){
					 		// $data['data']='true';
					 		// 	//$data['cate_id']=$category_id;
					 		// $data['subcategory2list']=$subcategory2list->result();
					  // echo json_encode($data); exit;
foreach($subcategory2list->result() as $data) {
$res[] = array('id' =>$data->id,'name' =>$data->name );
}

if(!empty($res)){
echo json_encode($res);
exit;
}
else{
	echo "NA";
	exit;
}
					 	}
					 	else{
					 		$data['data']=false;
					 		$data['cate_id']=$category_id;
					 	$data['subcategory2list']="";
					  // echo json_encode($data); exit;
					 	}
					 echo json_encode($data);
					 	// $this->load->view('add_adress',$data);
					 }






}
