<div class="content-wrapper">
<section class="content-header">
<h1>
View user cart
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All user </a></li>
<li class="active">View user cart</li>
</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View cart</h3>
</div>
   <div class="panel panel-default">

   			  <? if(!empty($this->session->flashdata('smessage'))){ ?>
   			        <div class="alert alert-success alert-dismissible">
   			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   			    <h4><i class="icon fa fa-check"></i> Alert!</h4>
   			  <? echo $this->session->flashdata('smessage'); ?>
   			  </div>
   			    <? }
   			     if(!empty($this->session->flashdata('emessage'))){ ?>
   			     <div class="alert alert-danger alert-dismissible">
   			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   			  <h4><i class="icon fa fa-ban"></i> Alert!</h4>
   			<? echo $this->session->flashdata('emessage'); ?>
   			</div>
   			  <? } ?>

<input type="hidden" value="<?=base_url()?>" id="app_base_url_value">
<div class="panel-body">
    <div class="box-body table-responsive no-padding">
    <table class="table table-bordered table-hover table-striped" id="userTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Type Price</th>
                <th>Qty</th>
                <th>Total Price</th>
                <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              	<?php $am=0; $i=1; foreach($users_cart_data->result() as $data) { ?>

<tr>
  <form action="<?=base_url()?>/dcadmin/users/update_admin_cart_data" method="post" enctype="multipart/form-data">

    <input type="hidden" value="<?php echo base64_encode($id);?>"  name="userId">
    <input type="hidden" value="<?=$data->product_id;?>"  name="product_id">

<td><?php echo $i ?> </td>
<td><?php $t= $data->product_id;

$this->db->select('*');
            $this->db->from('tbl_product');
            $this->db->where('id',$t);
            $dsa= $this->db->get();
            $da=$dsa->row();
            echo $da->name;

 ?></td>

<?php  $t1= $data->unit_id;
$this->db->select('*');
            $this->db->from('tbl_product_units');
            $this->db->where('product_id',$t);
            $this->db->where('unit_id',$t1);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
              $u =$da->unit_id;
             $a= $da->selling_price;


           }else{
             $u ="";
            $a= "";
           }
           $k =$data->quantity;
           $q_pric= $a* $k;
           $am= $am + $q_pric;
      ?>


 <td>
   <select name="part" class="form-control part" required myid="<?=$data->product_id?>" id="part_<?=$data->product_id?>">
     <!-- <option value="" disabled selected>--select category--</option> -->
     <?php

                 $this->db->select('*');
     $this->db->from('tbl_product_units');
     $this->db->where('product_id',$data->product_id);
     $product_unit= $this->db->get();


     if(!empty($product_unit)){
      foreach($product_unit->result() as $pro_unit) {


     $this->db->select('*');
    	$this->db->from('tbl_units');
    	$this->db->where('id',$pro_unit->unit_id);
    	$unit_data= $this->db->get()->row();

    	if(!empty($unit_data)){

    		$unit_name= $unit_data->name;
    	}else{
    		$unit_name="Unit not found!";
    	}

     ?>
      <option value="<?php if(!empty($pro_unit)){echo $pro_unit->unit_id; }?>" <?php if(!empty($data->unit_id == $pro_unit->unit_id)){ echo "selected"; }?>> <?= $unit_name ?> </option>
      <?php
    } } else{  ?>
      <option value="" disabled selected>Unit not available</option>
      <?php } ?>
    </select>
 </td>


<td>Rs. <span id="price_<?=$data->product_id?>">
  <?php
if(!empty($a)){
  echo $a;
}
 ?>
</span>
</td>

<td>
<input type="number" class="qtys" value="<?php echo $c =$data->quantity; ?>" min="1" name="qty" id="qty_<?=$data->product_id?>" pro_id="<?=$data->product_id?>" required>
</td>
<td>Rs. <span id="qty_price_<?=$data->product_id?>">
  <? if(!empty($a)){ echo  $a*$c; }?>
</span></td>

<td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button> -->
<!-- <ul class="dropdown-menu" role="menu"> -->
<a type="button" href="javascript:;" class="btn btn-default dCnf" mydata="<?php echo $i ?>">Delete</a>&nbsp; &nbsp;
<!-- </ul> -->

<button type="submit" class="btn btn-default" > update </button>

</div>
</div>

<div style="display:none" id="cnfbox<?php echo $i ?>">
<p> Are you sure delete this </p>
<a href="<?php echo base_url() ?>dcadmin/users/delete_admin_cart/<?php echo base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
<a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
</div>
</td>
</form>
</tr>
<?php  $i++; } ?>


</tbody>

</table>
<?php if(!empty($users_cart_data->result())){?>
<a href="<?=base_url()?>dcadmin/users/checkout_admin/<?=base64_encode($id);?>" type="button" class="btn btn-default " data-> Proceed To Pay&nbsp;&nbsp;&nbsp;&nbsp; Rs. <span style="color:red;"><?php echo $am;?></span></a>
<?php } ?>




    </div>
</div>
</div>

</div>

</div>
</div>
</section>
</div>


<style>
label{
margin:5px;
}
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">

$(document).ready(function(){
$('#userTable').DataTable({
responsive: true,
// bSort: true
});

$(document.body).on('click', '.dCnf', function() {
var i=$(this).attr("mydata");
console.log(i);

$("#btns"+i).hide();
$("#cnfbox"+i).show();

});

$(document.body).on('click', '.cans', function() {
var i=$(this).attr("mydatas");
console.log(i);

$("#btns"+i).show();
$("#cnfbox"+i).hide();
})

});

</script>


<script>
//alert('Changed!')

  $('.qtys').on('change', function(){
  // alert(" detected"); exit;

  var pro_id = $(this).attr("pro_id");
  // var pro_id = $(this).attr("pro_id");
  var qtty = $(this).val();

  var pric = $("#price_"+pro_id).text();

if(qtty == 0){
  var qty_pric = pric * 1;
}else{
  var qty_pric = pric * qtty;
}
  $("#qty_price_"+pro_id).text("");
  $("#qty_price_"+pro_id).text(qty_pric);



});

</script>


<script>

$(document).ready(function(){

$(".part").on('change', function(){
// alert("yay");
// $(this).find('option:selected').attr('myId')
var base_url = $("#app_base_url_value").val();
// alert(base_url);
var unit_id=$(this).val();
//console.log(unit_id);
// alert(unit_id);
var dataId = $(this).attr("myid");



//console.log(dataId);
// alert(dataId);
$.ajax({
url:base_url+'Products/all_productsdata',
method: 'post',
data: {un_id: unit_id , pro_id : dataId},
dataType: 'json',
success: function(response){

if(response.data == true){
console.log(response.details);
// alert(response.details);

var unit_id2= response.details;
var product_id=response.details.product_id;
//console.log(product_id);
$("#price_"+product_id).text("");
$("#price_"+product_id).text(response.details.selling_price);


var qtty = $("#qty_"+dataId).val();
var pric = $("#price_"+dataId).text();

if(qtty == 0){
  var qty_pric = pric * 1;
}else{
  var qty_pric = pric * qtty;
}


$("#qty_price_"+dataId).text("");
$("#qty_price_"+dataId).text(qty_pric);


}
else{
alert('hiii');
}
}
});



});
});

</script>

<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
