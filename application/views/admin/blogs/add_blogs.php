<div class="content-wrapper">
               <section class="content-header">
                  <h1>
                 Add New Blogs
                 </h1>

               </section>
           <section class="content">
           <div class="row">
              <div class="col-lg-12">

                               <div class="panel panel-default">
                                   <div class="panel-heading">
                                       <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Blogs</h3>
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
                                          <form action=" <?php echo base_url()  ?>dcadmin/blogs/add_blogs_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">
 <tr>
 <td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
 <td>
<select class="form-control" name="category" required>
  <option value="" disabled selected>----select any category----</option><?php
      $this->db->select('*');
    $this->db->from('tbl_blog_categories');
    $category_data = $this->db->get();
    foreach($category_data->result() as $data) { ?>
    <option value="<?=$data->id ?>" ><?= $data->category ?></option>
<?}?>
</select>


   </td>
 </tr>
  <tr>
<td> <strong>Title</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" placeholder="Blog Title " name="title"  class="form-control" placeholder="" required value="" />  </td>
</tr>

<tr>
<td> <strong>Image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder="" required value="" />  </td>
</tr>
<tr>
<td> <strong>Short Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> 	<textarea name="short_description" class="form-control" required placeholder="Maximum Two Three lines"></textarea>  </td>
</tr>
  <tr>
<td> <strong>Content</strong>  <span style="color:red;">*</span></strong> </td>
<td>
  		<textarea id="editor1" name="content" rows="10" cols="80" required></textarea>
  </td>
</tr>




                                 <tr>
                                   <td colspan="2" >
                                  <center>   <input type="submit" class="btn btn-success" value="Save Blog"></center>
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


                 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
    <link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />


          <script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/plup/js/plupload.full.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/plup/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plup/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<script>

            // Replace the <textarea id="editor1"> with a CKEditor

            // instance, using default configuration.

            CKEDITOR.replace( 'editor1' );

        </script>
<script type="text/javascript">

$(document).ready(function(){

$("#uploader").pluploadQueue({



// General settings

runtimes : 'html5,flash,silverlight,html4',

url : base_url+'admin/home/image_uploadmutiple',

chunk_size: '1mb',

rename : true,

dragdrop: true,



filters : {

  // Maximum file size

  max_file_size : '10mb',

  // Specify what files to browse for

  mime_types: [

    {title : "Image files", extensions : "jpg,gif,png,bmp,pdf,xls,doc,docx,xlsx"}

  ]

},



// Resize images on clientside if we can

//resize : {width : 800, height : 240, quality : 90},



flash_swf_url : base_url+'assets/admin/pulp/js/Moxie.swf',

silverlight_xap_url : base_url+'assets/admin/pulp/js/Moxie.xap'

});



var uploaderqueue = $('#uploader').pluploadQueue();



    uploaderqueue.bind('FileUploaded',function(up, file, info)

    {

  if(info.length != 0)

  {

      if(info.response == "error")

      {

      alert("Oops something went wrong. Please try again");

      location.reload();

      }else

      {

      var get_data=$.parseJSON(info.response);

      console.log(get_data);



      var input = document.createElement("input");



      input.setAttribute("type", "hidden");



      input.setAttribute("name", "image[]");



      //console.log(get_data.new_name);

      input.setAttribute("value",get_data.new_name);

      $("#slide_frm").append(input);



      }

  }else

    {

    alert("Oops something went wrong. Please try again");

    }

  });

  });
  </script>
<style>
label{
margin:5px;
}
</style>
