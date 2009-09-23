<?php

// file: /app/views/genres/index.ctp

?>
<div class="genres index">

	<h2>Genres Index</h2>
    <p>Currently displaying all Genres in the application</p>

    <?php
	// check $genres variable exists and is not empty
	if(isset($genres) && !empty($genres)) :
	?>

    <table class="stripe">
    	<thead>
        	<tr>
				<th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($genres as $genre): ?>
            <tr>
				<td><?php echo $genre['Genre']['name']; ?></td>
				<td>
				<?php echo $html->link('View', array('action'=>'view', $genre['Genre']['slug'])); ?>
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
</div>