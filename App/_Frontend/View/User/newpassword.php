<section class="col s12">
<h6>New Password</h6>
<?php
if(@$_SESSION['message']):
	foreach ($_SESSION['message'] as $key => $value):?>
<p class="red-text"><?php echo $value;?></p>
<?php
endforeach;
unset($_SESSION['message']);
endif;
?>
<div class="row">
	<div class="col s12">
		<div class="p-3 white">
			  <div class="row">
			    <form class="col s12" method="POST">
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="cur_password" type="password" name="cur_password" class="validate">
			          <label for="cur_password">Password</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="password" type="password" name="password" class="validate">
			          <label for="password">New Password</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="rep_password" type="password" name="rep_password" class="validate">
			          <label for="rep_password">Repeat Password</label>
			        </div>
			      </div>
					<button class="btn red lighten-2">Submit</button>
			    </form>
			  </div>
		</div>
	</div>
</div>
</section>