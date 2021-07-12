<div class="content-wrapper">
               <section class="content-header">
                  <h1>
                 Add New Product
                 </h1>

               </section>
<input type="hidden" value="<?= base_url()?>" id="app_base_url_values">
           <section class="content">
           <div class="row">
              <div class="col-lg-12">

                               <div class="panel panel-default">
                                   <div class="panel-heading">
                                       <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Product</h3>
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
                                          <form action=" <?php echo base_url()  ?>dcadmin/product/add_product_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">
  <tr>
<td> <strong>Product Name</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="name"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="category_id" class="form-control" id="category" required >
  <option value="" disabled selected>--select category--</option>
  <?php
   foreach($category_data->result() as $cat_data) {
  ?>
   <option value="<?=$cat_data->id;?>"> <?=$cat_data->name; ?> </option>
   <?php
 } ?>
 </select>  </td>
</tr>

<tr>
<td> <strong>SubCategory</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="subcategory_id" class="form-control" id="subcategory" required >
<option value="" disabled selected>--select subcategory--</option>
<!-- <?php
 foreach($subcategory_data->result() as $subcat_data) {
?>
 <option value="<?=$subcat_data->id; ?>"> <?=$subcat_data->name; ?> </option>
 <?php
} ?> -->
</select>  </td>
</tr>
<tr>
<td> <strong>SubCategory2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="subcategory2_id" class="form-control" id="subcategory2"  >
<option value="" disabled selected>--select subcategory--</option>
<!-- <?php
 foreach($subcategory_data->result() as $subcat_data) {
?>
 <option value="<?=$subcat_data->id; ?>"> <?=$subcat_data->name; ?> </option>
 <?php
} ?> -->
</select>  </td>
</tr>

  <tr>
<td> <strong>Short Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="short_description"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Long Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="long_description"  class="form-control" placeholder="" required value="" />  </td>
</tr>


  <tr>
<td> <strong>Image 1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image1"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Image 2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image2"  class="form-control" placeholder=""  required value="" />  </td>
</tr>
  <tr>
<td> <strong>Image 3</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image3"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>Image 4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image4"  class="form-control" placeholder=""  value="" />  </td>
</tr>

<tr>
<td> <strong>App Home Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage"  class="form-control" placeholder="" required />  </td>
</tr>

<tr>
<td> <strong>App Main Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appmainimage"  class="form-control" placeholder="" required />  </td>
</tr>

<tr>
<td> <strong>App Image1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage1"  class="form-control" placeholder="" required />  </td>
</tr>

<tr>
<td> <strong>App Image2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage2"  class="form-control" placeholder="" required />  </td>
</tr>

<tr>
<td> <strong>App Image3</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage3"  class="form-control" placeholder=""  />  </td>
</tr>

<tr>
<td> <strong>App Image4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage4"  class="form-control" placeholder=""  />  </td>
</tr>

  <!-- <tr>
<td> <strong>Product Unit Type</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="product_unit_type" class="form-control" required >
  <option value="" disabled selected>--select product unit type--</option>
  <option value="1">Vegetables / Fruits</option>
  <option value="2">Grocery items</option>

 </select>  </td>
</tr> -->


<tr>
<td> <strong>Expire Date</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="date" name="expire_date"  class="form-control" placeholder=""  value="" />  </td>
</tr>

<tr>
<td> <strong>Discount Tag</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="discount_tag"  class="form-control" placeholder=""  value="" />  </td>
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


  <script>

    $(document).on('change', '#category', function() {
    // Does some stuff and logs the event to the console

    // alert("u");
    $("#subcategory").html("");
    var selectedcategory = $("#category").val();

    var base_url = $("#app_base_url_values").val();
// alert(base_url);
// alert(selectedcategory);
var options="<option value=''>Please Select </option>";
$("#subcategory").append(options);

    $.ajax({
    url:base_url+'dcadmin/Sliders2/get_subcateg_data',
    method: 'post',
    data: {category_id: selectedcategory},
    dataType: 'json',
    success: function(response){
// alert(response);
// console.log(response);
    if(response.data == true){
// alert(response);
    var subcategory_d= response.subcategorylist;
    // alert(subcategory_d);
    // var options;
    $.each(subcategory_d, function(i, item) {
    options= '<option value="'+item.id+'">'+item.name+'</option>';

    $("#subcategory").append(options);
    });


    }
    else{
    alert('hiii');
    }
    }
    });


    });
 </script>

 <script>
$(document).ready(function(){
  	$("#subcategory").change(function(){
		var vf=$(this).val();
    //var yr = $("#year_id option:selected").val();
		if(vf==""){
			return false;

		}else{
			$('#subcategory2 option').remove();
			  var opton="<option value=''>Please Select </option>";
			$.ajax({
				url:base_url+"dcadmin/Sliders2/get_subcateg2_data?isl="+vf,
				data : '',
				type: "get",
				success : function(html){
          // alert(html);
						if(html!="NA")
						{
							var s = jQuery.parseJSON(html);
							$.each(s, function(i) {
							opton +='<option value="'+s[i]['id']+'">'+s[i]['name']+'</option>';
							});
							$('#subcategory2').append(opton);
							//$('#city').append("<option value=''>Please Select State</option>");

                      //var json = $.parseJSON(html);
                      //var ayy = json[0].name;
                      //var ayys = json[0].pincode;
						}
						else
						{
							alert('No SubCategory2 Found');
							return false;
						}

					}

				})
		}


	})
  });

</script>
     <link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
