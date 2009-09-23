<?php

// page: /app/views/genres/view.ctp

?>
<div id="wrapper-contents">
	<div id="contents">

		<div class="genres index">
		<h2>Viewing Genre: <?php echo $genre['Genre']['name']; ?></h2>
		
		<?php
		// check $dvds variable exists and is not empty
		if(isset($genre['Dvd']) && !empty($genre['Dvd'])) :
			// init dvd count
			$count = 1;
		?>
		<div class="shelf">
			
			<?php foreach($genre['Dvd'] as $key=>$dvd): ?>
				<?php
				// calculate if this dvd is the last on the shelf
				// if dvd number can be divided by 8 with no remainders
				$last_dvd = ( (($count) % 8 == 0)? 'dvd-last' : '' );
				?>

				<div class="dvd <?php echo $last_dvd; ?>">
					<a href="/dvds/view/<?php echo $dvd['slug']; ?>">
					<!--
					<img src="/<?php echo $dvd['image']; ?>" alt="DVD Image: <?php echo $dvd['name'] ?>" width="100" height="150" />
					-->
					<img src="/images/view/100/150/true/<?php echo $dvd['image']; ?>" alt="DVD Image: <?php echo $dvd['name'] ?>" width="100" height="150" />
					</a>
				</div>

				<?php
				// if this is the last dvd, close the shelf div and create a new one
				if(!empty($last_dvd)) {
					echo '<div class="clear"></div>';
					echo '</div>';
					echo '<div class="shelf">';
				}
				?>
			<?php $count++; ?>
			<?php endforeach; ?>
				
			<div class="clear"></div>
		</div>
	
		<?php
		else:
			echo 'There are currently no DVDs in the database.';
		endif;
		?>
		</div>
		
	</div>
</div>