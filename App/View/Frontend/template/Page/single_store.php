<?php
getheader();
_Page::Block("block/top_bar");
?>
<nav class="blue lighten-2 z-depth-0">
  <div class="nav-wrapper">
    <ul id="nav-mobile" class="container hide-on-med-and-down">
      <li class="<?php echo Route::Request() == ""? "active": "";?>"><a href="/">Tempest</a></li>
      <li class="<?php echo Route::Request() == "product"? "active": "";?>"><a href="/product/list">Product</a></li>
      <li class="<?php echo Route::Request() == "dealers"? "active": "";?>"><a href="/dealers">Authorized Dealer</a></li>
      <li class="<?php echo Route::Request() == "about"? "active": "";?>"><a href="/about">About Tempest</a></li>
      <li class="<?php echo Route::Request() == "contact"? "active": "";?>"><a href="/contact">Contact Us</a></li>
      <li class="<?php echo Route::Request() == "faq"? "active": "";?>"><a href="/faq">FAQ</a></li>
    </ul>
  </div>
</nav>
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