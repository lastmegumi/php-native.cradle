<ul class="pagination left">
<li class="<?php echo $index <= 1? 'disabled' : 'waves-effect grey lighten-4';?>">
  <a href="<?php echo $index > 1? '?page=' . ($index - 1): "#!";?>"><i class="material-icons">chevron_left</i></a></li>
  <?php 
  for ($i = 1; $i <= $pages; $i++) : ?>
      <li class=<?php echo $index == $i? "active": "waves-effect grey lighten-4";?>>
        <a href="?page=<?php echo $i;?>"><?php echo $i;?></a>
      </li>
      <?php
  endfor;
  ?>
<li class="<?php echo $index >= $pages? 'disabled' : 'waves-effect  grey lighten-4';?>">
  <a href="<?php echo $index < $pages? '?page='. ($index + 1): "#!";?>"><i class="material-icons">chevron_right</i></a></li>
</ul>
<p class="right">Total: <?php echo $total;?></p>