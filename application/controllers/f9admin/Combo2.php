<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class combo2 extends CI_finecontrol{
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


public function combo2(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_combo2');
//$this->db->where('',);
$data['combo2']= $this->db->get();

$this->db->select('*');
$this->db->from('tbl_combo2');
//$this->db->where('',);
$data['combo2_count']= $this->db->count_all_results();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/combo2/view_combo2');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_combo2(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('is_active',1);
// $this->db->where('is_cat_delete',0);
// $this->db->where('is_subcat_delete',0);
$data['subcategory']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/combo2/add_combo2');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_combo2_data($t)

{

if(!empty($this->session->userdata('admin_data'))){

$td=base64_decode($t);

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

$addedby=$this->session->userdata('admin_id');

$data_insert = array('product_id'=>$td,
'ip' =>$ip,
'added_by' =>$addedby,
'date'=>$cur_date
);





$last_id=$this->base_model->insert_table("tbl_combo2",$data_insert,1) ;


if($last_id!=0){

$this->session->set_flashdata('smessage','Data inserted successfully');

redirect("dcadmin/combo2/combo2","refresh");

}

else

{

$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);


}


}
else{

redirect("login/admin_login","refresh");


}

}

public function delete_combo2($idd){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);

if($this->load->get_var('position')=="Super Admin"){



$zapak=$this->db->delete('tbl_combo2', array('id' => $id));
if($zapak!=0){

redirect("dcadmin/combo2/combo2","refresh");
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
