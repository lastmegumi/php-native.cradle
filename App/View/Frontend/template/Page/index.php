<?php
getheader();
_Page::Block("block/top_bar");
?>
<nav class="blue lighten-2">
  <div class="nav-wrapper">
    <ul id="nav-mobile" class="container hide-on-med-and-down">
      <li><a href="/">Tempest</a></li>
      <li><a href="/product/list">Product</a></li>
      <li><a href="/dealers">Authorized Dealer</a></li>
      <li><a href="/about">About Tempest</a></li>
      <li><a href="/contact">Contact Us</a></li>
      <li><a href="/faq">FAQ</a></li>
    </ul>
  </div>
</nav>

<div class="wrapper">
<!-- Page Layout here -->
<!-- Teal page content  -->
<?php foreach ($contents as $c) :
if(!$c) {continue;}?>
	<div class="row">
			<?php print_r($c);?>
	</div>
<?php endforeach;?>

</div>
<?php 
_Page::Block("block/bottom_bar");
getfooter();
?>

