<?php
		if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			 require_once(APPPATH . 'core/CI_finecontrol.php');
			 class Messages extends CI_finecontrol{
			 function __construct()
					 {
						 parent::__construct();
						 $this->load->model("login_model");
						 $this->load->model("admin/base_model");
						 $this->load->library('user_agent');
						 $this->load->library('upload');
					 }

				 public function view_messages(){

						if(!empty($this->session->userdata('admin_data'))){


	 						$this->db->select('*');
							 $this->db->from('tbl_messages');
							 $data['messages_data']= $this->db->get();

							$this->load->view('admin/common/header_view',$data);
							$this->load->view('admin/messages/view_messages');
							$this->load->view('admin/common/footer_view');

					}
					else{

						 redirect("login/admin_login","refresh");
					}

					}

							public function add_messages(){

								 if(!empty($this->session->userdata('admin_data'))){

									 $this->load->view('admin/common/header_view');
									 $this->load->view('admin/messages/add_messages');
									 $this->load->view('admin/common/footer_view');

							 }
							 else{

									redirect("login/admin_login","refresh");
							 }

							 }

							 public function update_messages($idd){

									 if(!empty($this->session->userdata('admin_data'))){


										 $data['user_name']=$this->load->get_var('user_name');

										 // echo SITE_NAME;
										 // echo $this->session->userdata('image');
										 // echo $this->session->userdata('position');
										 // exit;

											$id=base64_decode($idd);
										 $data['id']=$idd;

														$this->db->select('*');
														$this->db->from('tbl_messages');
														$this->db->where('id',$id);
														$data['messages_data']= $this->db->get()->row();


										 $this->load->view('admin/common/header_view',$data);
										 $this->load->view('admin/messages/update_messages');
										 $this->load->view('admin/common/footer_view');

								 }
								 else{

										redirect("login/admin_login","refresh");
								 }

								 }

						 public function send_message(){



						 $this->load->helper(array('form', 'url'));
						 $this->load->library('form_validation');
						 $this->load->helper('security');
						 if($this->input->post())
						 {
							$this->form_validation->set_rules('first_name', 'first_name', 'required');
							$this->form_validation->set_rules('last_name', 'last_name', 'required');
							$this->form_validation->set_rules('phone_no', 'phone_no', 'required');
							$this->form_validation->set_rules('email', 'email', 'required');
							$this->form_validation->set_rules('message', 'message', 'required');
 						if($this->form_validation->run()== TRUE)
														 {
								$first_name=$this->input->post('first_name');
								$last_name=$this->input->post('last_name');
								$phone_no=$this->input->post('phone_no');
								$email=$this->input->post('email');
								$message=$this->input->post('message');

									 $ip = $this->input->ip_address();
									 date_default_timezone_set("Asia/Calcutta");
									 $cur_date=date("Y-m-d H:i:s");
									 $addedby = 0;
									 if(!empty($this->session->userdata('user_data'))){

										$addedby=$this->session->userdata('customer_id');
									}


												$data_insert = array(
												'first_name'=>$first_name,
												'last_name'=>$last_name,
												'phone_no'=>$phone_no,
												'email'=>$email,
												'message'=>$message,
												'ip' =>$ip,
												'added_by' =>$addedby,
												'date'=>$cur_date
												);


					 $last_id=$this->base_model->insert_table("tbl_messages",$data_insert,1) ;

											 if($last_id!=0){
															 $this->session->set_flashdata('smessage','Thank you for contacting us.<br> We will reach your query soon');
															 redirect("home","refresh");
															}else{
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

							 public function updatemessagesStatus($idd,$t){

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
											 $zapak=$this->db->update('tbl_messages', $data_update);

														if($zapak!=0){
														redirect("dcadmin/messages/view_messages","refresh");
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
												 $zapak=$this->db->update('tbl_messages', $data_update);

														 if($zapak!=0){
														 redirect("dcadmin/messages/view_messages","refresh");
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



							 public function delete_messages($idd){

											if(!empty($this->session->userdata('admin_data'))){

												$data['user_name']=$this->load->get_var('user_name');

												// echo SITE_NAME;
												// echo $this->session->userdata('image');
												// echo $this->session->userdata('position');
												// exit;
												$id=base64_decode($idd);

											 if($this->load->get_var('position')=="Super Admin"){

										 $this->db->select('image');
										 $this->db->from('tbl_messages');
										 $this->db->where('id',$id);
										 $dsa= $this->db->get();
										 $da=$dsa->row();
										 $img=$da->image;

 $zapak=$this->db->delete('tbl_messages', array('id' => $id));
 if($zapak!=0){
				$path = FCPATH .$img;
					unlink($path);
				redirect("dcadmin/messages/view_messages","refresh");
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
