<?php
getheader();
?>
<header class="clearfix container">
  <a class="left" href="/">Home</a>
  <a class="right btn" href="/cart/mycart">My Cart</a>
  <a class="right" href="/user/register">Register</a>
  <a class="right" href="/user/login">Log In</a>
</header>
<nav>
	<div class="nav-wrapper">
	  <ul id="nav-mobile" class="container hide-on-med-and-down">
	    <li><a href="product/list">Product</a></li>
	    <li><a href="badges.html">Components</a></li>
	    <li><a href="collapsible.html">JavaScript</a></li>
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
  <footer class="page-footer grey darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright black">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
</footer>
<?php 
getfooter();
?>