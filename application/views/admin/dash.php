
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
<a href="<?php echo base_url(); ?>dcadmin/users/view_users">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Users</span>
                  <span class="info-box-number"><?= $total_users?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </a>
          <a href="<?php echo base_url(); ?>dcadmin/orders/new_orders">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Orders</span>
                  <span class="info-box-number"><?= $total_orders?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <a href="<?php echo base_url(); ?>dcadmin/orders/completed_orders">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-inr"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Amount</span>
                  <span class="info-box-number"><?= $total_amount ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </a>
            <a href="<?php echo base_url(); ?>dcadmin/orders/new_orders">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-inr"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">New orders</span>
                  <span class="info-box-number"><?= $new_orders?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>
<a href="<?php echo base_url(); ?>dcadmin/users/view_users">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Today Users</span>
                  <?php
                 $cur_date=date("Y-m-d ");

                              $this->db->select('total_amount');
                  $this->db->from('tbl_users');

                  // $this->db->where("(date >= now())");
                  $this->db->like('date',date('Y-m-d'));
                  $total_users= $this->db->count_all_results();

                  ?>
                  <span class="info-box-number"><?= $total_users?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>
<a href="<?php echo base_url(); ?>dcadmin/orders/new_orders">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-maroon"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Today Orders</span>
                  <?php
                 $cur_date=date("Y-m-d ");

                              $this->db->select('*');
                  $this->db->from('tbl_order1');
                  $this->db->like('date',date('Y-m-d'));
                  $total_ordr= $this->db->count_all_results();
                  ?>
                  <span class="info-box-number"><?= $total_ordr?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>
<a href="<?php echo base_url(); ?>dcadmin/orders/completed_orders">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-inr"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Today Amount</span>
                  <?php
                 $cur_date=date("Y-m-d ");

                              $this->db->select('*');
                  $this->db->from('tbl_order1');
                  $this->db->like('date',date('Y-m-d'));
                  $this->db->where('order_status',4);
                  $total_ordr_am= $this->db->get();
                  // $a=  array_sum($total_ordr_am->result());
                  $a=0;
                   // $i=0;
                  foreach ($total_ordr_am->result() as $am) {

                    $a= $a + $am->total_amount;

                  }
                  ?>
                  <span class="info-box-number"><?= $a ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>




<a href="<?php echo base_url(); ?>dcadmin/ExpireProduct/view_expiry_products">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-inr"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Expiry Alerts</span>
                  <?php
                 $cur_date=date("Y-m-d");
                 $next_15days_after_date=  date('Y-m-d', strtotime('+90 days'));

                              $this->db->select('*');
                  $this->db->from('tbl_product');
                  $this->db->where('expire_date <=',$next_15days_after_date);
                  $this->db->where('is_cat_delete', 0);
                  $this->db->where('is_subcat_delete', 0);
                  $this->db->where('is_subcate2_delete', 0);
                  $total_expire_products= $this->db->count_all_results();



                  ?>
                  <span class="info-box-number"><?= $total_expire_products;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>






<a href="<?php echo base_url(); ?>dcadmin/ExpireProduct/low_inventory_products">

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-inr"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Low Inventories</span>
                  <?php

                  $this->db->select('*');
        $this->db->from('tbl_product_units');
        $this->db->where('is_active', 1);
        $product_units_da= $this->db->get();

$i=0;
if(!empty($product_units_da)){
  foreach ($product_units_da->result() as $unit_type) {
    // code...

            $this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('unit_id',$unit_type->id);
$this->db->where('is_active', 1);
$inventory_da= $this->db->get()->row();

if(!empty($inventory_da)){

if($inventory_da->stock <= 3){

  $i++;
}

}



} }


                  ?>
                  <span class="info-box-number"><?=$i;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
</a>




          </div><!-- /.row -->







        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


    </div><!-- ./wrapper -->
