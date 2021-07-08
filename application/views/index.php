
<section class="top-category section-padding">
<div class="container">
<div class="owl-carousel owl-carousel-category new_nake d-flex	" id="new_nake">
	<?php $i=1; foreach($category->result() as $data) { ?>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop/<? echo base64_encode($data->id);?>">
<img class="img-fluid" src="<?=base_url();?><?=$data->image?>" alt="">
<h6><?=$data->name?></h6>
<?      			$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('category_id',$data->id);
$pro= $this->db->count_all_results();?>

<p><?echo $pro;?> Items</p>
</a>
</div>
</div>
<?php $i++; } ?>
<!--
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/2.jpg" alt="">
<h6>Grocery & Staples</h6>
<p>95 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/3.jpg" alt="">
<h6>Beverages</h6>
<p>65 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/4.jpg" alt="">
<h6>Home & Kitchen</h6>
<p>965 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/5.jpg" alt="">
<h6>Furnishing & Home Needs</h6>
<p>125 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/6.jpg" alt="">
<h6>Household Needs</h6>
<p>325 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/7.jpg" alt="">
<h6>Personal Care</h6>
<p>156 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/8.jpg" alt="">
<h6>Breakfast & Dairy</h6>
<p>857 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/9.jpg" alt="">
<h6>Biscuits, Snacks & Chocolates</h6>
<p>48 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/10.jpg" alt="">
<h6>Noodles, Sauces & Instant Food</h6>
<p>156 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/11.jpg" alt="">
<h6>Pet Care</h6>
<p>568 Items</p>
</a>
</div>
</div>
<div class="item">
<div class="category-item">
<a href="<?=base_url();?>Home/shop">
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/small/12.jpg" alt="">
<h6>Meats, Frozen & Seafood</h6>
<p>156 Items</p>
</a>
</div>
</div> -->
</div>
</div>
</section>

<section class="carousel-slider-main text-center border-top border-bottom bg-white">
<div class="owl-carousel owl-carousel-slider">
<?php $i=1; foreach($sliders->result() as $data1) {
	// print_r(base_url().$data1->image);exit;
	 ?>
<div class="item">
<a href="<?=base_url();?><?=$data1->link?>">
	<img class="img-fluid" src="<?=base_url();?><?=$data1->image?>" alt="First slide"></a>
</div>
<?php $i++; } ?>
<!-- <div class="item">
<a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
</div>
<div class="item">
<a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider1.jpg" alt="First slide"></a>
</div>
<div class="item">
<a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
</div> -->
</div>
</section>

<section class="	">
<div class="container">
<div class="section-header">
<h5 class="heading-design-h5">Top Savers Today
	 <!-- <span class="badge badge-primary">20% OFF</span> -->
<a class="float-right text-secondary" href="<?=base_url();?>Home/shop/?view=1">View All</a>
</h5>
</div>
<div class="owl-carousel owl-carousel-featured">

<?php
$i=1; foreach($da->result() as $db) {
	$pro=$db->product_id;

											 $this->db->select('*');
					 $this->db->from('tbl_product');
					 $this->db->where('id',$pro);
					 $product= $this->db->get();

$i=1; foreach($product->result() as $data) {


						       			$this->db->select('*');
						 $this->db->from('tbl_product_units');
						 $this->db->where('product_id',$data->id);
						 $da2= $this->db->get()->row();

						       			$this->db->select('*');
						 $this->db->from('tbl_units');
						 $this->db->where('id',$da2->unit_id);
						 $da3= $this->db->get()->row();
if(!empty($da3)){
	$name=$da3->name;
}else{
	$name="";
}


	$rp=$da2->mrp; $sp=$da2->selling_price;

	$diff=$rp-$sp;
	$off=$diff/$rp*100;
	$offer=round($off);
	?>
		 <div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single/<?echo base64_encode($data->id);?>">
<div class="product-header">
<span class="badge badge-success"><?=$offer?>% OFF</span>
<img class="img-fluid" src="<?=base_url();?><?=$data->image1?>" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5><?=$data->name?></h5>

<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?=$name?></h6>
</div>
</a>
<div class="product-footer d-flex justify-content-between">


<p class="offer-price mb-0">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$<?=$da2->mrp;?></span></p>


<div class="d-flex quant">
	<span>-</span>
	<input type="number"/>
	<span>+</span>
</div>
</div>
<a href="<?=base_url();?>Home/single/<?echo base64_encode($data->id);?>">
<button type="button" class="btn btn-secondary mt-3 w-100"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
</a>



</div>
</div>
<?}}?>

<!-- <div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/2.jpg" alt="">
<span class="non-veg text-danger mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/3.jpg" alt="">
<span class="non-veg text-danger mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/4.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/5.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/6.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>-->
</div>
</div>
</section>









<!-- all categories start -->

<section class="product-items-slider section-padding">
	<div class="container">
		<div class="section-header">
		<h5 class="heading-design-h5">SHOP BY CATEGORY
			<!-- <span class="badge badge-primary">20% OFF</span> -->
		<a class="float-right text-secondary" href="<?=base_url();?>Home/shop">View All</a>
		</h5>
		</div>
		<div class="row all_cat_row">
			<?php $i=1; foreach($combo->result() as $data) {
				$sub=$data->product_id;
				      			$this->db->select('*');
				$this->db->from('tbl_subcategory');
				$this->db->where('id',$sub);
				$da= $this->db->get()->row();
				// print_r($da);

				?>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?><?=$da->image?>');">
					<div class="pr_tag">
						<h4 class="mb-0"><?
						if (!empty($da)) {
						echo $da->name;}?></h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>

				</div>
			</div>
		<?php $i++; } ?>
			<!-- <div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/special-seasonable.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/other-products.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/indian-fruits.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/skmandi-combo.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>

				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/special-seasonable.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/other-products.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/indian-fruits.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div> -->
		<!-- </div> -->
	</div>
</section>



<!-- all categories end -->









<section class="	">
<div class="container">
<div class="section-header">
<h5 class="heading-design-h5">Top Savers Today <span class="badge badge-primary">20% OFF</span>
<a class="float-right text-secondary" href="<?=base_url();?>Home/shop">View All</a>
</h5>
</div>
<div class="owl-carousel owl-carousel-featured">

	<?php
	$i=1; foreach($re->result() as $db) {
		$pro=$db->product_id;

												 $this->db->select('*');
						 $this->db->from('tbl_product');
						 $this->db->where('id',$pro);
						 $product= $this->db->get();

	$i=1; foreach($product->result() as $data) {

		      			$this->db->select('*');
		$this->db->from('tbl_product_units');
		$this->db->where('product_id',$data->id);
		$da2= $this->db->get()->row();

		      			$this->db->select('*');
		$this->db->from('tbl_units');
		$this->db->where('id',$da2->unit_id);
		$da3= $this->db->get()->row();
		//
		$rp=$da2->mrp; $sp=$da2->selling_price;

		$diff=$rp-$sp;
		$off=$diff/$rp*100;
		$offer=round($off);
		?>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single/<?echo base64_encode($data->id);?>">
<div class="product-header">
<span class="badge badge-success"><?=$offer?>% OFF</span>
<img class="img-fluid" src="<?=base_url();?><?=$data->image1?>" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5><?=$data->name?></h5>


<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <?=$name;?></h6>
</div>
<div class="product-footer d-flex justify-content-between">

<p class="offer-price mb-0">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$<?=$da2->mrp;?></span></p>
</a>
<div class="d-flex quant">
	<span>-</span>
	<input type="number"/>
	<span>+</span>
</div>

</div>
<a href="<?=base_url();?>Home/single/<?echo base64_encode($data->id);?>">
<button type="button" class="btn btn-secondary mt-3 w-100"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
</a>
</div>
</div>
<?}}?>
<!-- <div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/2.jpg" alt="">
<span class="non-veg text-danger mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/3.jpg" alt="">
<span class="non-veg text-danger mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/4.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/5.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/6.jpg" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5>Product Title Here</h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$800.99</span></p>
</div>
</a>
</div>
</div>
</div> -->
</div>
</section>



<section class="offer-product">
<div class="container">
<div class="row no-gutters">
<div class="col-md-6">
<a href="#"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/ad/1.jpg" alt=""></a>
</div>
<div class="col-md-6">
<a href="#"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/ad/2.jpg" alt=""></a>
</div>
</div>
</div>
</section>



<!-- all categories start -->

<section class="product-items-slider section-padding">
	<div class="container">
		<div class="section-header">
		<h5 class="heading-design-h5">SHOP BY CATEGORY <span class="badge badge-primary">20% OFF</span>
		<a class="float-right text-secondary" href="<?=base_url();?>Home/shop">View All</a>
		</h5>
		</div>
		<div class="row all_cat_row">
			<?php $i=1; foreach($combo2->result() as $data) {
				$sub=$data->product_id;
										$this->db->select('*');
				$this->db->from('tbl_subcategory');
				$this->db->where('id',$sub);
				$da= $this->db->get()->row();
				// print_r($da);

				?>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?><?=$da->image;?>');">
					<div class="pr_tag">
						<h4 class="mb-0"><?=$da->name;?></h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>

				</div>
			</div>
			<?php $i++; } ?>
			<!-- <div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/special-seasonable.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/other-products.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/indian-fruits.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/skmandi-combo.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>

				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/special-seasonable.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/other-products.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
			<div class="col-md-3" >
				<div class="all_cat" style="background: url('<?=base_url();?>assets/frontend/img/indian-fruits.jpg');">
					<div class="pr_tag">
						<h4 class="mb-0">Mandi Combo</h4>
						<p class="mb-0">5 PRODUCTS</p>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</section>



<!-- all categories end -->


<div class="container-fluid mb-5 he_250">
  <div class="row">
    <div class="col-md-6">
      <section class="carousel-slider-main text-center border-top border-bottom bg-white">
    <div class="owl-carousel owl-carousel-slider">
			<?php $i=1; foreach($sliders2->result() as $data1) {?>

    <div class="item">
    <a href="<?=$data1->link?>"><img class="img-fluid he_250" src="<?=base_url();?><?=$data1->image?>" alt="First slide"></a>
    </div>
		<?}?>
    <!-- <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
    </div>
    <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider1.jpg" alt="First slide"></a>
    </div>
    <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
    </div> -->
    </div>
    </section>
  </div>
    <div class="col-md-6">
      <section class="carousel-slider-main text-center border-top border-bottom bg-white">
    <div class="owl-carousel owl-carousel-slider">
			<?php $i=1; foreach($home->result() as $data) { ?>
		<div class="item">
    <a href="<?=$data->link;?>"><img class="img-fluid" src="<?=base_url();?><?=$data->image?>" alt="First slide"></a>
    </div>
		<?php $i++; } ?>
    <!-- <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
    </div>
    <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider1.jpg" alt="First slide"></a>
    </div>
    <div class="item">
    <a href="<?=base_url();?>Home/shop"><img class="img-fluid" src="<?=base_url();?>assets/frontend/img/slider/slider2.jpg" alt="First slide"></a>
    </div> -->
    </div>
    </section>
  </div>
  </div>
</div>
