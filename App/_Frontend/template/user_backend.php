<?php
getheader();
?>
<header class="clearfix">
  <a class="left" href="/">Home</a>
  <a class="right btn" href="/cart/mycart">My Cart</a>
</header>
<div class="wrapper" style="position:relative;height:100vh">
  <ul id="slide-out" class="sidenav z-depth-1" style="transform: translateX(0%);position:absolute;float:left;hegiht:100%">
    <li><div class="user-view">
      <div class="background">
        <img src="images/office.jpg">
      </div>
      <a href="#user"><img class="circle" src="images/yuna.jpg"></a>
      <a href="#name"><span class="white-text name">John Doe</span></a>
      <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
    </div></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">person_pin</i>Profile</a></li>
    <li><div class="divider"></div></li>    
    <li><a class="subheader">My Account</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">view_list</i>Orders</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">comments</i>Reviews</a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">exit_to_app</i>Log out</a></li>
  </ul>
<!-- Page Layout here -->
<div class="content" style="margin-left:300px">
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