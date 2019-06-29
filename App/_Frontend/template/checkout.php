<?php
getheader();
_Page::Block("block/top_bar");
?>
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
<?php 
getfooter();
?>