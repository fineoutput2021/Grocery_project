<div class="content-wrapper">
  <section class="content-header">
    <h1>
      All AppSlider Images
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/AppSlider/view_appslider"><i class="fa fa-dashboard"></i> All AppSlider Images </a></li>
      <li class="active">View AppSlider images</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/AppSlider/add_appslider_images" role="button" style="margin-bottom:12px;"> Add AppSlider Images</a>
        <div class="panel panel-default">

          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View AppSlider</h3>
          </div>
          <div class="panel panel-default">
            <?
            if (!empty($this->session->flashdata('emessage'))) {
            ?>
              <div class="alert alert-danger">
                <strong>Error!</strong><? echo $this->session->flashdata('emessage'); ?>
              </div>

            <?
            }

            ?>
            <div class="panel-body">
              <div class="">
                <table class="table table-bordered table-hover table-striped" id="userTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Images Name</th>
                      <th>Images</th>
                      <!-- <th>Link</th> -->
                      <th>Date</th>
                      <!-- <th>Added_by</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($slider->result() as $data) { ?>
                      <tr>
                        <td><?php echo $i ?> </td>
                        <td><?php echo $data->image_name; ?> </td>



                        <td>
                          <?php if ($data->image != "") {  ?>
                            <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . "assets/admin/all_img/app_slider_images/" . $data->image ?>">
                          <?php } else {  ?>
                            Sorry No image Found
                          <?php } ?>
                        </td>




                        <!-- <td><?php //echo $data->link; ?> </td> -->
                        <td>

                         <?php $newdate = new DateTime($data->date);
                              echo $newdate->format('j F, Y, g:i a'); ?>
                              
                        </td>



                        <td><?php if ($data->is_active == 1) { ?>
                            <p class="label pull-right bg-green">Active</p>

                          <?php } else { ?>
                            <p class="label pull-right bg-yellow">Inactive</p>


                          <?php   }   ?>
                        </td>
                        <td>
                          <div class="btn-group" id="btns<?php echo $i ?>">
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu">

                                <?php if ($data->is_active == 1) { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/AppSlider/updateappsliderStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li>
                                <?php } else { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/AppSlider/updateappsliderStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li>
                                <?php   }   ?>
                                <li><a href="<?php echo base_url() ?>dcadmin/AppSlider/edit_appslider_images/<?php echo base64_encode($data->id) ?>" >Edit</a></li>
                                <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete AppSlider</a></li>
                              </ul>
                            </div>
                          </div>

                          <div style="display:none" id="cnfbox<?php echo $i ?>">
                            <p> Are you sure delete this </p>
                            <a href="<?php echo base_url() ?>dcadmin/AppSlider/delete_appslider_all/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
                            <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>">No</a>
                          </div>
                        </td>
                      </tr>
                    <?php $i++;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>
</div>


<style>
  label {
    margin: 5px;
  }
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable({
      responsive: true,
      // bSort: true
    });

    $(document.body).on('click', '.dCnf', function() {
      var i = $(this).attr("mydata");
      console.log(i);

      $("#btns" + i).hide();
      $("#cnfbox" + i).show();

    });

    $(document.body).on('click', '.cans', function() {
      var i = $(this).attr("mydatas");
      console.log(i);

      $("#btns" + i).show();
      $("#cnfbox" + i).hide();
    })

  });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>    -->
