<?php
getheader();
_Page::Block("block/top_bar");

_Page::Block("block/nav");
?>
<div class="wrapper">
<!-- Page Layout here -->
<div class="row">
<div class="col s3">
<!-- Teal page content  -->
<?php
print_r($contents['store']);
?>
</div>
<div class="col s9">
<!-- Teal page content  -->
<?php
print_r($contents['product']);
?>
</div>
</div>
</div>
<?php 
_Page::Block("block/bottom_bar");
getfooter();
?>