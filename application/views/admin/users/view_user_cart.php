<div class="content-wrapper">
<section class="content-header">
<h1>
View cart
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Team </a></li>
<li class="active">View Team</li>
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
              	<?php $i=1; foreach($users_cart_data->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php $t= $data->product_id;

$this->db->select('*');
            $this->db->from('tbl_product');
            $this->db->where('id',$t);
            $dsa= $this->db->get();
            $da=$dsa->row();
            echo $da->name;

 ?></td>
<td><?php  $t1= $data->unit_id;
$this->db->select('*');
            $this->db->from('tbl_product_units');
            $this->db->where('product_id',$t);
            $this->db->where('unit_id',$t1);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
              $u =$da->unit_id;
             $a= $da->selling_price;
             $this->db->select('*');
                         $this->db->from('tbl_units');
                         $this->db->where('id',$t1);
                         $dsa= $this->db->get();
                         $da=$dsa->row();
                         if(!empty($da)){
                           echo $da->name;

                         }
                         else{
                           echo "not found type";
                         }
           }
           else{
             echo "not found";
           }
 ?></td>
<td><?php
if(!empty($a)){
  echo "Rs. ".$a;
}
 ?></td>

<td><?php echo $c =$data->quantity; ?></td>
<td><? if(!empty($a)){ echo  "Rs. ".$a*$c; }?></td>

<td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
<ul class="dropdown-menu" role="menu">
<li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
</ul>
</div>
</div>

<div style="display:none" id="cnfbox<?php echo $i ?>">
<p> Are you sure delete this </p>
<a href="<?php echo base_url() ?>admin/home/delete_team/<?php echo base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
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
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
