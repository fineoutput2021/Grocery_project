
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Product Types
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/product_units/add_product_units/<?= base64_encode($product_id)?>"
        role="button" style="margin-bottom:12px;"> Add Product Type</a>
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Product Types</h3>
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

 	 <th>Type</th>
 	 <th>MRP</th>
 	 <th>Selling Price</th>
   <th>GST Percentage</th>
   <th>GST Amount</th>
   <th>Total Amount</th>
   <th>Image 1</th>
   <th>Image 2</th>
   <th>Image 3</th>
   <th>Image 4</th>

   <?php
   $pro_unit_type = 0;
   $this->db->select('*');
         $this->db->from('tbl_product');
         $this->db->where('id',$product_id);
         $product_data= $this->db->get()->row();
         if(!empty($product_data)){
           $pro_unit_type = $product_data->product_unit_type;
         }

    if($pro_unit_type == 1){?>
     <th>Ratio</th>
   <?}?>

        <th>Status</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($product_units_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>

 	 <!-- <td><?php
   $this->db->select('*');
         $this->db->from('tbl_units');
         $this->db->where('id',$data->unit_id);
         $units_dsa= $this->db->get()->row();
         if(!empty($units_dsa)){
           echo $units_dsa->name;
         }else{
           echo "N/A";
         }?></td> -->
 	 <td><?php echo $data->unit_id ?></td>
 	 <td><?php echo $data->mrp ?></td>
 	 <td><?php echo $data->without_selling_price ?></td>
   <td><?php echo $data->gst_percentage ?></td>
   <td><?php echo $data->gst_amount ?></td>
   <td><?php echo $data->selling_price ?></td>
   <td>
     <?php if($data->image1!=""){  ?>
                         <img id="slide_img_path" height=200 width=300  src="<?php echo base_url()."assets/admin/product_units/".$data->image1 ?>" >
                       <?php }else {  ?>
                         Sorry No image Found
                       <?php } ?>
     </td>
   <td>
     <?php if($data->image2!=""){  ?>
                         <img id="slide_img_path" height=200 width=300  src="<?php echo base_url()."assets/admin/product_units/".$data->image2 ?>" >
                       <?php }else {  ?>
                         Sorry No image Found
                       <?php } ?>
     </td>
   <td>
     <?php if($data->image3!=""){  ?>
                         <img id="slide_img_path" height=200 width=300  src="<?php echo base_url()."assets/admin/product_units/".$data->image3 ?>" >
                       <?php }else {  ?>
                         Sorry No image Found
                       <?php } ?>
     </td>
   <td>
     <?php if($data->image4!=""){  ?>
                         <img id="slide_img_path" height=200 width=300  src="<?php echo base_url()."assets/admin/product_units/".$data->image4 ?>" >
                       <?php }else {  ?>
                         Sorry No image Found
                       <?php } ?>
     </td>


<?php if($pro_unit_type == 1){?>
  <td><?php echo $data->ratio ?></td>

<?php
}?>


        <td><?php if($data->is_active==1){ ?>
        <p class="label bg-green" >Active</p>

        <?php } else { ?>
        <p class="label bg-yellow" >Inactive</p>


        <?php } ?>
        </td>
        <td>
        <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

        <?php if($data->is_active==1){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product_units/updateproduct_unitsStatus/<?php echo
        base64_encode($data->id) ?>/inactive">Inactive</a></li>
        <?php } else { ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product_units/updateproduct_unitsStatus/<?php echo
        base64_encode($data->id) ?>/active">Active</a></li>
        <?php } ?>
        <li><a href="<?php echo base_url() ?>dcadmin/product_units/update_product_units/<?php echo
        base64_encode($data->id) ?>">Edit</a></li>
        <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
        </ul>
        </div>
        </div>

        <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure delete this </p>
        <a href="<?php echo base_url() ?>dcadmin/product_units/delete_product_units/<?php echo
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
