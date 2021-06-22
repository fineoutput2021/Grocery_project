<div class="content-wrapper">
<section class="content-header">
<h1>
Update Sub-category
</h1>

</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update </h3>
    </div>

     <? if(!empty($this->session->flashdata('smessage'))){ ?>
           <div class="alert alert-success alert-dismissible">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       <h4><i class="icon fa fa-check"></i> Alert!</h4>
     <? echo $this->session->flashdata('smessage'); ?>
     </div>
       <? }
        if(!empty($this->session->flashdata('emessage'))){ ?>
        <div class="alert alert-danger alert-dismissible">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <? echo $this->session->flashdata('emessage'); ?>
    </div>
     <? } ?>


    <div class="panel-body">
        <div class="col-lg-10">


           <form action="<?php echo base_url() ?>dcadmin/Sub_category/add_subcategory_data/<? echo base64_encode(2); ?>/<?php echo base64_encode($subcategory_data->id) ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
        <div class="table-responsive">
            <table class="table table-hover">
              <tr>
                                      <td> <strong>Name</strong>  <span style="color:red;">*</span></strong> </td>
                                      <td>
              <input type="text" name="name"  class="form-control" placeholder="" required value="<?php echo $subcategory_data->name; ?>" />
                                 </td>
              </tr>
              <tr>
              <td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
              <td> <select name="category_id" class="form-control" id="category" required >
                <?php
                 foreach($category_data->result() as $cat_data) {
                ?>
                 <option value="<?= $cat_data->id ?>" <?php if($subcategory_data->category_id == $cat_data->id){ echo "selected"; } ?>> <?= $cat_data->name ?> </option>
                 <?php
               } ?>
               </select>  </td>

              </tr>







          <tr>
<td> <strong>Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder=""  />
<?php if($subcategory_data->image!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$subcategory_data->image; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
              </tr>

  <tr>
  <td> <strong>SubText1</strong>  <span style="color:red;">*</span></strong> </td>
  <td> <input type="text" name="subtext1"  class="form-control" placeholder="" value="<?=$subcategory_data->subtext1;?>"  />  </td>
  </tr>

<tr>
<td colspan="2" >
<input type="submit" class="btn btn-success" value="Update">
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


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
