<header class="clearfix container">
  <a class="left" href="/"><img class="img-responsive" src="<?php echo HOME;?>imgs/logo-large.jpg" /></a>
  <?php if(SALE_ENABLED):?>
  <?php if(_User::is_logged()):?>
  <a class='dropdown-trigger right' style="margin-right:2em" href='#' data-target='joinus'>
  	<i class="material-icons dp48">face</i><span class="v_i_super"><?php echo _User::current("uname");?></span>
  </a>
  <ul id='joinus' class='dropdown-content'>
    <li><a href="/user/dashboard/">Dashboard</a></li>
    <li><a href="/user/dashboard/orders">Orders</a></li>
    <li class="divider" tabindex="-1"></li>
    <li class="red lighten-2"><a class="white-text" href="/user/logout">Log out</a></li>
  </ul>
  <?php else:?>
  <a class='dropdown-trigger right' style="margin-right:2em" href='#' data-target='joinus'>
  	<i class="material-icons dp48">face</i><span class="v_i_super">Join</span>
  </a>
  <ul id='joinus' class='dropdown-content'>
    <li><a href="/user/login">Log in</a></li>
    <li><a href="/user/register">Register</a></li>
    <li class="divider" tabindex="-1"></li>
  </ul>
<?php endif;?>
  <a class="right dropdown-trigger" data-target='top_cart' id="getCart" href="/cart/mycart" style="margin-right:2em"><i class="material-icons dp48">add_shopping_cart</i><span class="v_i_super">My Cart</span></a>
<div id='top_cart' class='dropdown-content'>
  
<?php endif;?>
</div>
</header>