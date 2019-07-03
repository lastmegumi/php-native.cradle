<div class="product_reveiw" id="review_block" data-load="ajax" data-func="loadReview" data-product-id="<?php echo $product->id;?>">
	<div class="progress">
      <div class="indeterminate"></div>
  </div>
</div>

<?php
return;
 if(!$data){$data = [];}?>
<?php foreach ($data as $k => $v) :?>
<div class="row">
	<div class="col s12">
		<div class="p-3">
		<span><?php echo $v->id;?></span>
		<span><?php 
			switch ($v->rate) {
				case 1:
					echo '<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>';
					break;
				case 2:
					echo '<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>';
					break;
				case 3:
					echo '<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>';
					break;
				case 4:
					echo '<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 grey-text text-lighten-2">star</i>';
					break;
				case 5:				
				default:
					echo '<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>
						<i class="material-icons dp48 red-text text-lighten-2">star</i>';
					break;
			}
		?></span>
		<span class="right"><?php echo _T($v->timestamp);?></span>
		<p>
			<?php echo $v->content;?>
		</p>
		<span><?php echo $v->user->getName()??"Guest";?></span>
	</div>
</div>
</div>
<div class="divider"></div>
<?php endforeach;?>
<div class="center p-3">
	<a class="waves-effect waves-light btn-large text-center" href="/product/reviews/<?php echo $product->id?>">Write your comment</a>
</div>
