<nav class="blue lighten-2 z-depth-0">
  <div class="nav-wrapper">
    <ul id="nav-mobile" class="container hide-on-med-and-down">
      <li class="<?php echo Route::Request() == ""? "active": "";?>"><a href="/">Home</a></li>
      <li class="<?php echo Route::Request() == "product"? "active": "";?>"><a href="/product/list">Product</a></li>
      <li class="<?php echo Route::Request() == "store"? "active": "";?>"><a href="/store">Stores</a></li>
      <li class="<?php echo Route::Request() == "dealers"? "active": "";?>"><a href="/dealers">Authorized Dealer</a></li>
      <li class="<?php echo Route::Request() == "about"? "active": "";?>"><a href="/about">About <?php echo Platform::Name();?></a></li>
      <li class="<?php echo Route::Request() == "contact"? "active": "";?>"><a href="/contact">Contact Us</a></li>
      <li class="<?php echo Route::Request() == "faq"? "active": "";?>"><a href="/faq">FAQ</a></li>
    </ul>
  </div>
</nav>