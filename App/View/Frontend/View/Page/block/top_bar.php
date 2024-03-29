<header class="clearfix p-3">
  <div class="left">
    <h6>
    <?php echo Platform::Name();?></h6>
      <a href="/admin/login" style="font-size:small">Become a seller>></a>
  </div>
  <?php if(SALE_ENABLED):?>
  <?php if(_User::is_logged()):?>
  <a class='dropdown-trigger right' style="margin-right:2em" href='#' data-target='joinus'>
  	<i class="material-icons">person_outline</i><span class="v_i_super"><?php echo _User::current("uname");?></span>
  </a>
  <ul id='joinus' class='dropdown-content' style="min-width:10%">
    <li><a href="/user/dashboard/"><i class="material-icons dp48">dashboard</i><span class="right">Dashboard</span></a></li>
    <li><a href="/user/dashboard/orders"><i class="material-icons dp48">shopping_basket</i><span class="right">Orders</span></a></li>
    <li class="divider" tabindex="-1"></li>
    <li class="red lighten-2"><a class="white-text" href="/logout"><i class="material-icons dp48">exit_to_app</i><span class="right">Log out</span></a></li>
  </ul>
  <?php else:?>
  <a class='dropdown-trigger right' style="margin-right:2em" href='#' data-target='joinus'>
  	<i class="material-icons dp48">face</i><span class="v_i_super">Join</span>
  </a>
  <ul id='joinus' class='dropdown-content' style="min-width:10%">
    <li><a href="/login"><i class="material-icons dp48">gamepad</i><span class="right">Log in</span></a></li>
    <li><a href="/register"><i class="material-icons dp48">location_searching</i><span class="right">Register</span></a></li>
    <li class="divider" tabindex="-1"></li>
  </ul>
<?php endif;?>
  <a class="right dropdown-trigger" data-target='top_cart' id="getCart" href="javascript:void(0)" style="margin-right:2em"><i class="material-icons dp48">add_shopping_cart</i><span class="v_i_super">My Cart</span></a>
<div id='top_cart' class='dropdown-content' style="min-width:25vw; max-width:100vw;">
  
<?php endif;?>
</div>
</header>

