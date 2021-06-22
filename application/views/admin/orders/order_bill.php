<!DOCTYPE html>
<html>
<html lang="en">
<input type="hidden" value="<?php if(!empty($order1_data)){ echo $order1_data->total_amount; }?>" id="tot_amnt">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- Css file include -->
<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Aubasket Bill</title>
</head>
<body style="padding-top:75px;">
<div class="container main_container">
	<div class="row">
		<div class="col-sm-6 oswal_logo">
		<img src="<?=base_url()?>assets/frontend/assets/images/icon/aulogo.png" class="img-fluid" style="width:90px;">
		</div>
		<div class="col-sm-6 content_part">Tax Invoice/Bill of Supply/Cash Memo
			<p>(Original for Recipient)</p>
		</div>
	</div><br>

<div class="container">
	<div class="row">
		<div class="col-sm-6">Sold By<br>
<span class="seller_details">Aubasket<br>

 Anjali Chamber, Ajmer Road, Jaipur, Rajasthan 302-006
<br>
			+91-97830 99666<br>
		www.aubasket.com<br></span>
		</div>

		<div class="col-sm-6 billing_content">Billing Address:<br>
      <!-- code here -->
      Address:
      <?php
  if(!empty($order1_data)){
                $this->db->select('*');
    $this->db->from('tbl_user_address');
    $this->db->where('id',$order1_data->address_id);
    $address= $this->db->get()->row();
    if(!empty($address)){
     $addres= $address->address;
     $location_addres= $address->location_address;
     $doorflat= $address->doorflat;
     $landmark= $address->landmark;
     $zipcode=$address->zipcode;
   }else{
     $addres= "";
     $location_addres= "";
     $doorflat= "";
     $landmark= "";
     $zipcode="";
   }
    if(empty($location_addres)){
      echo $addres;
    }else{
      echo $doorflat.", ".$landmark.", ".$location_addres;
    }
    // $state=$address->state;
    // $city=$address->city;


if(!empty($address)){
  if(!empty($address->state) && $address->state != null){
     $state= $address->state;
   }else{ $state= ""; }


   if(!empty($address->city) && $address->city != null){
      $city= $address->city;
    }else{ $city= ""; }
}else{
  $state= "";
  $city= "";
}



  }
      ?>
    <br>State/UT Code : RJ14<br>
    Place of supply: <?php echo $city;?><br>
    Place of delivery: <?php echo $city.", ".$state;?><br>
    Zipcode: <?php echo $zipcode;?><br>
		</div>
	</div>

<br><div class="row" style="margin-left: 0px;">PAN NO: AACCO9549F <br>
GST REGISTRATION NO : 08AACCO9549F1Z4 <br>
</div>
<div class="row">
	<div class="col-sm-6"></div>
<div class="col-sm-6 shipping_content">	Shipping Address:<br>

Address: <?php
if(empty($location_addres)){
  echo $addres;
}else{
  echo $doorflat.", ".$landmark.", ".$location_addres;
}
?> <br>

State/UT Code : RJ14<br>
Place of supply: <?php echo $city;?><br>
Place of delivery: <?php echo $city.", ".$state;?><br>
Zipcode: <?php echo $zipcode;?><br>
</div>
</div>
<div class="row">
	<div class="col-sm-6">Order No: &nbsp; <?php if(!empty($order1_data)){ echo $order1_data->id; }?><br>
<p> Order Date:  &nbsp;
   <?php if(!empty($order1_data)){
  $source = $order1_data->last_update_date;
     $date = new DateTime($source);
     echo $date->format('F j, Y, g:i a');
  }?>
	</div><br> <br>
	<div class="col-sm-6 invoice_content">Invoice No: OSWAL-RJ-450<br>

	</div>

</div>
</div>





<div class="container">

  <table class="table table-black">
    <thead class="product_table">

      <tr>
        <th>SI No.</th>
        <th>Product</th>
        <th>Unit Name</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Net Amount</th>
        <th>Tax Rate</th>
        <th>Tax Type</th>
        <th>Tax Amount</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
  <?php
if(!empty($order2_data)){
  $i=1; foreach($order2_data->result() as $data) { ?>
      <tr class="product_table2">
       <td><?php echo $i;?></td>
        <td><?php
        $this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',$data->product_id);
$product_data= $this->db->get()->row();
if(!empty($product_data)){
echo $product_name= $product_data->name;
}

        ?></td>
        <td> <?php


        $this->db->select('*');
        $this->db->from('tbl_units');
        $this->db->where('id',$data->unit_id);
        $type_data= $this->db->get()->row();
        if(!empty($type_data)){
        echo $type_name= $type_data->name;

        $this->db->select('*');
        $this->db->from('tbl_product_units');
        $this->db->where('unit_id',$data->unit_id);
        $this->db->where('product_id',$data->product_id);
        $type_gst_data= $this->db->get()->row();
        if(!empty($type_gst_data)){

         $type_mrp= $type_gst_data->mrp;
         $type_gst_percentagess= $type_gst_data->gst_percentage;
         if($type_gst_percentagess != "" && $type_gst_percentagess != null){
            $type_gst_percentage= $type_gst_data->gst_percentage;
         }else{
           $type_gst_percentage= 0;
         }

         $type_gst_percentage_pricess= $type_gst_data->gst_amount;
         if($type_gst_percentage_pricess != "" && $type_gst_percentage_pricess != null){
            $type_gst_percentage_price= $type_gst_data->gst_amount;
         }else{
           $type_gst_percentage_price= 0;
         }

         $type_gst_selling_pricess= $type_gst_data->without_selling_price;
         if($type_gst_selling_pricess != "" && $type_gst_selling_pricess != null){
            $type_gst_selling_price= $type_gst_data->without_selling_price;
         }else{
           $type_gst_selling_price= 0;
         }

         $type_with_gst_selling_pricess= $type_gst_data->selling_price;
         if($type_gst_selling_pricess != "" && $type_gst_selling_pricess != null){
            $type_with_gst_selling_price= $type_gst_data->selling_price;
         }else{
           $type_with_gst_selling_price= 0;
         }

       }else{
         $type_mrp= 0;
         $type_gst_percentage= 0;
         $type_gst_percentage_price= 0;
         $type_gst_selling_price= 0;
         $type_with_gst_selling_price= 0;
       }

        }
        else{
        echo  $type_name= "";
           $type_mrp= "";
        }


        ?></td>
        <td ><?php echo "Rs. ".$type_gst_selling_price;?></td>
        <td ><?php echo $data->quantity;?></td>
        <td ><?php echo "Rs. ".$net_unit_mrp=$type_gst_selling_price * $data->quantity ;?></td>
        <!-- <td>9%</td>
        <td>CGST</td>
        <td>200</td> -->
        <?php
        $this->db->select('*');
         $this->db->from('tbl_user_address');
         $this->db->where('id',$order1_data->address_id);
         $deliver_state= $this->db->get()->row();


        ?>

        <?php
if(!empty($deliver_state)){
        if($deliver_state->state == "Rajasthan"){?>


    <td><span> <?php  $half= $type_gst_percentage/2; echo $half."%"; ?>  </span> <br> <span>   <?php  $half= $type_gst_percentage/2; echo $half."%"; ?> </span></td>

      <?php }else{?>
    <td><?php echo $type_gst_percentage."%";?></td>
      <?php }
    }else {?>
      <td><?php echo "0%";?></td>
  <?php   }?>

        <?php
if(!empty($deliver_state)){
        if($deliver_state->state == "Rajasthan"){?>

          <td><span> CGST  </span> <br> <span>  SGST </span></td>
      <?php }else{?>
        <td>IGST</td>
      <?php }
    }else{?>
      <td>IGST</td>
    <?php   }?>


      <?php
if(!empty($deliver_state)){
       if($deliver_state->state == "Rajasthan"){?>


      <td>
    <span> <?php  $total_gst_amount=$type_gst_percentage_price * $data->quantity;
      $half_P= $total_gst_amount/2; echo "Rs. ".$half_P;?>
    </span>
      <br>
       <span> <?php  $total_gst_amount=$type_gst_percentage_price * $data->quantity;
      $half_P= $total_gst_amount/2; echo "Rs. ".$half_P;?>
     </span>
   </td>
    <?php }else{?>

    <td><?php echo "Rs. ".$total_gst_amount=$type_gst_percentage_price * $data->quantity;?></td>

    <?php }
}else{ ?>
    <td> <?php echo "Rs. 0";?> </td>
  <?php   }?>

        <td><?php echo "Rs. ".$data->amount;?></td>
      </tr>
  <?php $i++;} }?>




      <tr>
        <th colspan="8">Delevery Charge</th>
        <th class="product_table"><?php if(!empty($order1_data)){ echo " "; }?></th>
        <th class="product_table"><?php if(!empty($order1_data)){ echo "Rs. ".$order1_data->delivery_charge; }?></th>

      </tr>

<?php

if(!empty($order1_data->discount)){

$promo_discount= $order1_data->discount;
}else{
  $promo_discount= 0;
}

?>

<tr>
  <th colspan="8">Discount</th>
  <th class="product_table"><?php if(!empty($order1_data)){ echo " "; }?></th>
  <th class="product_table"><?php if(!empty($order1_data)){ echo "- Rs. ".$promo_discount; }?></th>

</tr>


      <tr>
        <th colspan="8">SubTotal</th>
        <th class="product_table"><?php if(!empty($order1_data)){ echo " "; }?></th>
        <th class="product_table"><?php if(!empty($order1_data)){ echo "Rs. ".$order1_data->total_amount; }?></th>

      </tr>



    </tbody>
    </table>

      <h6 class="amount_content" >Amount in Words:<br>
      <span id="checks123" style="text-transform: capitalize;font-style: revert;"></span></h6><br>




      <h4 class="oswal_head">Aubasket:<br><br>

      Authorized Signatory </h4>

      </tr>

</div>


<h5 class="warning" style="margin-left: 15px;">Whether tax is payable under reverse charge-No</h5>


</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
 //alert('Changed!')

       $('#gst_percentage').keyup(function() {
       // alert("Key up detected");

       var total_price = $("#mrp").val();
       //var gst_percentage = $("#gst_percentage").val();$(this).val
       var gst_percentage = $(this).val();
       var gst_price = (total_price*gst_percentage)/100;
       var total_gst_price = parseInt(total_price) + parseInt(gst_price);
       //alert(total_gst_price);
       $('#gst_percentage_price').val(gst_price);
       $('#selling_price').val(total_gst_price);

     });

 </script>

<script>

window.onload = function() {

  var unit_mrp = $(".unit_mrp").text();
  var unit_qty = $(".qty").text();
  //var gst_percentage = $("#gst_percentage").val();$(this).val

  var total_unit_mrp = parseInt(unit_mrp) * parseInt(unit_qty);
  //alert(total_gst_price);
  $('.net_unit_mrp').text(total_unit_mrp);

  var total_amount= document.getElementById("tot_amnt").value;
  //alert(total_amount);
  inWords(total_amount);
  window.print();
};



var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    //return str;
    // alert(str);
    $("#checks123").text(str);

}
</script>

</html>
