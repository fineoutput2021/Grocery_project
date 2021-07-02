
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Inventory
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/inventory/add_inventory/<?= $product_id?>"
        role="button" style="margin-bottom:12px;"> Add inventory</a>
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View inventory</h3>
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


        <div class="panel-body">
        <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-striped" id="userTable">
        <thead>
        <tr>
        <th>#</th>
<?php
$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',base64_decode($product_id));
$product_data_dsa = $this->db->get()->row();
$product_unit_type = $product_data_dsa->product_unit_type;
if($product_unit_type == 2){
  ?>
 	 <th>Product Type</th>
 <?php } ?>
 	 <th>Stock</th>
   <th>Action</th>


        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($inventory_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>

                 <?php
                 if($product_unit_type == 2){
                   ?>
   <td><?php
   $this->db->select('*');
         $this->db->from('tbl_product_units');
         $this->db->where('id',$data->unit_id);
         $units_dsa= $this->db->get()->row();
         if(!empty($units_dsa)){
           echo $units_dsa->unit_id;
         }else{
           echo "N/A";
         }?></td>

 <?php } ?>
 <td><?php echo $data->stock ?></td>
   <td>
         <div class="btn-group" id="btns<?php echo $i ?>">
         <div class="btn-group">
         <a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>"><button type="button" class="btn btn-default">
         Delete</button></a>
         </div>
         </div>

         <div style="display:none" id="cnfbox<?php echo $i ?>">
         <p> Are you sure delete this </p>
         <a href="<?php echo base_url() ?>dcadmin/inventory/delete_inventory/<?php echo
         base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
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
        <!-- <script type="text/javascript" src="<?php echo base_url()
        ?>assets/slider/ajaxupload.3.5.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script> -->
