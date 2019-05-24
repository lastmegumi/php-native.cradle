<table class="responsive-table striped">
  <thead>
    <tr>
      <?php
      foreach ($header as $k => $v) :?>
      <td><?php echo $v?></td>
      <?php endforeach;?>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
    <tr class="clickable" data-href='<?php echo @$name? HOME . BACKEND .  $name . '/edit?id=' . $v['id']:"" ?>'>
      <?php
      foreach($v as $k2 => $v2):?>
      <td><?php echo @$v2?></td>
    <?php endforeach;?>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>

