
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
                    <div class="success-text" style="line-height:60px;text-align:center;font-family: Lato, sans-serif;"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 50px;color: #4ead4e;"></i>
                        <h2 style="">Thank you</h2>
                        <p  style="font-size: 18px;  text-transform: inherit;">Order is successfully placed and your order is on the way</p>
                      <div class="d-flex justify-content-center align-items-center">
                        <a  style="margin-right:18px;" href="<?=base_url()?>Home/orderlist" class="btn btn-solid default-btn">View Orders</a>
                        <a class="optional-btn btn btn-normal" type="button" href="<?=base_url()?>">  Continue to shopping..</a>
                      </div>



                    </div>
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
