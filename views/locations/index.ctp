<?php

// file: /app/views/locations/index.ctp

?>
<div class="locations index">

	<h2>Locations Index</h2>
    <p>Currently displaying all Locations in the application.</p>

    <?php
	// check $locations variable exists and is not empty
	if(isset($locations) && !empty($locations)) :
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

			// loop through and display locations
			foreach($locations as $location):
				// stripes the table by adding a class to every other row
				$class = ( ($count % 2) ? " class='altrow'": '' );
				// increment count
				$count++;
			?>
            <tr<?php echo $class; ?>>
                <td><?php echo $location['Location']['name']; ?></td>
                <td><?php echo $location['Location']['desc']; ?></td>
                <td><?php echo $location['Location']['created']; ?></td>
                <td>
                <?php echo $html->link('View', array('action'=>'view', $location['Location']['slug'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php
	else:
		echo 'There are currently no Locations in the database.';
	endif;
	?>
</div>