<section class="col s12">
<h6>Account Information</h6>
<div class="row">
	<div class="col s12">
		<div class="p-3 white">
		<p>User Name:<span class="right"><?php echo $data->getUsername();?></span></p>
		<p>E-mail:<span class="right"><?php echo $data->getEmail();?></span></p>
		</div>
	</div>
</div>
		<a class="btn red lighten-2" href="/user/dashboard/changepassword">Change Password</a>
</section>