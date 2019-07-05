<?php
getheader();
?>
<style type="text/css">

#login-page {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    height: 100vh;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -moz-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
</style>
<div class="row">
      <div class="col s12 m-0 grey darken-4">
        <div class="container">
        	<div id="login-page" class="row">
			  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
			    <form class="login-form" action="/admin/login" method="post">
			      <div class="row">
			        <div class="input-field col s12">
			          <h5 class="ml-4">Sign in</h5>
			        </div>
			      </div>
			      <p>
			      <?php 
			      $msg = MSG::get();
			      echo $msg? $msg:"";
			      MSG::clear();?></p>

			      <div class="row margin">
			        <div class="input-field col s12">
			          <i class="material-icons prefix pt-2">person_outline</i>
			          <input id="username" type="text" name="name">
			          <label for="username" class="center-align">Username</label>
			        </div>
			      </div>
			      <div class="row margin">
			        <div class="input-field col s12">
			          <i class="material-icons prefix pt-2">lock_outline</i>
			          <input id="password" name="password" type="password">
			          <label for="password">Password</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Login</button>
			        </div>
			      </div>
			    </form>
			  </div>
			</div>
        </div>
      </div>
    </div>
<?php 
getfooter();
?>