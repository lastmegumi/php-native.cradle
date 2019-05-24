<?php
getheader();
?>
<header class="clearfix">
  <a class="left" href="/">Home</a>
  <a class="right btn" href="/cart/mycart">My Cart</a>
</header>
<div class="wrapper">
  <div class="container">
<!-- Page Layout here -->
<div class="row">
<div class="col s12">
<!-- Teal page content  -->
<?php foreach ($contents as $c) :
if(!$c) {continue;}?>
	<div class="row">
		<div class="col s12" style="padding:15px;">
			<?php print_r($c);?>
		</div>
	</div>
<?php endforeach;?>
</div>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light p-0 clearfix">
        Loading...
      </div>
    </div>
  </div>
</div>
<?php 
getfooter();
?>