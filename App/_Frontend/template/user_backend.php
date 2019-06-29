<?php
getheader();
_Page::Block("block/top_bar");
?>
<div class="wrapper" style="position:relative;min-height:100vh;background:#efefef;">
  <ul id="slide-out" class="sidenav z-depth-0" style="transform: translateX(0%);position:absolute;float:left;hegiht:100%">
    <li><div class="user-view">
      <a href="#name"><span class="white-text name"><?php echo _User::current("name");?></span></a>
      <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
    </div></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">person_pin</i>Profile</a></li>
    <li><div class="divider"></div></li>    
    <li><a class="subheader">My Account</a></li>
    <li class="<?php echo parse_url($_SERVER['REQUEST_URI'])['path']=="/user/dashboard/"? "active":""; ?>">
      <a class="waves-effect" href="/user/dashboard/"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li class="<?php echo parse_url($_SERVER['REQUEST_URI'])['path']=="/user/dashboard/orders/"? "active":""; ?>">
      <a class="waves-effect" href="/user/dashboard/orders/"><i class="material-icons">view_list</i>Orders</a></li>
    <li class="<?php echo parse_url($_SERVER['REQUEST_URI'])['path']=="/user/dashboard/reviews/"? "active":""; ?>">
      <a class="waves-effect" href="/user/dashboard/reviews/"><i class="material-icons">comments</i>Reviews</a></li>
    <li class="<?php echo parse_url($_SERVER['REQUEST_URI'])['path']=="/user/dashboard/logout/"? "active":""; ?>">
      <a class="waves-effect" href="/user/logout"><i class="material-icons">exit_to_app</i>Log out</a></li>
  </ul>
<!-- Page Layout here -->
<div class="content" style="margin-left:300px">
  <div class="row">
  <div class="col s12">
  <!-- Teal page content  -->
  <?php foreach ($contents as $c) :
  if(!$c) {continue;}?>
  	<div class="row m-0">
  		<div class="col s12" style="padding:15px;">
  			<?php print_r($c);?>
  		</div>
  	</div>
  <?php endforeach;?>
  </div>
</div>
</div>
<script type="text/javascript">

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, options);
  });

  // Initialize collapsible (uncomment the lines below if you use the dropdown variation)
  // var collapsibleElem = document.querySelector('.collapsible');
  // var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

  // Or with jQuery

  $(document).ready(function(){
    $('.sidenav').sidenav();
  });
        
</script>
<?php 
getfooter();
?>