<style>
.nav a, .nav label {
  display: flex;
  padding: .85rem;
  color: #28a745;
  border: 1px solid #ebebeb;
  background-color: #ffffff;
  -webkit-transition: all .25s ease-in;
  transition: all .25s ease-in-out;
  justify-content: space-between;
}

.nav a:focus, .nav a:hover, .nav label:focus, .nav label:hover {
  color: rgb(255 255 255);
  background: #28a745;
}

.nav label { cursor: pointer; }

/**
 * Styling first level lists items
 */

.group-list a, .group-list label {
  padding-left: 2rem;
  background: #f1f1f1;
  color: black;
  /* box-shadow: inset 0 -1px #373737; */
}

.group-list a:focus, .group-list a:hover, .group-list label:focus, .group-list label:hover { background: #28a745; }

/**
 * Styling second level list items
 */

.sub-group-list a, .sub-group-list label {
  /* padding-left: 4rem; */
  background: #f1f1f1;
  color: #1d1d1d;
}

.sub-group-list a:focus, .sub-group-list a:hover, .sub-group-list label:focus, .sub-group-list label:hover { background: #28a745; }

/**
 * Styling third level list items
 */

.sub-sub-group-list a, .sub-sub-group-list label {
  /* padding-left: 6rem; */
  background: #fff;
}

.sub-sub-group-list a:focus, .sub-sub-group-list a:hover, .sub-sub-group-list label:focus, .sub-sub-group-list label:hover { background: #28a745; }

/**
 * Hide nested lists
 */

.group-list, .sub-group-list, .sub-sub-group-list {
  height: 100%;
  max-height: 0;
  overflow: hidden;
  -webkit-transition: max-height .5s ease-in-out;
  transition: max-height .5s ease-in-out;
}

.nav__list input[type=checkbox]:checked + label + ul { /* reset the height when checkbox is checked */
max-height: 1000px; }

/**
 * Rotating chevron icon
 */

label > span {
  float: right;
  -webkit-transition: -webkit-transform .65s ease;
  transition: transform .65s ease;
}

.nav__list input[type=checkbox]:checked + label > span {
  -webkit-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}


.nav__list input[type=checkbox]:checked + label {
  background: #28a745;
  color: #fff;
}
</style>


<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
<div class="container">
<div class="row">
<div   class="col-md-12">
<a href="<?=base_url()?>Home"><strong><span class="mdi mdi-home"></span> Home</strong></a>
<span class="mdi mdi-chevron-right"></span> <a href="#"><?=$subcategory_name;?></a>
<span class="mdi mdi-chevron-right"></span> <a href="#">Subcategory Combo Products</a>
</div>
</div>
</div>
</section>
<section class="shop-list section-padding">
<div class="container">
<div class="row" style="overflow: hidden;">




<div class="col-md-12">
<!-- <a href="#"><img class="img-fluid mb-3" src="<?=base_url();?>assets/frontend/img/shop2.jpg" alt=""></a> -->
<!-- <div class="shop-head">
<a href="#"><span class="mdi mdi-home"></span> Home</a>
<span class="mdi mdi-chevron-right"></span>
<?
            $this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('id',$category_id);
$da65= $this->db->get()->row();?>
 <a href="#"><? if (!empty($da65->name)){echo $da65->name;};?></a>
<span class="mdi mdi-chevron-right"></span> <a href="#">Fruits</a>
<div class="btn-group float-right mt-2">
<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Sort by Products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</button>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="#">Relevance</a>
<a class="dropdown-item" href="#">Price (Low to High)</a>
<a class="dropdown-item" href="#">Price (High to Low)</a>
<a class="dropdown-item" href="#">Discount (High to Low)</a>
<a class="dropdown-item" href="#">Name (A to Z)</a>
</div>
</div>
<h5 class="mb-3"><? if (!empty($da65->name)){echo $da65->name;};?></h5>
</div> -->
<div class="row no-gutters">
<?php
if (!empty($da)) {
  // code...
$i=1; foreach($da->result() as $db) {
	$pro=$db->product_id;

											 $this->db->select('*');
					 $this->db->from('tbl_product');
					 $this->db->where('id',$pro);
					 $products= $this->db->get();
           // $products=$product;
}
}

 $i=1; foreach($products->result() as $pr1) {
  // print_r($pr);exit;

        			$this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$pr1->id);
  $da2= $this->db->get()->row();
  if (!empty($da2)) {
    // code...




  	$rp=$da2->mrp; $sp=$da2->selling_price;

  	$diff=$rp-$sp;
  	$off=$diff/$rp*100;
  	$offer=round($off);

    $this->db->select('*');
    $this->db->from('tbl_product');
    $this->db->where('id',$da2->product_id);
    $product= $this->db->get()->row();
}
  //
  ?>

<div class="col-md-3 col-6">
  	<form action="<?=base_url();?>Cart/add_to_cart" method="post" enctype="multipart/form-data">
<div class="product">
<a href="<?=base_url();?>Home/single/<?echo base64_encode($pr1->id);?>">
 <div class="product-header">
<span class="badge badge-success"><?if(!empty($offer)){ echo $offer;};?>% OFF</span>
<img class="img-fluid" src="<?=base_url();?><?=$pr1->image1?>" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5><?=$pr1->name;?></h5>


<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <? if (!empty($da2->unit_id)) {
  echo $da2->unit_id;
};?></h6>
</div>

</a>
<div class="product-footer d-flex justify-content-between">


<p class="offer-price mb-0">₹<span id="selling_price_<?=$da2->product_id?>"><? if (!empty($da2)) {
  echo $da2->selling_price;
};?></span> <i class="mdi mdi-tag-outline"></i><br>₹<span class="regular-price" id="mrp_<?=$da2->product_id?>"><?=$da2->mrp;?></span></p>


<div class="d-flex quant border-0" >


  <select class="form-control" id="unit_<?=$da2->product_id;?>" onchange="unitChange(this);" style="width: 100%!important;border:1px solid #28a745; background: #28a74500; color: #000; outline: none !important;">
	<!-- <option value="">select</option> -->
	<?php
	$this->db->select('*');
	$this->db->from('tbl_product_units');
	$this->db->where('product_id',$product->id);
	$da3_type= $this->db->get();
	if(!empty($da3_type)){
	foreach ($da3_type->result() as $tyyp) {

	 ?>

		<option value="<?=$tyyp->id;?>"><?=$tyyp->unit_id;?></option>

	<?php
	} } ?>
	</select>

</div>


</div>
<input type="hidden" name="product_id" id="product_id" value="<?=$pr1->id;?>">
<input type="hidden" name="unit_id" id="unit_id" value="<?=$da2->id;?>">
<!-- <input type="hidden" name="quantity" id="quantity" value="1"> -->

<div class="ct-content" style="  display: flex !important;
	justify-content: space-between !important;
	align-items: center !important;">

  <select class="form-control mt-4" style="width:49%;" name="quantity" id="quantity" required>
		<option value="">Qty</option>
		<option value="1">1</option>
		<option value="2">2</option>
	</select>

	<button type="submit" class="btn btn-secondary mt-4" style="width: 49%!important; height: 35px!important;"><i class="mdi mdi-cart-outline"></i></button>


</div>



</div>
</form>
</div>

<?php $i++; } ?>
<!--
<div class="col-md-4">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/2.jpg" alt="">
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
<div class="col-md-4">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/3.jpg" alt="">
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
</div>
<div class="row no-gutters">
<div class="col-md-4">
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
<div class="col-md-4">
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
<div class="col-md-4">
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
</div>
<div class="row no-gutters">
<div class="col-md-4">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/7.jpg" alt="">
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
<div class="col-md-4">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/8.jpg" alt="">
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
<div class="col-md-4">
<div class="product">
<a href="<?=base_url();?>Home/single">
<div class="product-header">
<span class="badge badge-success">50% OFF</span>
<img class="img-fluid" src="<?=base_url();?>assets/frontend/img/item/9.jpg" alt="">
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


<!-- Pagination start -->

<!-- <nav>
<ul class="pagination justify-content-center mt-4">
<li class="page-item disabled">
<span class="page-link">Previous</span>
</li>
<li class="page-item"><a class="page-link" href="#">1</a></li>
<li class="page-item active">
<span class="page-link">
2
<span class="sr-only">(current)</span>
</span>
</li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item">
<a class="page-link" href="#">Next</a>
</li>
</ul>
 </nav> -->

<!-- Pagination end -->




</div>
</div>
</div>
</section>




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





<!-- select type -->


	<script>

	function unitChange(obj){
		// alert("u");
var c_id= obj.value;

var prod_id= $("#product_id").val();
// alert(prod_id);
		// var c_id = $("#unit_"+prod_id).val();
		if(c_id == undefined){
			// alert('ll');
			c_id= "";
		}
		// var prod_id = $(this).attr('pro_id');
		// alert(prod_id);
		// alert(c_id);
		// alert(s_id);
		//  die();

		// $('.colobtn .p-1 .active').removeClass('active');
		//  $(this).addClass('active');

	 var base_path = "<?=base_url();?>";
	// alert(c_id);
	// alert(size_id);
	// alert(prod_id);
		$.ajax({
		url:'<?=base_url();?>Home/get_unit_type_data',
		method: 'get',
		data: {unit_id: c_id, product_id: prod_id},
		dataType: 'json',
		success: function(response){
		console.log(response);
		if(response.data == true){


		var pro_typ_d= response.producttypedata;
		// var pro_sizes= response.sizelist;
		// console.log(pro_sizes);

	var diff= parseFloat(pro_typ_d.mrp) - parseFloat(pro_typ_d.selling_price);
	var discount= diff * 100/ parseFloat(pro_typ_d.mrp);
	var price_discount= Math.round(discount);
	// alert(price_discount);
	var discount_string= '( '+price_discount+'% Off )';

	if(pro_typ_d != "" &&  pro_typ_d != null){
		$('#mrp_'+prod_id).text('');
		$('#selling_price_'+prod_id).text('');
		$('#price_discount_'+prod_id).text('');
		$('#unit_id').val('');

		$('#mrp_'+prod_id).text(pro_typ_d.mrp);
		$('#selling_price_'+prod_id).text(pro_typ_d.selling_price);
		$('#price_discount_'+prod_id).text(discount_string);
		$('#unit_id').val(c_id);







      if(pro_typ_d.image1 != "" && pro_typ_d.image1 != null){
// alert(base_path+'assets/admin/product_units/'+pro_typ_d.image1); die();
var img1 = base_path+"assets/admin/product_units/"+pro_typ_d.image1;

				// $("#main_img1").css({'src',base_path+'assets/admin/product_units/'+pro_typ_d.image1});
				// $("#my_img1").css({'src',base_path+'assets/admin/product_units/'+pro_typ_d.image1)});




				$(".main_img1").css('background-image', 'url("' + img1 + '")');
				$(".my_img1").css('background-image', 'url("' + img1 + '")');


      // $('#main_img1').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image1);
      // $('#my_img1').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image1);

      }

      if(pro_typ_d.image2 != "" && pro_typ_d.image2 != null){

var img2 = base_path+"assets/admin/product_units/"+pro_typ_d.image2;
      // $('#main_img2').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image2);
      // $('#my_img2').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image2);

			$(".main_img2").css('background-image', 'url("' + img2 + '")');
			$(".my_img2").css('background-image', 'url("' + img2 + '")');

      }

      if(pro_typ_d.image3 != "" && pro_typ_d.image3 != null){

				var img3 = base_path+"assets/admin/product_units/"+pro_typ_d.image3;
    // alert('yay');
      // $('#main_img3').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image3);
      // $('#my_img3').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image3);

			$(".main_img3").css('background-image', 'url("' + img3 + '")');
			$(".my_img3").css('background-image', 'url("' + img3 + '")');

      }

      if(pro_typ_d.image4 != "" && pro_typ_d.image4 != null){

		var img4 = base_path+"assets/admin/product_units/"+pro_typ_d.image4;
      // $('#main_img4').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image4);
      // $('#my_img4').attr('src',base_path+'assets/admin/product_units/'+pro_typ_d.image4);

			$(".main_img4").css('background-image', 'url("' + img4 + '")');
			$(".my_img4").css('background-image', 'url("' + img4 + '")');

      }





	// $("#sizes").html('');
	// var size_da;
	// $.each(pro_sizes, function(i, item) {
	// var size_da= '<input type="radio" name="size" class="form-check-input" id="size_'+prod_id+'"  name="materialExampleRadios" value="'+item.id+'" ';
	// if(i==0){
	// size_da= size_da+'checked';
	// }
	// size_da= size_da+'>';
	// size_da=  size_da+'<label class="form-check-label small text-uppercase card-link-secondary"for="small">'+item.name+'</label>';
	//
	//
	// $("#sizes").append(size_da);
	// });

		// $('#main_img2').attr('src','second.jpg');
		// $('#main_img3').attr('src','second.jpg');
		// $('#main_img4').attr('src','second.jpg');
		//
		//
		// $('#my_img2').attr('src','second.jpg');
		// $('#my_img3').attr('src','second.jpg');
		// $('#my_img4').attr('src','second.jpg');


	}

		}
		else{
		alert('hiii');
		}
		}
		});


	}

	</script>
