<?php
getheader();
_Page::Block("block/top_bar");

_Page::Block("block/nav");
?>
<div class="wrapper">
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
</div>
<?php 
_Page::Block("block/bottom_bar");
getfooter();
?>