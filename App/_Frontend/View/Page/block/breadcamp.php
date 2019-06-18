<div class="container">
<?php $home = array_shift($breadcamp);?>
<a href="<?php echo @$home['url'];?>"><?php echo $home['title']?></a>
<?php
if(@$breadcamp):
while($value = array_shift($breadcamp)){?>
 / <span><a href="<?php echo @$value['url'];?>">
 <?php echo $value['title']?></span>
</a>
<?php 
}
endif;
?>
</div>