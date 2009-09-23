<?php

// file: /app/views/types/index.ctp

?>
<div class="types index">

	<h2>Types Index</h2>
    <p>Currently displaying all types in the application.</p>

    <?php
	// check $types variable exists and is not empty
	if(isset($types) && !empty($types)) :
	?>

    <table>
    	<thead>
        	<tr>
                <th>Name</th>
                <th>Description</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php
			// initialise a counter for striping the table
			$count = 0;

			// loop through and display types
			foreach($types as $type):
				// stripes the table by adding a class to every other row
				$class = ( ($count % 2) ? " class='altrow'": '' );
				// increment count
				$count++;
			?>
            <tr<?php echo $class; ?>>
                <td><?php echo $type['Type']['name']; ?></td>
                <td><?php echo $type['Type']['desc']; ?></td>
                <td><?php echo $type['Type']['created']; ?></td>
                <td>
                <?php echo $html->link('View', array('action'=>'view', $type['Type']['slug'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php
	else:
		echo 'There are currently no Types in the database.';
	endif;
	?>
</div>