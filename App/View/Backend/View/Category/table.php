<table class="responsive-table striped white">
  <thead>
    <tr>
      <th>Name</tn>
      <th>Updated</tn>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
    <tr class="clickable" data-href='<?php echo 'edit?id=' . $v->id;?>'>
      <td><?php echo $v->getName();?></td>
      <td><?php echo _T($v->updated);?></td>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>

