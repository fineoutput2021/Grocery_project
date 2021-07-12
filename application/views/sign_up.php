
<!-- show success and error messages -->
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
<!-- End show success and error messages -->

  <section class="section-b-space"style="height:90vh;justify-content:center; align-items:center;display:flex;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <form action="<?=base_url() ?>Otp/sign_up" method="post" enctype="multipart/form-data">

                  <div class="form-group">
                  <label class="control-label">Name <span class="required">*</span></label>
                  <input class="form-control border-form-control" value="" name="name" placeholder="Gurdeep" type="text" required>
                  </div>
                  <button type="submit" name="button">Sign Up</button>
                    </form>
                    </div>
                </div>
            </div>
    </section>




<script>
//   DeleteLocalStorageAfterOrderSuccess();
// function DeleteLocalStorageAfterOrderSuccess(){
//
//
//         var cartItems = [];
//         if(localStorage.getItem("cartItems") !== null){
//           cartItems = JSON.parse(localStorage.getItem("cartItems"));
//
//         localStorage.removeItem("cartItems");
//
//           //localStorage.setItem("cartItems" ,'[]');
//         }
//
//
//
// }


</script>
