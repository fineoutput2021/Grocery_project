
<section class="account-page section-padding">
<div class="container">
<div class="row">
<div class="col-lg-9 mx-auto">
<div class="row no-gutters">
<div class="col-md-4">
<div class="card account-left">
<div class="user-profile-header">
<?
 $user_id = $this->session->userdata('user_id');


            $this->db->select('*');
$this->db->from('tbl_user_address');
$this->db->where('user_id',$user_id);
$user_data= $this->db->get()->row();

?>





<h5 class="mb-1 text-secondary"><strong>Hi </strong><?=$user_data->name;?></h5>

<p><?=$user_data->contact;?></p>
</div>
<div class="list-group">
<a href="<?=base_url();?>Home/my_profile" class="list-group-item list-group-item-action active"><i aria-hidden="true" class="mdi mdi-account-outline"></i> My Profile</a>
<!-- <a href="<?=base_url();?>Home/my_address" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i> My Address</a> -->
<a href="<?=base_url();?>Home/wishlist" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-heart-outline"></i> Wish List </a>
<a href="<?=base_url();?>Home/orderlist" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i> Order List</a>
<a href="#" class="list-group-item list-group-item-action"><i aria-hidden="true" class="mdi mdi-lock"></i> Logout</a>
</div>
</div>
</div>
<div class="col-md-8">
<div class="card card-body account-right">
<div class="widget">
<div class="section-header">
<h5 class="heading-design-h5">
My Profile
</h5>
</div>
<form action="<?=base_url()?>Home/update_user_details" method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-sm-12">
<div class="form-group">
<label class="control-label">Name <span class="required">*</span></label>
<input class="form-control border-form-control" value="<?=$user_data->name;?>" placeholder="" type="text" name="name">
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label">Phone <span class="required">*</span></label>
<input class="form-control border-form-control" value="<?=$user_data->contact;?>" placeholder="" type="number" name="phone">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label">Email Address <span class="required">*</span></label>
<input class="form-control border-form-control " value="<?=$user_data->email;?>" placeholder=""  type="email" name="email">
</div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label">Zip Code <span class="required">*</span></label>
<input class="form-control border-form-control" value="<?=$user_data->zipcode;?>" placeholder="" type="number" name="zipcode">
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="form-group">
<label class="control-label">Address <span class="required">*</span></label>
<textarea class="form-control border-form-control" value="" name="address"><?=$user_data->address;?></textarea>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12 text-right">
<button type="submit" class="btn btn-success btn-lg " > Save Changes </button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
