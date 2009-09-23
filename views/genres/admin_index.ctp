<?php

// file: /app/views/genres/admin_index.ctp

?>
<div class="genres index">

	<h2>Genres Admin Index</h2>
    <p>Currently displaying all Genres in the application</p>

    <?php
	// check $genres variable exists and is not empty
	if(isset($genres) && !empty($genres)) :
	?>

    <table class="stripe">
    	<thead>
        	<tr>
				<th>Name</th>
				<th>Created</th>
				<th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($genres as $genre): ?>
            <tr>
				<td><?php echo $genre['Genre']['name']; ?></td>
				<td><?php echo $genre['Genre']['created']; ?></td>
				<td><?php echo $genre['Genre']['modified']; ?></td>
				<td>
				<?php echo $html->link('Edit', array('action'=>'admin_edit', $genre['Genre']['id']) );?>
                <?php echo $html->link('Delete', array('action'=>'admin_delete', $genre['Genre']['id']), null, sprintf('Are you sure you want to delete Genre: %s?', $genre['Genre']['name']));?>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
	else:
		echo 'There are currently no Genres in the database.';
	endif;
	?>
    
    <ul class="actions">
		<li><?php echo $html->link('Add a Genre', array('action'=>'add')); ?></li>
	</ul>
</div>