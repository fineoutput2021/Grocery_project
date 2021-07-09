<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Askbootstrap">
<meta name="author" content="Askbootstrap">
<title>Grocery</title>

<link rel="icon" type="image/png" href="img/favicon2.png">

<link href="<?=base_url();?>assets/frontend/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- <link href="<?=base_url();?>assets/frontend/vendor/icons/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" /> -->
<link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

<link href="<?=base_url();?>assets/frontend/frontend/vendor/select2/css/select2-bootstrap.css" />
<link href="<?=base_url();?>assets/frontend/frontend/vendor/select2/css/select2.min.css" rel="stylesheet" />

<link href="<?=base_url();?>assets/frontend/css/osahan2.css" rel="stylesheet">

<link rel="stylesheet" href="<?=base_url();?>assets/frontend/frontend/vendor/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="<?=base_url();?>assets/frontend/frontend/vendor/owl-carousel/owl.theme.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  var a = '<? echo $this->session->flashdata('popup'); ?>';

if(a != "" && a == 1)
{
  $('#bd-example-modal').modal('show');
}

</script>

</head>
<body>
<div class="modal fade login-modal-main" id="bd-example-modal">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-body">
<div class="login-modal">
<div class="row">
<div class="col-lg-6 pad-right-0">
<div class="login-modal-left">
</div>
</div>
<div class="col-lg-6 pad-left-0">
<button type="button" class="close close-top-right" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true"><i class="mdi mdi-close"></i></span>
<span class="sr-only">Close</span>
</button>

<div class="login-modal-right">

<div class="tab-content">
<div class="tab-pane active" id="login" role="tabpanel">
  <form action="<?= base_url();?>Otp/get_otp" method="post">

<h5 class="heading-design-h5">Login to your account</h5>
<fieldset class="form-group">
<label>Mobile number</label>
<input type="number" name="contact_no" class="form-control" placeholder="+91 123 456 7890" required>
</fieldset>
<fieldset class="form-group">
<button type="submit" class="btn btn-lg btn-secondary btn-block">Get OTP</button>
</fieldset>
</form>
<form  action="<?= base_url();?>Otp/verify_get_otp" method="post">


<fieldset class="form-group">
<label>Enter OTP</label>
<input type="number" name="otp" class="form-control" placeholder="********" required>
</fieldset>
<fieldset class="form-group">
<button type="submit" class="btn btn-lg btn-secondary btn-block">Enter to your account</button>
</fieldset>
<!-- <div class="login-with-sites text-center">
<p>or Login with your social profile:</p>
<button class="btn-facebook login-icons btn-lg"><i class="mdi mdi-facebook"></i> Facebook</button>
<button class="btn-google login-icons btn-lg"><i class="mdi mdi-google"></i> Google</button>
<button class="btn-twitter login-icons btn-lg"><i class="mdi mdi-twitter"></i> Twitter</button>
</div> -->
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="customCheck1">
<label class="custom-control-label" for="customCheck1">Remember me</label>
</div>
  </form>
</div>
<div class="tab-pane" id="register" role="tabpanel">
<h5 class="heading-design-h5">Register Now!</h5>
<fieldset class="form-group">
<label>Mobile number</label>
<input type="text" class="form-control" placeholder="+91 123 456 7890">
</fieldset>
<fieldset class="form-group">
<label>Enter OTP</label>
<input type="password" class="form-control" placeholder="********">
</fieldset>
<!-- <fieldset class="form-group">
<label>Enter Confirm Password </label>
<input type="password" class="form-control" placeholder="********">
</fieldset> -->
<fieldset class="form-group">
<button type="submit" class="btn btn-lg btn-secondary btn-block">Create Your Account</button>
</fieldset>
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="customCheck2">
<label class="custom-control-label" for="customCheck2">I Agree with <a href="#">Term and Conditions</a></label>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="text-center login-footer-tab">
<ul class="nav nav-tabs" role="tablist">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="<?=base_url();?>home/login" role="tab"><i class="mdi mdi-lock"></i> LOGIN</a>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="<?=base_url();?>home/register" role="tab"><i class="mdi mdi-pencil"></i> REGISTER</a>
</li>
</ul>
</div>
<div class="clearfix"></div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="navbar-top bg-success pt-2 pb-2">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12 text-center">
<a href="<?=base_url();?>home/shop" class="mb-0 text-white">
20% cashback for new users | Code: <strong><span class="text-light">OGOFERS13 <span class="mdi mdi-tag-faces"></span></span> </strong>
</a>
</div>
</div>
</div>
</div>
<nav class="navbar navbar-light navbar-expand-lg bg-dark bg-faded osahan-menu">
<div class="container-fluid">
<a class="navbar-brand" href="<?=base_url();?>Home"> <img src="<?=base_url();?>assets/frontend/img/logo2.png" alt="logo"> </a>
<a class="location-top" href="#"><i class="mdi mdi-map-marker-circle" aria-hidden="true"></i> New York</a>
<button class="navbar-toggler navbar-toggler-white collapsed" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="navbar-collapse" id="navbarNavDropdown">
<div class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto top-categories-search-main">
<div class="top-categories-search">
<div class="input-group">
<span class="input-group-btn categories-dropdown">
<select class="form-control-select">
<option selected="selected">Your City</option>
<option value="0">New Delhi</option>
<option value="2">Bengaluru</option>
<option value="3">Hyderabad</option>
<option value="4">Kolkata</option>
</select>
</span>
<input class="form-control" placeholder="Search products in Your City" aria-label="Search products in Your City" type="text">
<span class="input-group-btn">
<button class="btn btn-secondary" type="button"><i class="mdi mdi-file-find"></i> Search</button>
</span>
</div>
</div>
</div>
<div class="my-2 my-lg-0">
<ul class="list-inline main-nav-right">
  <li class="list-inline-item dropdown osahan-top-dropdown">
    <? if(!empty($this->session->userdata('user_data'))){ ?>
  <a class="btn btn-theme-round dropdown-toggle dropdown-toggle-top-user" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <img alt="logo" src="<?=base_url();?>assets/frontend/img/user.jpg"><strong>Hi</strong> <?= ($this->session->userdata('user_name')) ?>
  </a>
<? } ?>
  <div class="dropdown-menu dropdown-menu-right dropdown-list-design">
  <a href="<?=base_url();?>Home/my_profile" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-account-outline"></i> My Profile</a>
  <a href="<?=base_url();?>Home/my_address" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-map-marker-circle"></i> My Address</a>
  <a href="<?=base_url();?>Home/wishlist" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-heart-outline"></i> Wish List </a>
  <a href="<?=base_url();?>Home/orderlist" class="dropdown-item"><i aria-hidden="true" class="mdi mdi-format-list-bulleted"></i> Order List</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=base_url();?>Otp/logout"><i class="mdi mdi-lock"></i> Logout</a>
  </div>
  </li>
<li class="list-inline-item">
  <? if(empty($this->session->userdata('user_data'))){ ?>
<a href="#" data-target="#bd-example-modal" data-toggle="modal" class="btn btn-link"><i class="mdi mdi-account-circle"></i> Login/Sign Up</a>
<? } ?>
</li>
<li class="list-inline-item cart-btn">
<a href="<?=base_url();?>Cart/cart" data-toggle="offcanvas" class="btn btn-link border-none">
  <i class="mdi mdi-cart"></i> My Cart <small class="cart-value">5</small></a>
</li>
</ul>
</div>
</div>
</div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light osahan-menu-2 pad-none-mobile collapse" id="navbarText">
<div class="container-fluid">
<div class="" >
<ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
<li class="nav-item">
<a class="nav-link shop" href="<?=base_url();?>home/index"><span class="mdi mdi-store"></span> Super Store</a>
</li>
<li class="nav-item">
<a href="<?=base_url();?>home/index" class="nav-link">Home</a>
</li>
<li class="nav-item">
<a href="<?=base_url();?>home/about" class="nav-link">About Us</a>
</li>
<li class="nav-item">
<a class="nav-link" href="<?=base_url();?>home/shop">Fruits & Vegetables</a>
</li>
<li class="nav-item">
<a class="nav-link" href="<?=base_url();?>home/shop">Grocery & Staples</a>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Pages
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="<?=base_url();?>home/shop"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Shop Grid</a>
<!-- <a class="dropdown-item" href="<?=base_url();?>home/single"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Single Product</a> -->
<a class="dropdown-item" href="<?=base_url();?>home/cart"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Shopping Cart</a>
<a class="dropdown-item" href="<?=base_url();?>home/checkout"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Checkout</a>
</div>
</li>
<li class="nav-item dropdown">
 <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
My Account
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="<?=base_url();?>home/my_profile"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> My Profile</a>
<a class="dropdown-item" href="<?=base_url();?>home/my_address"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> My Address</a>
<a class="dropdown-item" href="<?=base_url();?>home/wishlist"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Wish List </a>
<a class="dropdown-item" href="<?=base_url();?>home/orderlist"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Order List</a>
</div>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Blog Page
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="<?=base_url();?>home/blog"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Blog</a>
<a class="dropdown-item" href="<?=base_url();?>home/blog_detail"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Blog Detail</a>
</div>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
More Pages
</a>
<div class="dropdown-menu">
<a class="dropdown-item" href="<?=base_url();?>home/about"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> About Us</a>
<a class="dropdown-item" href="<?=base_url();?>home/contact"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> Contact Us</a>
<a class="dropdown-item" href="<?=base_url();?>home/faq"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> FAQ </a>
<a class="dropdown-item" href="<?=base_url();?>home/not_found"><i class="mdi mdi-chevron-right" aria-hidden="true"></i> 404 Error</a>
</div>
</li>
<li class="nav-item">
<a class="nav-link" href="<?=base_url();?>home/contact">Contact</a>
</li>
</ul>
</div>
</div>
</nav>




<? if(!empty($this->session->flashdata('header_smessage'))){ ?>
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Alert!</h4>
<? echo $this->session->flashdata('header_smessage'); ?>
</div>
<? }
if(!empty($this->session->flashdata('header_emessage'))){ ?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
<? echo $this->session->flashdata('header_emessage'); ?>
</div>
<? } ?>
