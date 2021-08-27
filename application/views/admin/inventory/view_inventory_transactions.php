
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Inventory Transactions
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Inventory Transactions</h3>
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
        <th>Product</th>
 	 <th>Types</th>
 	 <th>Stock</th>
   <th>Team</th>
   <th>Date</th>

        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($inventory_transactions_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>
        <td>
<?php $this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('id',$data->product_id);
      $pro_dsa= $this->db->get()->row();;
      if(!empty($pro_dsa)){?>

<a href="<?php echo base_url();?>dcadmin/product/update_product/<?= base64_encode($data->product_id) ?>"><?=  $pro_dsa->name ?> </a>
    <?php  }
    else{
      echo "No product name";
    }
?></td>
   <td><?php
   $this->db->select('*');
         $this->db->from('tbl_units');
         $this->db->where('id',$data->unit_id);
         $units_dsa= $this->db->get()->row();
         if(!empty($units_dsa)){
           echo $units_dsa->name." ".$units_dsa->suffix;
         }else{
           echo "N/A";
         }?></td>
 	 <td><?php echo $data->stock ?></td>
   <td><?php
if($data->type == 1){
  $admin_name = "Admin";
$this->db->select('*');
      $this->db->from('tbl_team');
      $this->db->where('id',$data->added_by);
      $team_dsa= $this->db->get()->row();
      if(!empty($team_dsa)){
        $admin_name = $team_dsa->name;
      }


  echo "Added by ".$admin_name;
}
if($data->type == 2){
  echo "Reduced By Offline Order";
}

if($data->type == 3){
  $user_name = "Customer";
$this->db->select('*');
      $this->db->from('tbl_users');
      $this->db->where('id',$data->added_by);
      $user_dsa= $this->db->get()->row();
      if(!empty($user_dsa)){
        $user_name = $user_dsa->first_name . $user_dsa->last_name;
      }


  echo "Added By Online Order (".$user_name.")  ";
}

?></td>

  <td>
<?
  $newdate = new DateTime($data->date);
  echo $newdate->format('j F, Y, g:i a');   #d-m-Y  // March 10, 2001, 5:16 pm
  ?>
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
