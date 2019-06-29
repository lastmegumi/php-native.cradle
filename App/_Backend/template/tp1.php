<?php
getheader();
?>
<div class="wrapper">
<!-- Page Layout here -->
  <ul id="slide-out" class="sidenav" style="transform: translateX(0);">
    <li><div class="user-view">
      <div class="background">
        <img src="images/office.jpg">
      </div>
    </div></li>

    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "product")? "active":"";?>"><a class="waves-effect" href="/admin/product/list">Product</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "category")? "active":"";?>"><a class="waves-effect" href="/admin/category/list">Category</a></li>
    <li class="<?php echo strpos(parse_url($_SERVER['REQUEST_URI'])['path'], "order")? "active":"";?>"><a class="waves-effect" href="/admin/order/list">Sales</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Setting</a></li>
  </ul>

<div class="row" style="margin-left: 300px;">

<div class="col s12 grey lighten-3">
<!-- Teal page content  -->
<?php foreach ($contents as $c) :
if(!$c) {continue;}?>
	<div class="row">
		<div class="col s12">
      <div class="p-3 white clearfix">
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