      <table>
        <tbody>
        	<?php foreach($data as $k => $v):?>
          <tr>
            <td><?php echo $v['name']?></td>
            <td><?php echo $v['value']?></td>
          </tr>
      <?php endforeach;?>
        </tbody>
      </table>
