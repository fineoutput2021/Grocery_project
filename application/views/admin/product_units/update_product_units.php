<div class="content-wrapper">
<section class="content-header">
   <h1>
  Update Product Type
  </h1>

</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Product Type </h3>
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
                           <form action=" <?php echo base_url(); ?>dcadmin/product_units/add_product_units_data/<? echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <input type="hidden" name="product_id" value="<?= $product_units_data->product_id ?>" required>

<!-- <tr>
<td> <strong>Select Type</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="unit_id" readonly class="form-control" placeholder="" required value="<?=$product_units_data->unit_id;?>" />
</td>
</tr> -->
<tr>
<td> <strong>Type</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="unit_id" class="form-control" placeholder="" required value="<?=$product_units_data->unit_id;?>" />  </td>
</tr>
<?php
$pro_unit_type = 0;
$this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('id',$product_units_data->product_id);
      $product_data= $this->db->get()->row();
      if(!empty($product_data)){
        $pro_unit_type = $product_data->product_unit_type;
      }

 if($pro_unit_type == 1){?>
  <tr>
<td> <strong>Unit Ratio (ex. 0.5 for 500 gram / 1 for 1 kg )</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="number" name="ratio" step="any" min="0" class="form-control" placeholder="" required value="<?=$product_units_data->ratio;?>"  />  </td>
</tr>
<?}else{ ?>
<input type="hidden" name="ratio"  value="0" />
<?php } ?>
<tr>
<td> <strong>MRP</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="mrp"  class="form-control" placeholder="" required value="<?=$product_units_data->mrp;?>" />  </td>
</tr>
<tr>
<td> <strong>Selling Price</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" id="selling_price" name="selling_price"  class="form-control" placeholder="" required value="<?=$product_units_data->without_selling_price;?>" />  </td>
</tr>
<tr>
<td> <strong>GST Percentage</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" id="gst_percentage" name="gst_percentage"  class="form-control" placeholder="" required value="<?=$product_units_data->gst_percentage;?>" />  </td>
</tr>
<tr>
<td> <strong>GST Amount</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" id="gst_amount" name="gst_amount"  class="form-control" placeholder="" required value="<?=$product_units_data->gst_amount;?>" />  </td>
</tr>
<tr>
<td> <strong>Total Amount</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" id="total_amount" name="total_amount"  class="form-control" placeholder="" required value="<?=$product_units_data->selling_price;?>" />  </td>
</tr>



<tr>
<td> <strong>Image 1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image1"  class="form-control" placeholder=""  />
<?php if($product_units_data->image1!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url('assets/admin/product_units/').$product_units_data->image1; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image2"  class="form-control" placeholder=""  />
<?php if($product_units_data->image2!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url('assets/admin/product_units/').$product_units_data->image2; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 3</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image3"  class="form-control" placeholder=""  />
<?php if($product_units_data->image3!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url('assets/admin/product_units/').$product_units_data->image3; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image4"  class="form-control" placeholder=""  />
<?php if($product_units_data->image4!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url('assets/admin/product_units/').$product_units_data->image4; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
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
  <script>
  $(document).ready(function(){
$("#gst_percentage").keyup(function(){

var bla = $('#selling_price').val();
// var bla2 = $('#gst_amount').val();
var bla2 = $('#gst_percentage').val();

var per = bla*bla2/100;
var gstper = per.toFixed(2);


var bla3 = parseFloat(bla) + parseFloat(per);
// alert(bla);
// alert(per);
// alert(bla3);
 var bla4= Math.round(bla3);
// console.log(bla);
// console.log(bla2);
// console.log(bla3);


$('#gst_amount').val(gstper);
$('#total_amount').val(bla4);



});
});

  </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>



<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
