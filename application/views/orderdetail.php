
<section class="account-page section-padding">
<div class="container">
<div class="row">
<div class="col-lg-9 mx-auto">
<div class="row no-gutters">
  <div class="col-md-4">
  <div class="card account-left">
  <div class="user-profile-header">

    <?
      $odr_id=$order_details;
      $user_id=$this->session->userdata('user_id');
                $this->db->select('*');
    $this->db->from('tbl_user_address');
    $this->db->where('user_id',$user_id);
    $user_data= $this->db->get()->row();

            $this->db->select('*');
$this->db->from('tbl_order2');
$this->db->where('main_id',$odr_id);
$order_data= $this->db->get();
$orders= $order_data->row();



    ?>


  <h5 class="mb-1 text-secondary"><strong>Hi </strong><?=$user_data->name;?></h5>
  <p><?=$user_data->contact;?></p>
  </div>
  <div class="list-group">
  <a href="<?=base_url();?>Home/my_profile" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-account-outline"></i> My Profile</a>
  <!-- <a href="<?=base_url();?>Home/my_address" class="list-group-item list-group-item-action "><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i> My Address</a> -->
  <a href="<?=base_url();?>Home/wishlist" class="list-group-item list-group-item-action "><i aria-hidden="true" class="mdi mdi-heart-outline"></i> Wish List </a>
  <a href="<?=base_url();?>Home/orderlist" class="list-group-item list-group-item-action active"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i> Order List</a>
  <a href="#" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-lock"></i> Logout</a>
  </div>
  </div>
  </div>
<div class="col-md-8">
<div class="card card-body account-right">
<div class="widget">
<div class="section-header">
<h5 class="heading-design-h5">
Order Details
</h5>
</div>
<div class="order-list-tabel-main table-responsive">
<table class="datatabel table table-striped table-bordered order-list-tabel" width="100%" cellspacing="0">
<thead>
<tr>
<th>Order #</th>
<th>Name</th>
<th>unit</th>
<th>Quantity</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
<?  if(!empty($orders)){
foreach ($order_data->result() as $value) {

            $this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',$value->product_id);
$pd= $this->db->get()->row();
$pname=$pd->name;

            $this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('id',$value->unit_id);
$pu= $this->db->get()->row();
$pun=$pu->unit_id;

?>
<td><?=$odr_id;?></td>
<td><?=$pname;?></td>
<td><?=$pun;?></td>
 <td><?=$value->quantity;?></td>
<td>RS.<?=$value->amount;?></td>

</tr>
<?php  }} ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>


<script type="190457b67c0ef49b30cb8b1e-text/javascript">
         $(document).ready(function() {
             $('.datatabel').DataTable();
         } );
      </script>
