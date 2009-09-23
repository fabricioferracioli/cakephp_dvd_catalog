<?php

// file: /app/views/dvds/admin_index.ctp

?>
<div class="dvds index">

	<h2>Dvds Admin Index</h2>
    <p>Currently displaying all DVDs in the application</p>

    <?php
	// check $dvds variable exists and is not empty
	if(isset($dvds) && !empty($dvds)) :
	?>

    <table class="stripe">
    	<thead>
        	<tr>
				<th>Name</th>
                <th><?php echo __('Emprestado', true); ?></th>
            	<th>Format</th>
                <th>Type</th>
                <th>Location</th>
				<th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($dvds as $dvd): ?>
            <tr>
				<td><?php echo $dvd['Dvd']['name']; ?></td>
                <td><?php echo empty($dvd['Loan']) ? __('Não', true) : $dvd['Loan'][0]['name']; ?></td>
				<td><?php echo $html->link($dvd['Format']['name'], array('controller'=> 'formats', 'action'=>'edit', $dvd['Format']['id'])); ?></td>
				<td><?php echo $html->link($dvd['Type']['name'], array('controller'=> 'types', 'action'=>'edit', $dvd['Type']['id'])); ?></td>
				<td><?php echo $html->link($dvd['Location']['name'], array('controller'=> 'locations', 'action'=>'edit', $dvd['Location']['id'])); ?></td>
				<td><?php echo $dvd['Dvd']['rating']; ?></td>
				<td>
				<?php echo $html->link('Edit', array('action'=>'admin_edit', $dvd['Dvd']['id']) );?>
                <?php echo $html->link('Delete', array('action'=>'admin_delete', $dvd['Dvd']['id']), null, sprintf('Are you sure you want to delete Dvd: %s?', $dvd['Dvd']['name']));?>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
	else:
		echo 'There are currently no DVDs in the database.';
	endif;
	?>

    <ul class="actions">
		<li><?php echo $html->link('Add a DVD', array('action'=>'add')); ?></li>
		<li><?php echo $html->link('Logout', array('action'=>'logout', 'controller'=>'users', 'admin'=>false)); ?></li>
	</ul>
</div>