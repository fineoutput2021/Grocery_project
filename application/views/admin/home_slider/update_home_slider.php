<div class="content-wrapper">
<section class="content-header">
   <h1>
  Update Home_slider
  </h1>

</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Home_slider </h3>
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
                           <form action=" <?php echo base_url(); ?>dcadmin/home_slider/add_home_slider_data/<? echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-hover">
<tr>
<td> <strong>Image Name</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="image_name"  class="form-control" placeholder=""  value="<?=$home_slider_data->image_name;?>" />  </td>
</tr>
<tr>
<td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
<td><select class="form-control" name="category" id="category">
  <option value="">Select Category</option>
  <?php
  $this->db->select('*');
$this->db->from('tbl_category');
//$this->db->where('',);
$category= $this->db->get();
   $i=1; foreach($category->result() as $data) { ?>
    <option value="<?=$data->id?>"><?=$data->name?></option>
    <?php $i++; } ?>
</select>
</tr>
<tr>
<td> <strong>Sub-Category</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" name="sub_category" id="sub_category">
  <option value="">Select Sub Category</option>

</select>

</tr>
<tr>
<td> <strong>Link</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="link"  class="form-control" placeholder=""  value="<?=$home_slider_data->link;?>" />  </td>
</tr>
<tr>
<td> <strong>Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder="" />
<?php if($home_slider_data->image!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$home_slider_data->image; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Device Type</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" name="device"  > <option value="1" <? if($home_slider_data->device==1){ echo "selected"; } ?>> Phone </option><option value="2" <? if($home_slider_data->device==2){ echo "selected"; } ?>> Desktop </option><option value="3" <? if($home_slider_data->device==3){ echo "selected"; } ?>> Both </option> </select>  </td>
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
<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />


<script>

 $(document).ready(function(){
  	$("#category").change(function(){
		var vf=$(this).val();
    // var yr = $("#year_id option:selected").val();
		if(vf==""){
			return false;

		}else{
			$('#sub_category option').remove();
			  var opton="<option value=''>Please Select </option>";
			$.ajax({
				url:base_url+"dcadmin/Home_slider/getSub_category?isl="+vf,
				data : '',
				type: "get",
				success : function(html){
						if(html!="NA")
						{
							var s = jQuery.parseJSON(html);
							$.each(s, function(i) {
							opton +='<option value="'+s[i]['id']+'">'+s[i]['name']+'</option>';
							});
							$('#sub_category').append(opton);
							//$('#city').append("<option value=''>Please Select State</option>");

                      //var json = $.parseJSON(html);
                      //var ayy = json[0].name;
                      //var ayys = json[0].pincode;
						}
						else
						{
							alert('No Sub Category Found');
							return false;
						}

					}

				})
		}


	})
  });



</script>
