
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Cart Product
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/users/view_admin_user_cart/<?=$user_id?>"
        role="button" style="margin-bottom:12px;"> View Cart</a>
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Cart Product</h3>
        </div>
        <div class="panel panel-default">

        <? if(!empty($this->session->flashdata('smessage'))){ ?>
        <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <? echo $this->session->flashdata('smessage'); ?>
        </div>
        <? }
        if(!empty($this->session->flashdata('emessage'))){ ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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

 	 <th>Product Name</th>
 	 <th>Category</th>
 	 <!-- <th>Short Description</th> -->
 	 <!-- <th>Long Description</th> -->
 	 <th>Images</th>
 	 <th>Type</th>
 	 <th>Quantity</th>
 	 <th>Price</th>
 	 <th>Quantity Price</th>


        <th>Action</th>
        </tr>
        </thead>
        <tbody>


        <?php $i=1; foreach($product_data->result() as $data) { ?>

        <tr>
          <form action="<?=base_url()?>/dcadmin/users/add_to_cart_data" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?=$user_id;?>"  name="userId">
            <input type="hidden" value="<?=$data->id;?>"  name="product_id">
        <td><?php echo $i ?> </td>

 	 <td><?php echo $data->name ?></td>
 	 <td><?php
   $this->db->select('*');
         $this->db->from('tbl_category');
         $this->db->where('id',$data->category_id);
         $cat_dsa= $this->db->get()->row();
         if(!empty($cat_dsa)){
           echo $cat_dsa->name;
         }
       else{
         echo "Not available";
       }
       ?></td>


 	 <!-- <td><?php //echo $data->short_description ?></td>
 	 <td><?php //echo $data->long_description ?></td> -->

   <td>
   <?php if($data->image1!=""){ ?>
   <img id="slide_img_path"  style="border:solid red 1px;padding: 5px;" height=50 width=80 src="<?php echo base_url().$data->image1
   ?>" >
   <?php } ?>


   <?php if($data->image2!=""){ ?>
   <img id="slide_img_path" style="border:solid red 1px;padding: 5px;"  height=50 width=80 src="<?php echo base_url().$data->image2
   ?>" >
 <?php } ?><br>
   <?php if($data->image3!=""){ ?>
   <img id="slide_img_path" style="border:solid red 1px;padding: 5px;"  height=50 width=80 src="<?php echo base_url().$data->image3
   ?>" >
   <?php } ?>
   <?php if($data->image4!=""){ ?>
   <img id="slide_img_path" style="border:solid red 1px;padding: 5px;"  height=50 width=80 src="<?php echo base_url().$data->image4
   ?>" >
   <?php } ?>
   </td>

<td>
  <select name="part" class="form-control part" required myid="<?=$data->id?>" id="part_<?=$data->id?>">
    <!-- <option value="" disabled selected>--select category--</option> -->
    <?php

                $this->db->select('*');
    $this->db->from('tbl_product_units');
    $this->db->where('product_id',$data->id);
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
     <option value="<?php if(!empty($pro_unit)){echo $pro_unit->unit_id; }?>"> <?= $unit_name ?> </option>
     <?php
   } } else{  ?>
     <option value="" disabled selected>Unit not available</option>
     <?php } ?>
   </select>
</td>

<td>
<input type="number" class="qtys" value="1" min="1" name="qty" id="qty_<?=$data->id?>" pro_id="<?=$data->id?>" required>
</td>
<?php
$this->db->limit(1);
$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('product_id',$data->id);
$prod_unit= $this->db->get()->row();



?>
<td>
<div>Rs. <span class="" id="price_<?=$data->id?>">           <?if(!empty($prod_unit)){echo $prod_unit->selling_price;}else{
  echo "N/A";} ?>
  <span>
</div>
</td>


        <td>
            <div>
              Rs. <span id="qty_price_<?=$data->id?>">
                <?if(!empty($prod_unit)){echo $prod_unit->selling_price;}else{
                  echo "N/A";} ?>
              </span>
              <div>
        </td>

        <td>
        <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="submit" class="btn btn-default " data->
        Add To Cart </button>
        <!-- <ul class="dropdown-menu" role="menu">

        <?php if($data->is_active==1){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product/updateproductStatus/<?php echo
        base64_encode($data->id) ?>/inactive">Inactive</a></li>
        <?php } else { ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product/updateproductStatus/<?php echo
        base64_encode($data->id) ?>/active">Active</a></li>
        <?php } ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product/update_product/<?php echo
        base64_encode($data->id) ?>">Edit</a></li>
        <li><a href="<?php echo base_url() ?>dcadmin/product_units/add_product_units/<?php echo
        base64_encode($data->id) ?>">Add Type</a></li>
        <li><a href="<?php echo base_url() ?>dcadmin/product_units/view_product_units/<?php echo
        base64_encode($data->id) ?>">View Types</a></li>
        <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
        </ul> -->
        </div>
        </div>

        <!-- <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure delete this </p>
        <a href="<?php echo base_url() ?>dcadmin/product/delete_product/<?php echo
        base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
        </div> -->
        </td>
              </form>
        </tr>
        <?php $i++; } ?>


        </tbody>
        </table>

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
        <!-- <script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script> -->




        <!-- <script type="text/javascript" src="<?php echo base_url()
        ?>assets/slider/ajaxupload.3.5.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script> -->
