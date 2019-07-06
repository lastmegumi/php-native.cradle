<?php
getheader();
?>
<div class="wrapper">
<!-- Page Layout here -->
  <ul id="slide-out" class="sidenav" style="transform: translateX(0);">
    <li><div class="row">
      <div class="col s3">
          <div class="background">
          <img class="w-100 img-responsive" src="<?php echo Admin::store()->small_logo();?>">
        </div>
      </div>
      <div class="col s9">
        <p><?php echo Admin::store()->Name();?></p>
      </div>

      <div>
    </li>
    <li>
    <div class="user-view p-0">
      <a href="#name"><span class="name">Username: <span class="right"><?php echo _Admin::current("name");?></span></span></a>
      <a href="#email"><span class="email">My Email: <span class="right"><?php echo _Admin::current("email");?></span></span></a>
    </div>
    </li>
      <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "dashboard")? "active":"";?>">
      <a class="waves-effect" href="/admin/dashboard">
          <i class="material-icons">dashboard</i>
        Dashboard</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "product")? "active":"";?>">
      <a class="waves-effect" href="/admin/product/list">
          <i class="material-icons">bubble_chart</i>
        Product</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "category")? "active":"";?>">
      <a class="waves-effect" href="/admin/category/list">
          <i class="material-icons">line_style</i>
        Category</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "order")? "active":"";?>">
      <a class="waves-effect" href="/admin/order/list">
          <i class="material-icons">shopping_cart</i>
        Sales</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "promotion")? "active":"";?>">
      <a class="waves-effect" href="/admin/promotion">
          <i class="material-icons">money_off</i>
        Promotion</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "report")? "active":"";?>">
      <a class="waves-effect" href="/admin/report">
          <i class="material-icons">trending_up</i>
        Report</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "setting")? "active":"";?>">
      <a class="waves-effect" href="/admin/store/setting">        
          <i class="material-icons">perm_data_setting</i>
        Setting</a></li>
     <li class="red lighten-2 ">
      <a class="waves-effect white-text" href="/admin/logout">        
          <i class="material-icons white-text">highlight_off</i>
        Logout</a></li>
  </ul>

<div class="row" style="margin-left: 300px;">

<div class="col s12 grey lighten-3">
<!-- Teal page content  -->
<?php foreach ($contents as $c) :
if(!$c) {continue;}?>
	<div class="row">
		<div class="col s12">
      <div class="p-3 clearfix">
			<?php print_r($c);?>
      </div>
		</div>
	</div>
<?php endforeach;?>
</div>


<?php
//include GPATH . "/temp/bottom.php";
?>
</div>
<!-- Modal -->
<style type="text/css">
@media (min-width: 1440px) {
  .modal-lg {
    max-width: unset;
    width: 75vw;
  }
}</style>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
  });
  </script>
<?php 
getfooter();
?>