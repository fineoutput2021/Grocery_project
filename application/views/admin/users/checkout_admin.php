<div class="content-wrapper">
<section class="content-header">
<h1>
Checkout
</h1>

</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Checkout</h3>
</div>

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
<div class="col-lg-10">
<form action="<?php echo base_url() ?>dcadmin/users/checkout_data/<? echo base64_encode($id); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">

<tr>
            <td> <strong>Address</strong>  <span style="color:red;">*</span></strong> </td>
            <td>
      <?php $i=1; foreach($address->result() as $data) { ?>
<input type="radio" name="address_id" value="<?php echo $data->id; ?>">&nbsp;<?=$data->address;?></input>
<br/><br/>
<?php $i++; } ?>
          </td>
</tr>
<tr>
            <td> <strong>New Address</strong>  <span style="color:red;"></span></strong> </td>
            <td>
  <textarea name="new_address" value=""></textarea>
          </td>
</tr>

<tr>

  <!-- <label><b>Select Delivery slot</b></label><br> -->
<td> <strong>Time Slot</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <select id="slot_selection" name="slot_id">
    <?  $this->db->select('*');
    $this->db->from('tbl_delivery_slots');
    $slots_data= $this->db->get();
    $slot_rows = 0;
   foreach($slots_data->result() as $slot) {
    ?>
<option value=<?=$slot->id ?>><?=date("h:i a", strtotime($slot->from_time)) ?> to <?=date("h:i a", strtotime($slot->to_time))?> </option><?php
$slot_rows++;

    }
    if($slot_rows == 0){?>
<option value="0">-------No slots available------- </option><?php

    }
    ?>


  </select>
</td>
</tr>


<tr>
    <td> <strong>Delivery Date</strong>  <span style="color:red;">*</span></strong> </td>
    <td>

    <input type="date" name="delivery_date" value="" min="<?php echo date("Y-m-d"); ?>"/>


  </td>
</tr>




<tr>
            <td> <strong>Payment Type</strong>  <span style="color:red;">*</span></strong> </td>
            <td>
<input type="radio" name="payment"  required value="1">&nbsp;Cash of Delivery</input>
<br/>
<input type="radio" name="payment" required value="2">&nbsp;Online Payment</input>

          </td></tr>

          <tr>
              <td> <strong>Promocode</strong>  <span style="color:red;">*</span></strong> </td>
              <td>

              <input type="text" name="promocode" value="" />


            </td>
          </tr>


<tr>
<td colspan="2" >
<input type="submit" class="btn btn-success" value="save">
</td>
</tr>
    </table>
</div>

</form>

</div>



</div>

</div>

</div>
</div>
</section>
</div>


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
