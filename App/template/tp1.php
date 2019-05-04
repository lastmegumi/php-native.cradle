<?php
getheader();
?>
<div class="wrapper">
<!-- Page Layout here -->

  <a href="#" data-target="slide-out" class="sidenav-trigger waves-effect waves-light btn-small red left-align"><i class="material-icons">menu</i></a>

  <ul id="slide-out" class="sidenav">
    <li><div class="user-view">
      <div class="background">
        <img src="images/office.jpg">
      </div>
      <a href="#user"><img class="circle" src="images/yuna.jpg"></a>
      <a href="#name"><span class="white-text name">John Doe</span></a>
      <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a>
    </div></li>
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
    <li><a href="#!">Second Link</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Subheader</a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  </ul>

<div class="row">

<div class="col s12">
<!-- Teal page content  -->
<?php foreach ($contents as $c) :?>
	<div class="row">
		<div class="col s12 white" style="padding:15px;">
			<?php echo $c;?>
		</div>
	</div>
<?php endforeach;?>
</div>


<?php
//include GPATH . "/temp/bottom.php";
?>
</div>
<!-- Modal -->
<style type="text/css">
@media (min-width: 1440px) {
  .modal-lg {
    max-width: unset;
    width: 75vw;
  }
}</style>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light p-0 clearfix">
        Loading...
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, options);
  });

  // Or with jQuery

  $(document).ready(function(){
    $('.sidenav').sidenav();
  });</script>
<?php 
getfooter();
?>