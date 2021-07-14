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
<div class="col-md-12">
<a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Shop</a>
</div>
</div>
</div>
</section>
<section class="shop-list section-padding">
<div class="container">
<div class="row" style="overflow: hidden;">
<div class="col-md-12 d-lg-none d-md-none d-flex mb-4" style="overflow:auto; align-items: center;">
  <?php $i=1;

if($page_from == 0) {
if(!empty($subcategory_da)){
  foreach($subcategory_da->result() as $d1) {
    ?>
  <a href="<?=base_url();?>Home/shop/<?=base64_encode($category_id);?>?sub=<?=$d1->id?>" class="sub_cat_a">
    <p><?= $d1->name; ?> </p>
  </a>
  <?php

   $i++; } } }

   ?>


   <?php $i=1;

 if($page_from == 1) {
 if(!empty($subcategory2_da)){
   foreach($subcategory2_da->result() as $d1) {
     ?>
   <a href="<?=base_url();?>Home/shop/<?=base64_encode($category_id);?>?mini=<?=$d1->id?>" class="sub_cat_a">
     <p><?= $d1->name; ?> </p>
   </a>
   <?php

    $i++; } }else {

      if(!empty($subcategory_da)){
        foreach($subcategory_da->result() as $d1) {
          ?>
        <a href="<?=base_url();?>Home/shop/<?=base64_encode($category_id);?>?sub=<?=$d1->id?>" class="sub_cat_a">
          <p><?= $d1->name; ?> </p>
        </a>
        <?php

         $i++; } }


    } }

    ?>

    <?php $i=1;

  if($page_from == 2) {
    // print_r($subcategory2_da); die();
  if(!empty($subcategory2_da)){
    foreach($subcategory2_da->result() as $d1) {
      ?>
    <a href="<?=base_url();?>Home/shop/<?=base64_encode($category_id);?>?mini=<?=$d1->id?>" class="sub_cat_a">
      <p><?= $d1->name; ?> </p>
    </a>
    <?php

     $i++; } }

    }

     ?>

  <!-- <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a>
  <a href="#" class="sub_cat_a">
    <p>Deodrants </p>
  </a> -->
</div>


<div class="col-md-3 d-none d-lg-block d-md-block">

  <nav class="nav w-100" role="navigation">
     <ul class="nav__list w-100">


 <?php $i=1;
 if(!empty($category)){
  foreach($category->result() as $data) {

                 $this->db->select('*');
     $this->db->from('tbl_subcategory');
     $this->db->where('category_id',$data->id);
     $da1= $this->db->get();

   ?>

       <li>
         <input id="group-<?=$i;?>" type="checkbox" hidden />
         <label for="group-<?=$i;?>">

           <?=$data->name;?>

         <i class="mdi mdi-chevron-down"></i></label>
         <ul class="group-list">

 <?php $k=1;
 if(!empty($da1)){
 foreach($da1->result() as $da2) {
                 $this->db->select('*');
     $this->db->from('tbl_sub_category2');
     $this->db->where('subcategory_id',$da2->id);
     $da3= $this->db->get();
     // print_r($da3->result());
   ?>


<!-- <?=$i;?> -->
<?php  if(empty($da3)){ ?>

<li><a href="<?=base_url();?>Home/shop/<?=base64_encode($data->id);?>?sub=<?=$da2->id?>"><?=$da2->name;?></a></li>

<?php  }else{ ?>
           <li>
             <input id="sub-group-<?=$i;?>" type="checkbox" hidden />
             <!-- -->
           <label for="sub-group-<?=$i;?>">

               <?=$da2->name;?><i class="mdi mdi-chevron-down"></i>

           </label>



             <ul class="sub-group-list">

      <?php  foreach ($da3->result() as $da4){ ?>
               <li><a href="<?=base_url();?>Home/shop/<?=base64_encode($data->id);?>?mini=<?=$da4->id?>"><?=$da4->name;?></a></li>
      <?php  } ?>

               <!-- <li><a href="#">2nd level nav item</a></li>
               <li><a href="#">2nd level nav item</a></li> -->

             </ul>


           </li>
   <?php  } ?>
<?php $k++; } } ?>

         </ul>
       </li>



<?php $i++; } } ?>



     </ul>
   </nav>
</div>
<div class="col-md-9">
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

<div class="col-md-4 col-6">
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
<p class="offer-price mb-0">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$<? if (!empty($da2)) {
  echo $da2->mrp;
};?></span></p>


<div class="d-flex quant">
	<span>-</span>
	<input type="number" value="1"/>
	<span>+</span>
</div>


</div>
<input type="hidden" name="product_id" id="product_id" value="<?=$pr1->id;?>">
<input type="hidden" name="unit_id" id="unit_id" value="<?=$da2->id;?>">
<input type="hidden" name="quantity" id="quantity" value="1">

<button type="submit" class="btn btn-secondary mt-3 w-100 "><i class="mdi mdi-cart-outline"></i> Add To Cart</button>



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
<section class="product-items-slider section-padding bg-white border-top">
<div class="container">
<div class="section-header">
<h5 class="heading-design-h5">Related Products
  <!-- <span class="badge badge-primary">20% OFF</span> -->
<!-- <a class="float-right text-secondary" href="shop.html">View All</a> -->
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




  	$rp=$da2->mrp; $sp=$da2->selling_price;

  	$diff=$rp-$sp;
  	$off=$diff/$rp*100;
  	$offer=round($off);
}
  //


?>
<div class="item">
  	<form action="<?=base_url();?>Cart/add_to_cart" method="post" enctype="multipart/form-data">
<div class="product">
<a href="<?=base_url();?>Home/single/<?echo base64_encode($pr1->id);?>">
<div class="product-header">
<span class="badge badge-success"><?=$offer?>% OFF</span>
<img class="img-fluid" src="<?=base_url();?><?=$pr1->image1;?>" alt="">
<span class="veg text-success mdi mdi-circle"></span>
</div>
<div class="product-body">
<h5><?=$pr1->name;?></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - <? if (!empty($da2)) {
  echo $da2->unit_id;
};?></h6>
</div>
<div class="product-footer">

  <input type="hidden" name="product_id" id="product_id" value="<?=$pr1->id;?>">
  <input type="hidden" name="unit_id" id="unit_id" value="<?=$da2->id;?>">
  <input type="hidden" name="quantity" id="quantity" value="1">

<button type="submit" class="btn btn-secondary btn-sm float-right"><i class="mdi mdi-cart-outline"></i> Add To Cart</button>
<p class="offer-price mb-0">$<? if (!empty($da2)) {
  echo $da2->selling_price;
};?> <i class="mdi mdi-tag-outline"></i><br><span class="regular-price">$<? if (!empty($da2)) {
  echo $da2->mrp;
};?></span></p>
</div>
</a>
</div>
</form>
</div>
<?php $i++; } ?>
<!-- <div class="item">
<div class="product">
<a href="<?=base_url();?>Home/single">
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
<a href="<?=base_url();?>Home/single">
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
 <a href="<?=base_url();?>Home/single">
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
<a href="<?=base_url();?>Home/single">
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
<a href="<?=base_url();?>Home/single">
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
