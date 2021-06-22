<div class="content-wrapper">
<section class="content-header">
   <h1>
  Update Product
  </h1>

</section>
<input type="hidden" value="<?= base_url()?>" id="app_base_url_values">
<section class="content">
<div class="row">
<div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Product </h3>
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
                           <form action=" <?php echo base_url(); ?>dcadmin/product/add_product_data/<? echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-hover">
<tr>
<td> <strong>Product Name</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="name"  class="form-control" placeholder="" required value="<?=$product_data->name;?>" />  </td>
</tr>
<tr>
<td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="category_id" class="form-control" id="category" required >
  <?php
   foreach($category_data->result() as $cat_data) {
  ?>
   <option value="<?= $cat_data->id ?>" <?php if($product_data->category_id == $cat_data->id){ echo "selected"; } ?>> <?= $cat_data->name ?> </option>
   <?php
 } ?>
 </select>  </td>

</tr>

<tr>
<td> <strong>SubCategory</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select name="subcategory_id" class="form-control" id="subcategory" required >
  <?php
  $this->db->select('*');
   $this->db->from('tbl_subcategory');
   $this->db->where('is_cat_delete',0);
   $this->db->where('category_id', $product_data->category_id);
   $this->db->where('is_active', 1);
$subcategory_data= $this->db->get();

  if(!empty($subcategory_data)){
   foreach($subcategory_data->result() as $subcat_data) {
  ?>
   <option value="<?= $subcat_data->id ?>" <?php if($product_data->subcategory_id == $subcat_data->id){ echo "selected"; } ?>> <?= $subcat_data->name ?> </option>
   <?php
 } }?>
 </select>  </td>

</tr>

<tr>
<td> <strong>Short Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="short_description"  class="form-control" placeholder="" required value="<?=$product_data->short_description;?>" />  </td>
</tr>
<tr>
<td> <strong>Long Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="long_description"  class="form-control" placeholder="" required value="<?=$product_data->long_description;?>" />  </td>
</tr>

<tr>
<td> <strong>Image 1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image1"  class="form-control" placeholder=""  />
<?php if($product_data->image1!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->image1; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image2"  class="form-control" placeholder=""  />
<?php if($product_data->image2!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->image2; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 3</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image3"  class="form-control" placeholder=""  />
<?php if($product_data->image3!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->image3; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Image 4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image4"  class="form-control" placeholder=""  />
<?php if($product_data->image4!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->image4; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>


<tr>
<td> <strong>App Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage"  class="form-control" placeholder=""  />
<?php if($product_data->app_pro_image!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_pro_image; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>


<tr>
<td> <strong>App Main Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appmainimage"  class="form-control" placeholder=""  />
<?php if($product_data->app_main_image!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_main_image; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>   </td>
</tr>

<tr>
<td> <strong>App Image1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage1"  class="form-control" placeholder=""   />
  <?php if($product_data->app_image1!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_image1; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>

<tr>
<td> <strong>App Image2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage2"  class="form-control" placeholder=""  />
<?php if($product_data->app_image2!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_image2; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>   </td>
</tr>

<tr>
<td> <strong>App Image3</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage3"  class="form-control" placeholder=""  />
<?php if($product_data->app_image3!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_image3; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>    </td>
</tr>

<tr>
<td> <strong>App Image4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="appimage4"  class="form-control" placeholder=""  />
<?php if($product_data->app_image4!=""){ ?><img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$product_data->app_image4; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>   </td>
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

    // alert("u");category subcategory
    $("#subcategory").html("");
    var selectedcategory = $("#category").val();

    var base_url = $("#app_base_url_values").val();
// alert(base_url);
// alert(selectedcategory);
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
    var options;
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


<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
