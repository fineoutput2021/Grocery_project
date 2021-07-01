<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}
public function index()
	{

      			$this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$data['category']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_sliders2');
$this->db->where('is_active',1);
$data['sliders2']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_sliders');
$this->db->where('is_active',1);
$data['sliders']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_home_slider');
$this->db->where('is_active',1);
$data['home']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_combo');
// $this->db->where('is_active',1);
$data['combo']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_combo2');
// $this->db->where('is_active',1);
$data['combo2']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_trending_products');
// $this->db->where('is_active',1);
$data['da']= $this->db->get();


						$this->db->select('*');
						$this->db->from('tbl_recent_products');
						// $this->db->where('is_active',1);
						$data['re']= $this->db->get();




			$this->load->view('common/header',$data);
			$this->load->view('index');
			$this->load->view('common/footer');

	}

public function shop($td="")
	{

$views=$this->input->get('view');
$mini=$this->input->get('mini');
$sub=$this->input->get('sub');

			$ts=base64_decode($td);
// echo ($ts);exit;
$data['category_id']=$ts;

      			$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('category_id',$ts);
$data['products']= $this->db->get();

if (!empty($mini)) {

						$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('subcategory_id',$mini);
$data['products']= $this->db->get();

						$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('subcategory_id',$mini);
$dt= $this->db->get()->row();
if (!empty($dt)) {
	$ts=$dt->category_id;
}
}
//
// if (!empty($sub)) {
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $data['products']= $this->db->get();
//
// 						$this->db->select('*');
// $this->db->from('tbl_product');
// $this->db->where('subcategory_id',$sub);
// $dt= $this->db->get()->row();
// $ts=$dt->category_id;
// }

if (!empty($views)) {
	// code...
	$this->db->select('*');
$this->db->from('tbl_trending_products');
// $this->db->where('is_active',1);
$data['da']= $this->db->get();

}

$this->db->order_by('rand()');
$this->db->from('tbl_product');
$this->db->where('category_id',$ts);
$this->db->limit(9);
$data['relate']= $this->db->get();

      			$this->db->select('*');
$this->db->from('tbl_category');
//$this->db->where('',);
$data['category']= $this->db->get();

			$this->load->view('common/header',$data);
			$this->load->view('shop');
			$this->load->view('common/footer');

	}
public function single($pro)
	{

			$product_id=base64_decode($pro);
			// echo $product_id;

			$this->db->select('*');
			$this->db->from('tbl_product');
			$this->db->where('id',$product_id);
			$data['product']= $this->db->get()->row();

			$this->db->select('*');
	$this->db->from('tbl_product');
	$this->db->where('id',$product_id);
	$pr= $this->db->get()->row();

			$this->db->order_by('rand()');
			$this->db->from('tbl_product');
			$this->db->where('subcategory_id',$pr->subcategory_id);
			$this->db->limit(9);
			$data['relate']= $this->db->get();

			$this->load->view('common/header',$data);
			$this->load->view('single');
			$this->load->view('common/footer');

	}
public function about()
	{
			$this->load->view('common/header');
			$this->load->view('about');
			$this->load->view('common/footer');

	}
public function blog_detail()
	{
			$this->load->view('common/header');
			$this->load->view('blog_detail');
			$this->load->view('common/footer');

	}
public function blog()
	{
			$this->load->view('common/header');
			$this->load->view('blog');
			$this->load->view('common/footer');

	}
public function cart()
	{
			$this->load->view('common/header');
			$this->load->view('cart');
			$this->load->view('common/footer');

	}
public function checkout()
	{
			$this->load->view('common/header');
			$this->load->view('checkout');
			$this->load->view('common/footer');

	}
public function contact()
	{
			$this->load->view('common/header');
			$this->load->view('contact');
			$this->load->view('common/footer');

	}
public function faq()
	{
			$this->load->view('common/header');
			$this->load->view('faq');
			$this->load->view('common/footer');

	}
public function my_address()
	{
			$this->load->view('common/header');
			$this->load->view('my_address');
			$this->load->view('common/footer');

	}
public function my_profile()
	{
			$this->load->view('common/header');
			$this->load->view('my_profile');
			$this->load->view('common/footer');

	}
public function not_found()
	{
			$this->load->view('common/header');
			$this->load->view('not_found');
			$this->load->view('common/footer');

	}
public function orderlist()
	{
			$this->load->view('common/header');
			$this->load->view('orderlist');
			$this->load->view('common/footer');

	}
public function wishlist()
	{
			$this->load->view('common/header');
			$this->load->view('wishlist');
			$this->load->view('common/footer');

	}


	public function error404()
		{
				$this->load->view('errors/error404');

		}



	// public function blog()
	// {
	//
	//
	// 											$this->db->select('*');
	// 											$this->db->from('tbl_blog');
	// 											$this->db->where('is_active',1);
	// 											$this->db->order_by('blog_id', 'DESC');
	// 											$data['blog_data']= $this->db->get();
	//
	//
	//
	//
	// 		$this->load->view('blog/header',$data);
	// 		$this->load->view('blog/blog');
	// 		$this->load->view('blog/footer');
	//     // }
	// }


		// public function single()
		// {
		//
		// 		$this->load->view('blog/single-header');
		// 		$this->load->view('blog/blogsingle');
		// 		$this->load->view('blog/footer');
		//
		// }



		// get type dataType



		public function get_unit_type_data(){




			$product_id= $this->input->get('product_id');
			$unit_id= $this->input->get('unit_id');
			// $product_id= 1;


				$this->db->select('*');
			  $this->db->from('tbl_product_units');
			  $this->db->where('product_id',$product_id);
			  $this->db->where('id',$unit_id);
			  $this->db->where('is_active',1);
			  $producttypedata=$this->db->get()->row();






			// unlink( $img );
			$data['data'] = true;
			$data['producttypedata'] = $producttypedata;




			echo json_encode($data); 


	    }


}
