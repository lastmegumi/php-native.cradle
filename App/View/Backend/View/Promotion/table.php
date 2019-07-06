<table class="responsive-table striped white">
	<thead>
		<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Target</th>
		<th>Type</th>
		<th>Value</th>
		<th>Status</th>
		<th>Priority</th>
		<th class="right-align">Start</th>
		<th class="right-align">End</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($data as $k => $v):?>
		<tr class="clickable" data-href='<?php echo  HOME . BACKEND .'promotion/edit?id=' . $v->id ?>'>
			<td><?php echo $v->id; ?></td>
			<td><?php echo $v->getName(); ?></td>
			<td><?php echo $v->getTarget(); ?></td>
			<td><?php echo $v->getTypeName(); ?></td>
			<td class="right-align"><?php echo $v->getValueName(); ?></td>
			<td><?php echo $v->getStatus(); ?></td>
			<td><?php echo $v->getPriority(); ?></td>
			<td class="right-align"><?php echo $v->getStart(); ?></td>
			<td class="right-align"><?php echo $v->getEnd(); ?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>