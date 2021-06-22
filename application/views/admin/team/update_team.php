<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Edit Team Member
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/system/update_team/<?= $id; ?>"><i class="fa fa-dashboard"></i> Edit Team Member </a></li>

          </ol>
        </section><section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Edit Team</h3>
          </div>
          <div class="panel-body">
            <? if (!empty($this->session->flashdata('smessage'))) { ?>
              <div class="alert alert-success alert-dismissible fade in">
                <strong><? echo $this->session->flashdata('smessage'); ?></strong>
              </div>
            <? }
            if (!empty($this->session->flashdata('emessage'))) { ?>
              <div class="alert alert-danger alert-dismissible fade in">
                <strong><? echo $this->session->flashdata('emessage'); ?></strong>
              </div>
            <? } ?>
            <div class="col-lg-10">
              <form action="<?php echo base_url() ?>dcadmin/system/update_team_data/<?= $id; ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">

                    <tr>
                      <td> <strong>Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name" class="form-control" placeholder="" required value="<?= $team->name; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Email</strong> <span style="color:red;">*</span></strong> </td>
                      <td>

                        <input type="email" name="email" class="form-control" placeholder="" required value="<?= $team->email; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Change Password</strong> </strong> </td>
                      <td>

                        <input type="password" name="password" class="form-control" placeholder="">
                      </td>
                    </tr>
                  </tr>
                    <tr>
                      <td> <strong>Phone (optional)</strong> </strong> </td>
                      <td>

                        <input type="text" name="phone" class="form-control" placeholder="" value="<?= $team->phone; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Address (optional)</strong> </strong> </td>
                      <td>

                        <input type="text" name="address" class="form-control" placeholder="" value="<?= $team->address; ?>" />
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Permission Level</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <div class="form-group">

                          <select class="form-control" name="power" required>
                            <option value="0" <? if ($team->power == 0) {
                                                echo "selected";
                                              } ?>>Please select Type</option>
                            <option value="1" <? if ($team->power == 1) {
                                                echo "selected";
                                              } ?>>Super Admin</option>
                            <option value="2" <? if ($team->power == 2) {
                                                echo "selected";
                                              } ?>>Admin</option>
                            <option value="3" <? if ($team->power == 3) {
                                                echo "selected";
                                              } ?>>Manager</option>

                          </select>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>services</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <div class="form-group">
                          <div class="checkbox">
                            <label><input type="checkbox" name="service" value="999" <? if ($team->services == '["999"]') {
                                                                                        echo "checked";
                                                                                      } ?>>All</label>
                          </div>
                          <? foreach ($side->result() as $s) {
                          ?>
                            <div class="checkbox">
                              <label><input type="checkbox" name="services[]" value="<? echo $s1 = $s->id; ?>" <? $ser = json_decode($team->services);
                                                                                                              if (in_array($s1, $ser)) {
                                                                                                                echo "checked";
                                                                                                              }
                                                                                                              ?>><? echo $s->name; ?></label>
                            </div>
                          <?
                          } ?>

                        </div>
                      </td>
                    </tr>


                    <tr>
                      <td> <strong>Image</strong> </td>
                      <td>


                        <input type="file" name="fileToUpload1"></input>

                        <?php if ($team->image != "") {  ?>
                          <img id="slide_img_path" height=200 width=300 src="<?php echo base_url() . "assets/uploads/team/" . $team->image ?>">
                        <?php } else {  ?>
                          Sorry No image Found
                        <?php } ?>

                </div>
                </td>
                </tr>


                <tr>
                  <td colspan="2">
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


	  	<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
				<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />



<style>

</style>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
