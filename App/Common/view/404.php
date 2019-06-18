<?php
getheader();
_Page::Block("block/top_bar");
?>
<nav class="blue lighten-2 z-depth-0">
  <div class="nav-wrapper">
    <ul id="nav-mobile" class="container hide-on-med-and-down">
      <li><a href="/product/list">Product</a></li>
      <li><a href="/dealers">Authorized Dealer</a></li>
      <li><a href="/about">About Tempest</a></li>
      <li><a href="/contact">Contact Us</a></li>
      <li><a href="/faq">FAQ</a></li>
    </ul>
  </div>
</nav>
<div class="wrapper container p-3 center-align">
<!-- Page Layout here -->
<!-- Teal page content  -->
<div class="p-3">
      <h1 class="error-code m-0">404</h1>
      <h6 class="mb-2">BAD REQUEST</h6>
      <a class="btn waves-effect waves-light gradient-45deg-deep-purple-blue gradient-shadow mb-4" href="/">Back
        TO Home</a>
       </div>
</div>
<?php 
_Page::Block("block/bottom_bar");
getfooter();
?>