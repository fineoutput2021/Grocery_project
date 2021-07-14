<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class AppSlider extends CI_finecontrol{
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


public function edit_appslider_images($idd)
{
if (!empty($this->session->userdata('admin_data'))) {


$id = base64_decode($idd);

$data['idd'] = $idd;

$this->db->select('*');
$this->db->from('tbl_appslider');
$this->db->where('id', $id);
$data['edit_slider_images'] = $this->db->get()->row();

$this->load->view('admin/common/header_view', $data);
$this->load->view('admin/appslider/edit_appslider_images');
$this->load->view('admin/common/footer_view');
} else {

$this->load->view('admin/login/index');
}
}


function add_appslider_images()
{
$this->load->view('admin/common/header_view');
$this->load->view('admin/appslider/add_appslider_images');
$this->load->view('admin/common/footer_view');
}

public function view_appslider()
{

if (!empty($this->session->userdata('admin_data'))) {
$this->db->select('*');
$this->db->from('tbl_appslider');
// $this->db->where('student_shift',$cvf);
$data['slider'] = $this->db->get();

$this->load->view('admin/common/header_view', $data);
$this->load->view('admin/appslider/view_appslider');
$this->load->view('admin/common/footer_view');
} else {

$this->load->view('admin/login/index');
}
}

public function add_appslider_images_all($t, $iw = "")
{
if (!empty($this->session->userdata('admin_data'))) {
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->library('upload');
$this->load->helper('security');
if ($this->input->post()) {
// print_r($this->input->post());
// exit;
$this->form_validation->set_rules('image_name', 'image_name', 'required|xss_clean|trim');
// $this->form_validation->set_rules('link', 'link', 'xss_clean|trim');



if ($this->form_validation->run() == TRUE) {

$image_name = $this->input->post('image_name');
// $link = $this->input->post('link');

$img1 = 'fileToUpload1';
$image_upload_folder = FCPATH . "assets/admin/all_img/app_slider_images/";
if (!file_exists($image_upload_folder)) {
mkdir($image_upload_folder, DIR_WRITE_MODE, true);
}
$new_file_name = "app_slider_images" . date("Ymdhms");
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

$videoNAmePath = "assets/admin/all_img/app_slider_images/" . $new_file_name . $file_info['file_ext'];
$file_info['new_name'] = $videoNAmePath;
// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
$nnnn = $file_info['file_name'];
// echo json_encode($file_info);
}


$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date = date("Y-m-d H:i:s");
$added_by = $this->session->userdata('admin_id');

$typ = base64_decode($t);
if ($typ == 1) {

$data_insert = array(
'image_name' => $image_name,
'image' => $nnnn,
// 'link'=>$link,
'date' => $cur_date,
'ip' => $ip,
'added_by' => $added_by,
'is_active' => 1

);

$last_id = $this->base_model->insert_table("tbl_appslider", $data_insert, 1);
}

if ($typ == 2) {

$idw = base64_decode($iw);

if(!empty($nnnn)){
$this->db->select('*');
$this->db->from('tbl_appslider');
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
$this->db->from('tbl_appslider');
$this->db->where('id', $idw);
$damm_img = $this->db->get()->row();
$nnnn = $damm_img->image;
}

$data_insert = array(
'image_name' => $image_name,
// 'link'=>$link,
'image' => $nnnn,
'date' => $cur_date,
'ip' => $ip,
'added_by' => $added_by,
'is_active' => 1
);
$this->db->where('id', $idw);
$last_id = $this->db->update('tbl_appslider', $data_insert);
}
if ($last_id != 0) {
redirect("dcadmin/AppSlider/view_appslider", "refresh");
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
public function delete_appslider_all($idd)
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
$this->db->from('tbl_appslider');
$this->db->where('id', $id);
$dsa = $this->db->get();
$da = $dsa->row();
$img = $da->image;

$zapak = $this->db->delete('tbl_appslider', array('id' => $id));

if ($zapak != 0) {
$path = FCPATH . "assets/admin/all_img/app_slider_images/" . $img;

redirect("dcadmin/AppSlider/view_appslider", "refresh");
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


public function updateappsliderStatus($idd,$t){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);

$dww=$this->session->userdata('admin_id');

// if($id==$dww){
// $this->session->set_flashdata('emessage',"Sorry You can't change status of yourself");
//   redirect($_SERVER['HTTP_REFERER']);
// }


if($this->load->get_var('position')=="Super Admin"){

if($t=="active"){
$data_update = array(
'is_active'=>1

);

$this->db->where('id', $id);
$zapak=$this->db->update('tbl_appslider', $data_update);

if($zapak!=0){
$this->session->set_flashdata('smessage','Status successfully Updated');
redirect("dcadmin/AppSlider/view_appslider","refresh");
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
$zapak=$this->db->update('tbl_appslider', $data_update);

if($zapak!=0){
$this->session->set_flashdata('smessage','Status successfully Updated');

redirect("dcadmin/AppSlider/view_appslider","refresh");
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

public function recent_products(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_recent_products');
//$this->db->where('',);
$data['recent_products']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/recent_products/view_recent');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_recent_products(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('is_cat_delete',0);
$this->db->where('is_subcat_delete',0);
$data['products']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/recent_products/add_recent');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_recent_data($t)

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





$last_id=$this->base_model->insert_table("tbl_recent_products",$data_insert,1) ;


if($last_id!=0){

$this->session->set_flashdata('smessage','Data inserted successfully');

redirect("dcadmin/AppSlider/recent_products","refresh");

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

public function delete_recent_products($idd){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);

if($this->load->get_var('position')=="Super Admin"){



$zapak=$this->db->delete('tbl_recent_products', array('id' => $id));
if($zapak!=0){

redirect("dcadmin/AppSlider/recent_products","refresh");
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

public function trending_products(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_trending_products');
//$this->db->where('',);
$data['trending_products']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/tren_products/view_tren');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_trending_products(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('is_active',1);
$this->db->where('is_cat_delete',0);
$this->db->where('is_subcat_delete',0);
$data['products']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/tren_products/add_tren');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


public function add_trending_data($t)

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





$last_id=$this->base_model->insert_table("tbl_trending_products",$data_insert,1) ;


if($last_id!=0){

$this->session->set_flashdata('smessage','Data inserted successfully');

redirect("dcadmin/AppSlider/trending_products","refresh");

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

public function delete_trending_products($idd){

      if(!empty($this->session->userdata('admin_data'))){


        $data['user_name']=$this->load->get_var('user_name');

        // echo SITE_NAME;
        // echo $this->session->userdata('image');
        // echo $this->session->userdata('position');
        // exit;
				 $id=base64_decode($idd);

       if($this->load->get_var('position')=="Super Admin"){



$zapak=$this->db->delete('tbl_trending_products', array('id' => $id));
if($zapak!=0){

redirect("dcadmin/AppSlider/trending_products","refresh");
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
