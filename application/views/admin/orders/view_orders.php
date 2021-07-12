
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
        <?= $page_title?>
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">

        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title pan_sc"><i class="fa fa-money fa-fw"></i> <?= $page_title?></h3>
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
        <div class="box-body table-responsive no-padding table_res">
          <a type="button" class="btn btn-default" href="<?php echo base_url() ?>dcadmin/orders/excel_export">Export Excel</a>
        <table class="table table-bordered table-hover table-striped" id="userTable">
        <thead>
        <tr>
        <th>#</th>

 	 <th>User</th>
 	 <th>Total Amount</th>
   <th>promocode</th>
 	 <th>Address</th>
   <th>User Mob.</th>
   <th>City</th>
   <th>State</th>
   <th>Zipcode</th>
 	 <th>Payment Type</th>
 	 <!-- <th>Payment Status</th> -->
   <th>Expected Delivery Date</th>
   <th>Slot Time</th>
 	 <th>Order Status</th>
   <th>Delivery Status</th>
 	 <th>Last Update Date</th>
 	 <th>Order Date</th>
 	 <th>Order Products</th>
 	 <th>Order from</th>
 	 <th>Order Cancel from</th>

        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;foreach($orders_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>

   <td>
<?php $this->db->select('*');
 $this->db->from('tbl_users');
 $this->db->where('id',$data->user_id);
 $user_dsa= $this->db->get()->row();
 if(!empty($user_dsa)){?>

<?php echo $user_dsa->first_name." ".$user_dsa->last_name ?>
<?php  }
else{
 echo "N/A";
}
?></td>
 	 <td><?php echo "Rs. ".$data->total_amount; ?></td>

    <td>

        <?php
         $promocode_name= "";

         $this->db->select('*');
         $this->db->from('tbl_promocode_applied');
         $this->db->where('order_id',$data->id);
         $this->db->where('user_id',$data->user_id);
         $order_promocode= $this->db->get()->row();

         if(!empty($order_promocode)){
         $this->db->select('*');
         $this->db->from('tbl_promocode');
         $this->db->where('id',$order_promocode->promocode_id);
         $order_promocode= $this->db->get()->row();
          if(!empty($order_promocode)){
         $promocode_name= $order_promocode->promocode;
          }
          else{
            $promocode_name= "";
          }

        }
        else{
             $promocode_name= "";
        }


        ?>

        <?php if(!empty($promocode_name)){
           echo $promocode_name;
          }else{
              echo "No Promocode";
          } ?>
    </td>

 	 <td><?php
   $addr_city = "N/A";

   $addr_state = "N/A";

   $addr_zipcode = "N/A";
$this->db->select('*');
      $this->db->from('tbl_user_address');
      $this->db->where('id',$data->address_id);
      $address_sa= $this->db->get()->row();
      if(!empty($address_sa)){
        $addr_city = $address_sa->city;
        $addr_state = $address_sa->state;
        $addr_zipcode = $address_sa->zipcode;
        echo $address_sa->address;
      }
    else{
      echo "No Address Available";
    }

 ?></td>

 <td>

   <?php $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->where('id',$data->user_id);
    $user_dsas= $this->db->get()->row();
    if(!empty($user_dsas)){?>

   <?php echo $user_dsas->contact; ?>
   <?php  }
   else{
    echo "N/A";
   }
   ?>

 </td>

 <td>
<?php         echo $addr_city;?>

 </td>
 <td>
<?php         echo $addr_state;?>

 </td>

 <td>
<?php         echo $addr_zipcode;?>

 </td>

 	 <td><?php
if($data->payment_type == 1){
  echo "Cash On Delivery";
}
if($data->payment_type == 2){
  echo "Online Payment";
}?></td>
 	 <!-- <td><?php if($data->payment_status == 0){
     ?><span class="label label-warning" style="font-size:13px;">Pending</span><?php
   }
   if($data->payment_status == 1){
      ?><span class="label label-success" style="font-size:13px;">Succeed</span><?php
  }
    ?></td> -->

     	 <td>
       <?
         $d_newdate = new DateTime($data->delivery_date);
         echo $d_newdate->format('j F, Y');   #d-m-Y  // March 10, 2001, 5:16 pm
         ?>
        </td>
    <td>
      <?php
      if($data->delivery_slot_id != 0 ){
        $this->db->select('*');
              $this->db->from('tbl_delivery_slots');
              $this->db->where('id',$data->delivery_slot_id);
              $slots_data= $this->db->get()->row();
              if(!empty($slots_data)){
                echo date("h:i a", strtotime($slots_data->from_time)) ?> to <?=date("h:i a", strtotime($slots_data->to_time));
              }
            else{
              echo "No slot time available";
            }
}else{
  echo "N/A";

}?>
    </td>
 	 <td><?php
if($data->order_status == 1){
  ?><span class="label label-primary" style="font-size:13px;">New Order</span><?php
}
if($data->order_status == 2){
  ?><span class="label label-success" style="font-size:13px;">Accepted</span><?php
}
if($data->order_status == 3){
  ?>
  <span class="label label-info" style="font-size:13px;">Dispatched</span>
  <?php
}
if($data->order_status == 4){
  ?><span class="label label-success" style="font-size:13px;">Delivered</span><?php
}

     ?></td>

     <td><?php
  if($data->delivery_status == 0){
    ?><span class="label label-warning" style="font-size:13px;">None</span><?php
  }
  if($data->delivery_status == 1){
    $transfered_delivery_user_id = 0;
    $this->db->select('*');
          $this->db->from('tbl_transfer_orders');
          $this->db->where('order_id',$data->id);
          $transfer_db= $this->db->get()->row();
          if(!empty($transfer_db)){
            $transfered_delivery_user_id = $transfer_db->delivery_user_id;
          }
    ?><span class="label label-primary" style="font-size:13px;">Transfered To <?php
if($transfered_delivery_user_id != 0){
  $this->db->select('*');
        $this->db->from('tbl_delivery_users');
        $this->db->where('id',$transfered_delivery_user_id);
        $delivery_user_db= $this->db->get()->row();
        if(!empty($delivery_user_db)){
          echo $delivery_user_db->name;
}else{
  echo "N/A";
}
}
    ?></span><?php
  }
  if($data->delivery_status == 2){

    $transfered_delivery_user_id = 0;
    $this->db->select('*');
          $this->db->from('tbl_transfer_orders');
          $this->db->where('order_id',$data->id);
          $this->db->where('status',1);
          $transfer_db= $this->db->get()->row();
          if(!empty($transfer_db)){
            $transfered_delivery_user_id = $transfer_db->delivery_user_id;
          }
    ?> <span class="label label-info" style="font-size:13px;">Accepted By <?php
  if($transfered_delivery_user_id != 0){
  $this->db->select('*');
        $this->db->from('tbl_delivery_users');
        $this->db->where('id',$transfered_delivery_user_id);
        $delivery_user_db= $this->db->get()->row();
        if(!empty($delivery_user_db)){
          echo $delivery_user_db->name;
  }else{
  echo "N/A";
  }
  }

    ?></span>

    <?php
  }
  if($data->delivery_status == 3){    ?>
    <span class="label label-success" style="font-size:13px;">Delivered</span>
    <?php
  }
       ?></td>
   <td>
   <?
     $newdate = new DateTime($data->last_update_date);
     echo $newdate->format('j F, Y, g:i a');   #d-m-Y  // March 10, 2001, 5:16 pm
     ?>
    </td>

 	 <td>
   <?
     $newdate = new DateTime($data->date);
     echo $newdate->format('j F, Y, g:i a');   #d-m-Y  // March 10, 2001, 5:16 pm
     ?>
    </td>

    <td>
 <?php

 $this->db->select('*');
  $this->db->from('tbl_order2');
  $this->db->where('main_id',$data->id);
  $rrts= $this->db->count_all_results();

      $this->db->select('*');
       $this->db->from('tbl_order2');
       $this->db->where('main_id',$data->id);
       $order2_dsas= $this->db->get();
       if(!empty($order2_dsas)){


// exit;
$j=1;
         foreach ($order2_dsas->result() as $order2pro) {
$d2=$order2pro->unit_id;
$d3=$order2pro->quantity;


$this->db->select('*');
            $this->db->from('tbl_units');
            $this->db->where('id',$d2);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
            $t1=$da->name;

            }
            else{
              $t1="Type not found";

            }


           $this->db->select('*');
            $this->db->from('tbl_product');
            $this->db->where('id',$order2pro->product_id);
            // $this->db->where("is_active", 1);
            $this->db->where("is_cat_delete", 0);
            $prod_dsas= $this->db->get()->row();
            if(!empty($prod_dsas)){

            // $pro_name[]=$prod_dsas->name;
               $d4=$prod_dsas->name;
            // $qty[]= $order2pro->quantity;
          }else{
            $d4="Product not found";
          }
          // $this->db->select('*');
          //  $this->db->from('tbl_units');
          //  $this->db->where('id',$order2pro->unit_id);
          //  $this->db->where("is_active", 1);
          //
          //  $units_dsas= $this->db->get()->row();
          //  if(!empty($units_dsas)){



         // }
          // $strr[]= $pro_name." ".$unit_name."x".$qty;
          echo $d4."(".$t1."x".$d3.")";
// echo $rrts;
if($j==$rrts){
$j=1;
}
else{
    echo ",";
    $j++;
}

         }
         ?>

      <?php  }
       else{
       echo "N/A";
      }
      ?>

    </td>

<td>
<?php if($data->checkout_from == 2){
  echo "Admin";
}else{
  echo "User";
} ?>

</td>

<td>
<?php if($data->cancel_order_type == 2){
  echo "Rejected By Admin";
}elseif($data->cancel_order_type == 1){
  echo "Rejected By User";
} else{
  echo "None";
} ?>

</td>



        <td>
        <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

<?php if($data->order_status == 1){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
        base64_encode($data->id) ?>/<?= base64_encode(2) ?>">Accept</a></li>
        <li><a  href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Reject</a></li>
      <?php } ?>
      <?php if($data->order_status == 2){ ?>
        <?php if($data->delivery_status == 0){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/orders/transfer_to_deliver/<?=base64_encode($data->id) ?>">Transfer Order To Delivery User</a></li>
<?php } ?>
              <li><a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
              base64_encode($data->id) ?>/<?= base64_encode(3) ?>">Dispatch Order</a></li>

              <li><a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
              base64_encode($data->id) ?>/<?= base64_encode(4) ?>">Deliver Order</a></li>
            <?php } ?>

            <?php if($data->order_status == 3){ ?>

                    <li><a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
                    base64_encode($data->id) ?>/<?= base64_encode(4) ?>">Deliver Order</a></li>
                  <?php } ?>


    <li><a href="<?php echo base_url() ?>dcadmin/orders/view_ordered_product_details/<?php echo
    base64_encode($data->id) ?>">View Products</a></li>

    <li><a href="<?php echo base_url() ?>dcadmin/orders/view_order_bill/<?php echo
  base64_encode($data->id) ?>">View Bill</a></li>

        </ul>
        </div>
        </div>

        <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure reject this order </p>
        <a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
        base64_encode($data->id) ?>/<?= base64_encode(5) ?>" class="btn btn-danger" >Yes</a>
        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
        </div>

        <!-- <div style="display:none" id="rcnfbox<?php echo $i ?>">
        <p> Are you sure reject this order?</p>
        <a href="<?php echo base_url() ?>dcadmin/orders/updateordersStatus/<?php echo
        base64_encode($data->id) ?>/<?= base64_encode(5) ?>" class="btn btn-danger" >Yes</a>
        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
        </div> -->
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


        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

          <script type="text/javascript">


          // buttons: [
          //     'copy', 'csv', 'excel', 'pdf', 'print'
          // ]
          $(document).ready(function(){
          $('#userTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                      {
                          extend: 'copyHtml5',
                          exportOptions: {
                            columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                          }
                      },
                       {
                           extend: 'csvHtml5',
                           exportOptions: {
                             columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                           }
                       },
                       {
                           extend: 'excelHtml5',
                           exportOptions: {
                             columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                           }
                       },
                       {
                           extend: 'pdfHtml5',
                           exportOptions: {
                               columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                           }
                       },
                       {
                           extend: 'print',
                           exportOptions: {
                               columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                           }
                       },

                   ]


          });

//delete order button js code
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

//reject order button js code
        // $(document.body).on('click', '.rdCnf', function() {
        // var i=$(this).attr("mydata");
        // console.log(i);
        //
        // $("#btns"+i).hide();
        // $("#rcnfbox"+i).show();
        //
        // });
        //
        // $(document.body).on('click', '.cans', function() {
        // var i=$(this).attr("mydatas");
        // console.log(i);
        //
        // $("#btns"+i).show();
        // $("#rcnfbox"+i).hide();
        // })
        //
        // });

        </script>
        <!-- <script type="text/javascript" src="<?php echo base_url()
        ?>assets/slider/ajaxupload.3.5.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script> -->
