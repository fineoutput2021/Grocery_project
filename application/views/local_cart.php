<?php
// $c_data = $this->session->userdata('cart_items');
// print_r($c_data); die();
 ?>
<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
<div class="container">
<div class="row">
<div class="col-md-12">
<a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span class="mdi mdi-chevron-right"></span> <a href="#">Cart</a>
</div>
</div>
</div>
</section>
<section class="cart-page section-padding">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="card card-body cart-table">
<div class="table-responsive">
<table class="table cart_summary">
<thead>
<tr>
<th class="cart_product">Product</th>
<!-- <th>Avail.</th> -->
<th class="units">Unit price</th>
<th class="ytq">Qty</th>
<th class="tol">Total</th>
<th class="action"><i class="mdi mdi-delete-forever"></i></th>
<th></th>
</tr>
</thead>
<tbody>
  <?php
$t_price = 0;
  if(!empty($local_cart_data)){
    foreach ($local_cart_data as $lc_data) {

      $this->db->select('*');
  $this->db->from('tbl_product_units');
  $this->db->where('product_id',$lc_data['product_id']);
  $this->db->where('id',$lc_data['unit_id']);
  $lc_t_data= $this->db->get()->row();
// print_r($lc_t_data); die();

  $price =$lc_t_data->selling_price*$lc_data['quantity'];

  $t_price = $t_price + $price;
// echo $price; die();
   ?>
<tr>
<td class="cart_product"><a href="#"><img class="img-fluid" src="<?=base_url();?>assets/admin/product_units/<?=$lc_t_data->image1; ?>" alt=""> <?=$lc_t_data->unit_id; ?></a></td>

<!-- <td class="availability in-stock"><span class="badge badge-success">In stock</span></td> -->
<td class="price">₹<span><?=$lc_t_data->selling_price; ?></span></td>
<td class="qty">
<div class="input-group">
<!-- <span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span> -->
<input type="number" max="10" min="1" value="<?=$lc_data['quantity'];?>" class="form-control border-form-control form-control-sm input-number" name="quant[1]" onchange="updateQuantityCartSession(event ,<?=$lc_data['unit_id'];?>,<?=$lc_data['product_id'];?> )">
<!-- <span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button> -->
</span>
</div>
</td>
<td class="price">₹<span><?=$price ?></span></td>
<td class="action">
<a class="btn btn-sm btn-danger" data-original-title="Remove" href="<?php echo base_url() ?>Cart/delete_product_session/<?php echo base64_encode($lc_data['product_id']) ?>" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
</td>
</tr>
<?php
}
}
 ?>
<!-- <tr>
<td class="cart_product"><a href="#"><img alt="Product" src="<?=base_url()?>assets/frontend/img/item/10.jpg" class="img-fluid"></a></td>
<td class="cart_description">
<h5 class="product-name"><a href="#">Ipsums Dolors Untra </a></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</td>
<td class="availability out-of-stock"><span class="badge badge-primary">No stock</span></td>
<td class="price"><span>$00.00</span></td>
<td class="qty">
<div class="input-group">
<span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span>
<input type="text" max="10" min="1" value="1" class="form-control border-form-control form-control-sm input-number" name="quant[1]">
<span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button>
</span>
</div>
</td>
<td class="price"><span>00.00</span></td>
<td class="action">
<a class="btn btn-sm btn-danger" data-original-title="Remove" href="#" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
</td>
</tr> -->
<!-- <tr>
<td class="cart_product"><a href="#"><img alt="Product" src="<?=base_url()?>assets/frontend/img/item/9.jpg" class="img-fluid"></a></td>
<td class="cart_description">
<h5 class="product-name"><a href="#">Ipsums Dolors Untra </a></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
</td>
<td class="availability in-stock"><span class="badge badge-warning">In stock</span></td>
<td class="price"><span>$99.00</span></td>
<td class="qty">
<div class="input-group">
<span class="input-group-btn"><button disabled="disabled" class="btn btn-theme-round btn-number" type="button">-</button></span>
<input type="text" max="10" min="1" value="1" class="form-control border-form-control form-control-sm input-number" name="quant[1]">
<span class="input-group-btn"><button class="btn btn-theme-round btn-number" type="button">+</button>
</span>
</div>
</td>
<td class="price"><span>$188.00</span></td>
<td class="action">
<a class="btn btn-sm btn-danger" data-original-title="Remove" href="#" title="" data-placement="top" data-toggle="tooltip"><i class="mdi mdi-close-circle-outline"></i></a>
</td>
</tr> -->
</tbody>
<tfoot>
<!-- <tr>
<td colspan="1"></td>
<td colspan="4">
<form class="form-inline float-right">
<div class="form-group">
<input type="text" placeholder="Enter discount code" class="form-control border-form-control form-control-sm">
</div>
&nbsp;
<button class="btn btn-success float-left btn-sm" type="submit">Apply</button>
</form>
</td>
<td colspan="2">Discount : $237.88 </td>
</tr> -->
<tr>
<td colspan="2"></td>
<td class="text-right" colspan="3">Total products (tax incl.)</td>
<td colspan="2">₹<?= $t_price;?> </td>
</tr>
<tr>
<td class="text-right" colspan="5"><strong>Total</strong></td>
<td class="text-danger" colspan="2"><strong>₹<?= $t_price;?> </strong></td>
</tr>
</tfoot>
</table>
</div>
<?if(empty($this->session->userdata('user_id'))){
$user_id =  $this->session->userdata('user_id');?>
<a href="#" data-target="#bd-example-modal" data-toggle="modal" class="btn btn-link"><button class="btn btn-secondary btn-lg btn-block text-left" type="button" click><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>₹<?= $t_price;?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
<? }
else{
  redirect("cart/checkout");
}?>
</div>
<!-- <div class="card mt-2">
<h5 class="card-header">My Cart (Design Two)<span class="text-secondary float-right">(5 item)</span></h5>
<div class="card-body pt-0 pr-0 pl-0 pb-0">
<div class="cart-list-product">
<a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
<img class="img-fluid" src="<?=base_url()?>assets/frontend/img/item/11.jpg" alt="">
<span class="badge badge-success">50% OFF</span>
<h5><a href="#">Product Title Here</a></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
</div>
<div class="cart-list-product">
<a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
<img class="img-fluid" src="<?=base_url()?>assets/frontend/img/item/1.jpg" alt="">
<span class="badge badge-success">50% OFF</span>
<h5><a href="#">Product Title Here</a></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
</div>
<div class="cart-list-product">
<a class="float-right remove-cart" href="#"><i class="mdi mdi-close"></i></a>
<img class="img-fluid" src="<?=base_url()?>assets/frontend/img/item/2.jpg" alt="">
<span class="badge badge-success">50% OFF</span>
<h5><a href="#">Product Title Here</a></h5>
<h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6>
<p class="offer-price mb-0">$450.99 <i class="mdi mdi-tag-outline"></i> <span class="regular-price">$800.99</span></p>
</div>
</div>
<div class="card-footer cart-sidebar-footer">
<div class="cart-store-details">
<p>Sub Total <strong class="float-right">$900.69</strong></p>
<p>Delivery Charges <strong class="float-right text-danger">+ $29.69</strong></p>
<h6>Your total savings <strong class="float-right text-danger">$55 (42.31%)</strong></h6>
</div>
<a href="checkout.html"><button class="btn btn-secondary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="mdi mdi-cart-outline"></i> Proceed to Checkout </span><span class="float-right"><strong>$1200.69</strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
</div>
</div> -->
</div>
</div>
</div>
</section>





<script>

    //Update quantity in table onChange
    function updateQuantityCartSession(event ,type_id, product_id){
    var quantity = event.target.value;

    if(quantity < 1){
      alert('Less than 1 quantity is not allowed.')
      quantity = 1;
    }

    if(quantity > 2){
      alert('greater than 2 quantity is not allowed.')
      quantity = 2;
    }

    // alert(quantity);
    // alert(cart_id);
    // alert(product_id);
    var base_path = '<?=base_url();?>';
    // alert(base_path);
    $.ajax({
     url:base_path+'Cart/update_qty_in_session',
     method: 'post',
     data: { product_id: product_id, type_id: type_id, quantity: quantity },
     dataType: 'json',
     success: function(response){
    // alert("yay");
    // alert(response.data);

    //delete product from localStorage (if exist)



    location.reload();


    }
    });

    }

    </script>
