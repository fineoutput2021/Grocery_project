<div class="content-wrapper">
<section class="content-header">
<h1>
Add New Slider Images
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/home/add_slider_images"><i class="fa fa-dashboard"></i> All Slider Images </a></li>

</ol>
</section>
<input type="hidden" value="<?= base_url()?>" id="app_base_url_values">
<section class="content">
<div class="row">
<div class="col-lg-12">
<a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/home/view_slider" role="button" style="margin-bottom:12px;">Back</a>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Images</h3>
</div>
<div class="panel-body">
<div class="col-lg-10">


<?
if (!empty($this->session->flashdata('emessage'))) {
?>
<div class="alert alert-danger">
<strong>Error!</strong><? echo $this->session->flashdata('emessage'); ?>
</div>

<?
}

?>

<form action="<?php echo base_url() ?>dcadmin/home/add_slider_images_all/<?php echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">
<div class="form-group">
<tr>
<td> <strong>Image Name</strong> </td>
<td>


  <input type="text" name="image_name" class="form-control" required=""></input>

</div>
</td>
</tr>

<tr>
<td> <strong>Category</strong> </td>
<td>

<select class="form-control"  name="category" id="category" required >
  <?php
            $this->db->select('*');
$this->db->from('tbl_category');
$categories= $this->db->get();

if(!empty($categories)){
  foreach ($categories->result() as $cate) {

  ?>

  <option value="<?=$cate->id;?>"> <?=$cate->name;?> </option>

  <?php
 }
}
  ?>
 </select>

</div>
</td>
</tr>


<tr>
<td> <strong>SubCategory</strong> </td>
<td>

<select class="form-control"  name="subcategory" id="subcategory" required >
  <?php
            $this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('is_active',1);
$this->db->where('is_cat_delete',0);
$subcategories= $this->db->get();

if(!empty($subcategories)){
  foreach ($subcategories->result() as $subcate) {

  ?>

  <option value="<?=$subcate->id;?>"> <?=$subcate->name;?> </option>

  <?php
 }
}
  ?>
 </select>

</div>
</td>
</tr>


<tr>
<td> <strong>Link</strong> </td>
<td>

<input type="text" placeholder="Start url with http or https" name="link" class="form-control" ></input>

</div>
</td>
</tr>
<tr>
<td> <strong>Image ( Suitable image size : 1200x630 pixels )</strong> </td>
<td>


<input type="file" name="fileToUpload1"></input>

</div>
</td>
</tr>
<tr>
<td> <strong>Device Type</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control"  name="device_type" required > <option value="1"> Phone </option><option value="2"> Desktop </option> <option value="3"> Both </option>< </select>  </td>


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
