<?php

// file: /app/views/formats/index.ctp

?>
<div class="formats index">

	<h2>Formats Index</h2>
    <p>Currently displaying all formats in the application.</p>

    <?php
	// check $formats variable exists and is not empty
	if(isset($formats) && !empty($formats)) :
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

			// loop through and display format
			foreach($formats as $format):
				// stripes the table by adding a class to every other row
				$class = ( ($count % 2) ? " class='altrow'": '' );
				// increment count
				$count++;
			?>
            <tr<?php echo $class; ?>>
                <td><?php echo $format['Format']['name']; ?></td>
                <td><?php echo $format['Format']['desc']; ?></td>
                <td><?php echo $format['Format']['created']; ?></td>
                <td>
                <?php echo $html->link('View', array('action'=>'view', $format['Format']['slug'])); ?>
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
</div>