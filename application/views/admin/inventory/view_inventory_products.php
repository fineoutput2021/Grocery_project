
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Product
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">        
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View product</h3>
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

 	 <th>Product Name</th>
 	 <th>Category</th>
 	 <th>Short Description</th>
 	 <th>Long Description</th>
 	 <th>Images</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($product_data->result() as $data) { ?>
        <tr>
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
 	 <td><?php echo $data->short_description ?></td>
 	 <td><?php echo $data->long_description ?></td>

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
        <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

        <li><a href="<?php echo base_url() ?>dcadmin/inventory/add_inventory/<?php echo
        base64_encode($data->id) ?>">Add Inventory</a></li>
        <li><a href="<?php echo base_url() ?>dcadmin/inventory/view_inventory/<?php echo
        base64_encode($data->id) ?>">View Inventory</a></li>
        <li><a href="<?php echo base_url() ?>dcadmin/inventory/add_offline_order/<?php echo
        base64_encode($data->id) ?>">Add Offline Order</a></li>

        </ul>
        </div>
        </div>

        <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure delete this </p>
        <a href="<?php echo base_url() ?>dcadmin/product/delete_product/<?php echo
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
