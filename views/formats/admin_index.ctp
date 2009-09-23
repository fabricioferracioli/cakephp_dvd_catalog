<?php

// file: /app/views/formats/admin_index.ctp

?>
<div class="formats index">

	<h2>Formats Admin Index</h2>
    <p>Currently displaying all formats in the application.</p>

    <?php
	// check $formats variable exists and is not empty
	if(isset($formats) && !empty($formats)) :
	?>

    <table>
    	<thead>
        	<tr>
            	<th>Id</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php
			// initialise a counter for striping the table
			$count = 0;

			// loop through and display format
			foreach($formats as $format):
				// stripes the table by adding a class to every other row
				$class = ( ($count % 2) ? " class='altrow'": '' );
				// increment count
				$count++;
			?>
            <tr<?php echo $class; ?>>
            	<td><?php echo $format['Format']['id']; ?></td>
                <td><?php echo $format['Format']['name']; ?></td>
                <td><?php echo $format['Format']['slug']; ?></td>
                <td><?php echo $format['Format']['desc']; ?></td>
                <td><?php echo $format['Format']['created']; ?></td>
                <td><?php echo $format['Format']['modified']; ?></td>
                <td>
                <?php echo $html->link('Edit', array('action'=>'admin_edit', $format['Format']['id']) );?>
                <?php echo $html->link('Delete', array('action'=>'admin_delete', $format['Format']['id']), null, sprintf('Are you sure you want to delete Format: %s?', $format['Format']['name']));?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php
	else:
		echo 'There are currently no Formats in the database.';
	endif;
	?>
    
	<ul class="actions">
		<li><?php echo $html->link('Add a Format', array('action'=>'add')); ?></li>
	</ul>

</div>