<div class="content-wrapper">
               <section class="content-header">
                  <h1>
                 Add New Sub-Category
                 </h1>

               </section>

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
                                          <form action=" <?php echo base_url()  ?>dcadmin/Sub_category/add_subcategory_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">
  <tr>
<td> <strong>Name</strong>  <span style="color:red;">*</span></strong> </td>
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
<td> <strong>Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder="" required />  </td>
</tr>

<tr>
<td> <strong>SubText1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="subtext1"  class="form-control" placeholder="" required />  </td>
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
