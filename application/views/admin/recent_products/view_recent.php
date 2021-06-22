<div class="content-wrapper">
<section class="content-header">
<h1>
Recent products
</h1>
<ol class="breadcrumb">
<li class="active">View recent products</li>
</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
<a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/AppSlider/add_recent_products" role="button" style="margin-bottom:12px;"> Add recent products</a>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View recent_products</h3>
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


<div class="panel-body">
<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-hover table-striped" id="userTable">
<thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Image</th>
        <th>Action</th>
          </tr>
      </thead>
      <tbody>
<?php $i=1; foreach($recent_products->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php $id=$data->product_id;
$this->db->select('*');
            $this->db->from('tbl_product');
            $this->db->where('id',$id);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
              echo $da->name;
              $c1=$da->category_id;
              $i1=$da->image1;
            }
          else{
            echo "No data";
          }


?></td>
<td>
<?
$this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('id',$c1);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
              echo $da->name;
            }
          else{
            echo "No data";
          }


?>

</td>
<td>
<?php if($i1!=""){  ?>
<img id="slide_img_path" height=50 width=100  src="<?php echo base_url().$i1 ?>" >
<?php }else {  ?>
Sorry No image Found
<?php } ?>
</td>
<td>

<a type="button" href="javascript:;" class="dCnf btn btn-danger" mydata="<?php echo $i ?>">Delete</a></li>

<div style="display:none" id="cnfbox<?php echo $i ?>">
<p> Are you sure delete this </p>
<a href="<?php echo base_url() ?>dcadmin/AppSlider/delete_recent_products/<?php echo base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
<a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
</div>
</td>
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
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>    -->
