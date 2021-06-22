<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Add New promocode
          </h1>

        </section>
<section class="content">
<div class="row">
       <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New promocode</h3>
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
                                   <form action="<?php echo base_url() ?>dcadmin/promocode/add_promocode_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table table-hover">

<tr>
<td> <strong>Promocode</strong>  <span style="color:red;">*</span></strong> </td>
    <td>
<input type="text" name="promocode"  class="form-control" placeholder="" required value="" />
   </td>
    </tr>
    <tr>
      <td> <strong>Select Promocode Type</strong>  <span style="color:red;">*</span></strong> </td>

  <td>
    <select class="form-control" name="type">
      <option value="">Please select Promocode Type</option>
        <option value="1">One Time</option>
        <option value="2">Every Time</option>

    </select></td>
      </tr>
      <tr>
    <td> <strong>Gift Percent</strong>  <span style="color:red;">*</span></strong> </td>
        <td>
    <input type="number" name="percent"  class="form-control" placeholder="" required value="" />
       </td>
        </tr>
        <tr>
      <td> <strong>Minimum Order Amount to Apply Promocode</strong>  <span style="color:red;">*</span></strong> </td>
          <td>
      <input type="number" name="minimum_amount"  class="form-control" placeholder="" required value="" />
         </td>
          </tr>
          <tr>
        <td> <strong>Maximum Gift Amount</strong>  <span style="color:red;">*</span></strong> </td>
            <td>
        <input type="number" name="maximum_gift_amount"  class="form-control" placeholder="" required value="" />
           </td>
            </tr>
            <tr>
          <td> <strong>Promocode Expiry Date</strong>  <span style="color:red;">*</span></strong> </td>
              <td>
          <input type="date" name="expiry_date"  class="form-control" placeholder="" required value="" />
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


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
