<div class="content-wrapper">
               <section class="content-header">
                  <h1>
                 Add Inventory
                 </h1>

               </section>
           <section class="content">
           <div class="row">
              <div class="col-lg-12">

                               <div class="panel panel-default">
                                   <div class="panel-heading">
                                       <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add Inventory</h3>
                                   </div>

                                            <? if(!empty($this->session->flashdata('smessage'))){  ?>
                                                 <div class="alert alert-success alert-dismissible">
                                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                             <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                            <? echo $this->session->flashdata('smessage');  ?>
                                           </div>
                                              <? }
                                              if(!empty($this->session->flashdata('emessage'))){  ?>
                                              <div class="alert alert-danger alert-dismissible">
                                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                           <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                          <? echo $this->session->flashdata('emessage');  ?>
                                         </div>
                                            <? }  ?>


                                   <div class="panel-body">
                                       <div class="col-lg-10">
                                          <form action=" <?php echo base_url()  ?>dcadmin/inventory/add_inventory_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">

 <input type="hidden" name="product_id"  class="form-control" placeholder="" required value="<?= base64_decode($product_id)?>" />

<?php

$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',base64_decode($product_id));
$product_data_dsa = $this->db->get()->row();
$product_unit_type = $product_data_dsa->product_unit_type;
if($product_unit_type == 2){
?>
 <tr>
 <td> <strong>Select Product Type</strong>  <span style="color:red;">*</span></strong> </td>
 <td> <select class="form-control" name="unit_id" required >
 <option value="" selected disabled> ----select type----</option>
 <?     $this->db->select('*');
 $this->db->from('tbl_product_units');
 $this->db->where('product_id',base64_decode($product_id));
 $db_pro_units = $this->db->get();

 foreach($db_pro_units->result() as $dd1) {
   $this->db->select('*');
   $this->db->from('tbl_units');
   $this->db->where('id',$dd1->unit_id);
   $db_units_data = $this->db->get()->row();
   ?>
  <option value="<?=$dd1->unit_id ?>"><?= $db_units_data->name ?></option>
 <?

 }
 ?>
  </select>  </td>
 </tr>
<?php }else{
  ?>
  <input type="hidden" name="unit_id" value="0">
  <?php
} ?>
<td> <strong>Stock  <?php
if($product_unit_type == 1){ echo " ( ex : 1 for 1kg , 0.5 for 500 gram)"; }
?></strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="stock"  class="form-control" placeholder="" required value="" />  </td>
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


<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
     <link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
