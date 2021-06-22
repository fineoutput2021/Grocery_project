<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New AppSlider Images
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/AppSlider/add_appslider_images"><i class="fa fa-dashboard"></i> All AppSlider Images </a></li>

    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/AppSlider/view_appslider" role="button" style="margin-bottom:12px;">Back</a>
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

              <form action="<?php echo base_url() ?>dcadmin/AppSlider/add_appslider_images_all/<?php echo base64_encode(2);?>/<?=$idd ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <div class="form-group">
                      <tr>
                        <td> <strong>Image Name</strong> </td>
                        <td>

                          <input type="text" name="image_name" class="form-control" value="<?php echo $edit_slider_images->image_name; ?>" required="">
                          <!-- <input type="text" name="image_name" class="form-control" value=<?=$edit_slider_images->image_name ?> required=""></input> -->

                    </div>
                    </td>
                    </tr>




                    <!-- <tr>
                      <td> <strong>Link</strong> </td>
                      <td>

                        <input type="text" placeholder="Start url with http or https" value=<?=//$edit_slider_images->link ?> name="link" class="form-control" required=""></input>

                    </div>
                    </td>
                    </tr> -->
                    <tr>
                      <td> <strong>Image</strong> </td>
                      <td>


                        <input type="file" name="fileToUpload1"></input>
                        <img height="200" width="300" src="<?php echo base_url() . "assets/admin/all_img/app_slider_images/" . $edit_slider_images->image ?>">
                </div>
                </td>
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
