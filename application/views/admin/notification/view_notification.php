
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Notifications
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Notifications</h3>
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

    	 <th>Notification Type</th>
    	 <th>Notification Title</th>
    	 <th>User</th>
 	     <th>Notification Title</th>
        <th>Status</th>
        <th>Date</th>
        <!-- <th>Action</th> -->
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($notification_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>

 	 <td><?php if($data->notification_type == "1"){ echo "Order success"; }
   if($data->notification_type == "2"){ echo "Order transfered to delivery boy"; }
   ?></td>
 	 <td><?php echo $data->notification_title ?></td>
 	 <td><?php
            $this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$data->user_id);
$user_name= $this->db->get()->row();

if(!empty($user_name)){
   echo $user_name->first_name." ".$user_name->last_name; } else{ echo "user not found!";}?></td>
 	 <td><?php echo $data->description ?></td>

        <td>
          <?php
          if( $data->is_read == 0 ){ ?>
          <span style="color:red;">  <?  echo "Unread"; ?></span>
        <?php  }
          else{?>


           <span style="color:green;"><?php echo "Read"; ?> </span>
            <?php }?>
        </td>

        <td>
        <?php  $d_newdate = new DateTime($data->date);
          echo $d_newdate->format('j F, Y'); ?>
        </td>
        <!-- <td> -->
        <!-- <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="<?php echo base_url() ?>dcadmin/users/view_user_address/<?php echo
          base64_encode($data->id) ?>">View User Address</a></li>
        <?php if($data->is_active==1){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/users/updateusersStatus/<?php echo
        base64_encode($data->id) ?>/inactive">Inactive</a></li>
        <?php } else { ?>
        <li><a href="<?php echo base_url() ?>dcadmin/users/updateusersStatus/<?php echo
        base64_encode($data->id) ?>/active">Active</a></li>
        <?php } ?>
        <!-- <li><a href="<?php echo base_url() ?>dcadmin/users/update_users/<?php echo
        base64_encode($data->id) ?>">Edit</a></li> -->
        <!-- <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
        </ul>
        </div>
        </div>

        <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure delete this </p>
        <a href="<?php echo base_url() ?>dcadmin/users/delete_users/<?php echo
        base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
        </div>  -->
        <!-- </td> -->
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
