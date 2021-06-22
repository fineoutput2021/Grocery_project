<style>
	   .swiper-container {
          width: 100%;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
    background: #fff none repeat scroll 0 0;
    border: 1px solid #eeeeee;
    border-radius: 12px;
    padding: 32px;
    }

    .swiper-slide {
      background-size: cover;
      background-position: center;
    }

    .gallery-top {
      height: 80%;
      width: 100%;
    }

    .gallery-thumbs {
      height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
      height: 100%;
      opacity: 0.4;
    }

    .gallery-thumbs .swiper-slide-thumb-active {
      opacity: 1;
    }

</style>
<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
<div class="container">
<div class="row">
<div class="col-md-12">
<a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Fruits & Vegetables</a> <span class="mdi mdi-chevron-right"></span> <a href="#">Fruits</a>
</div>
</div>
</div>
</section>
<section class="shop-single section-padding pt-3">
<div class="container">
<div class="row">

<div class="col-md-6">

 <!-- Swiper -->
  <div class="swiper-container gallery-top">
    <div class="swiper-wrapper">
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image1;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image2;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image3;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image4;?>)"></div>
      <!-- <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div> -->
    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
  </div>
  <div class="swiper-container gallery-thumbs">
    <div class="swiper-wrapper">
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image1;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image2;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image3;?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?><?=$product->image4;?>)"></div>
      <!-- <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div>
      <div class="swiper-slide" style="background-image:url(<?=base_url();?>)"></div> -->
    </div>
  </div>

</div>
<?
$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$product->id);
$da2= $this->db->get()->row();
if (!empty($da2)) {
// code...

$this->db->select('*');
$this->db->from('tbl_units');
$this->db->where('id',$da2->unit_id);
$da3= $this->db->get()->row();


$rp=$da2->mrp; $sp=$da2->selling_price;

$diff=$rp-$sp;
$off=$diff/$rp*100;
$offer=round($off);
}
//
?>

<div class="col-md-6">
<div class="shop-detail-right">
<span class="badge badge-success"><?=$offer?>% OFF</span>
<h2><?=$product->name;?></h2>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> -  <? if (!empty($da3->name)) {
  echo $da3->name;
};?></h6>
<p class="regular-price"><i class="mdi mdi-tag-outline"></i> MRP : $<? if (!empty($da2)) {
  echo $da2->mrp;
};?></p>
<p class="offer-price mb-0">Discounted price : <span class="text-success">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?></span></p>
<a href="<?=base_url();?>Home/checkout"><button type="button" class="btn btn-secondary btn-lg"><i class="mdi mdi-cart-outline"></i> Add To Cart</button> </a>
<div class="short-description">
<h5>
Quick Overview
<p class="float-right">Availability: <span class="badge badge-success">In Stock</span></p>
</h5>
<p><b><?=$product->short_description?></b>
	 <!-- Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. -->
</p>
<p class="mb-0"> <?=$product->long_description?>
	<!-- Vivamus adipiscing nisl ut dolor dignissim semper.
	Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra,
	 per inceptos hiMenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse -->
	 <!-- aliquet urna pretium eros convallis interdum. -->
 </p>
</div>
<h6 class="mb-3 mt-4">Why shop from Groci?</h6>
<div class="row">
<div class="col-md-6">
<div class="feature-box">
<i class="mdi mdi-truck-fast"></i>
<h6 class="text-info">Free Delivery</h6>
<p>Lorem ipsum dolor...</p>
</div>
</div>
<div class="col-md-6">
<div class="feature-box">
<i class="mdi mdi-basket"></i>
<h6 class="text-info">100% Guarantee</h6>
<p>Rorem Ipsum Dolor sit...</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="product-items-slider section-padding bg-white border-top">
<div class="container">
<div class="section-header">
<h5 class="heading-design-h5">Best Offers View <span class="badge badge-primary">20% OFF</span>
<a class="float-right text-secondary" href="<?=base_url();?>Home/shop">View All</a>
</h5>
</div>
<div class="owl-carousel owl-carousel-featured">

	<?php $i=1; foreach($relate->result() as $pr1) {
	  // print_r($pr);exit;

	        			$this->db->select('*');
	  $this->db->from('tbl_product_units');
	  $this->db->where('product_id',$pr1->id);
	  $da2= $this->db->get()->row();
	  if (!empty($da2)) {
	    // code...

	        			$this->db->select('*');
	  $this->db->from('tbl_units');
	  $this->db->where('id',$da2->unit_id);
	  $da3= $this->db->get()->row();


	  	$rp=$da2->mrp; $sp=$da2->selling_price;

	  	$diff=$rp-$sp;
	  	$off=$diff/$rp*100;
	  	$offer=round($off);
	}
	  //


	?>
<div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single/<?echo base64_encode($pr1->id);?>">
<div class="product-header">
<span class="badge badge-success"><?=$offer?>% OFF</span>
<img class="img-fluid" src="<?=base_url();?><?=$pr1->image1;?>" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5><?=$pr1->name;?></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> -  <? if (!empty($da3->name)) {
  echo $da3->name;
};?></h6>
</div>
<div class="product-footer">
<button type="button" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$<? if (!empty($da2)) {
  echo $da2->mrp;
};?></span></p>
</div>
</a>
</div>
</div>
<?php $i++; } ?>
<!-- <div class="item">
<div class="product">
<a href="<?=base_url();?>Home/shop">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/8.jpg" alt="">
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
<a href="<?=base_url();?>Home/shop">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/9.jpg" alt="">
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
<a href="<?=base_url();?>Home/shop">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/10.jpg" alt="">
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
<a href="<?=base_url();?>Home/shop">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/11.jpg" alt="">
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
<a href="<?=base_url();?>Home/shop">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/12.jpg" alt="">
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
</div> -->
</div>
</div>
</section>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
	var galleryThumbs = new Swiper('.gallery-thumbs', {
		spaceBetween: 10,
		slidesPerView: 4,
		loop: true,
		freeMode: true,
		loopedSlides: 5, //looped slides should be the same
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
	});
	var galleryTop = new Swiper('.gallery-top', {
		spaceBetween: 10,
		loop: true,
		loopedSlides: 5, //looped slides should be the same
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		thumbs: {
			swiper: galleryThumbs,
		},
	});
</script>
