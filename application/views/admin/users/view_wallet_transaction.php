
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Wallet Transaction
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
          <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/users/add_users"
          role="button" style="margin-bottom:12px;"> Add User</a> -->
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Wallet Transaction</h3>
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
    	 <th>status</th>
    	 <th>By Admin</th>
 	     <th>To User</th>
 	     <th>Order Id</th>
        <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($transaction_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>

 	 <td><?php

if($data->type == 1){
  echo "Spent Money";
}
if($data->type == 2){
  echo "Added Money";
}


   ?></td>
 	 <td><?php

   if($data->type == 1){
     echo "Spent Rs. ".echo $data->wallet_amount;
   }
   if($data->type == 2){
     echo "Added Rs.".echo $data->wallet_amount;
   }


    ?></td>

 	 <td><?php
   if($data->type == 2){
                 $this->db->select('*');
     $this->db->from('tbl_team');
     $this->db->where('id',$data->added_by);
     $admin= $this->db->get()->row();
     if(!empty($admin)){
       echo "Added By ".echo $admin->name;
     }else{
       echo "admin not found";
     }

   }
    ?></td>

 	 <td><?php

   if($data->type == 2){
                 $this->db->select('*');
     $this->db->from('tbl_users');
     $this->db->where('id',$data->user_id);
     $user= $this->db->get()->row();
     if(!empty($admin)){
       echo "To ".echo $user->name;
     }else{
       echo "User not found";
     }

   }

    ?></td>
 	 <td><?php
   if($data->type == 1){
     echo "Spent For Order Id ".echo $data->order_id;
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
