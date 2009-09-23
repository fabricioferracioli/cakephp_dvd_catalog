<?php

// file: /app/views/dvds/index.ctp

?>

<div id="wrapper-contents">
	<div id="contents">

		<div class="dvds index">
			<?php
			// check $dvds variable exists and is not empty
			if(isset($dvds) && !empty($dvds)) :
				// init dvd count
				$count = 1;
			?>
			<div class="shelf">

				<?php foreach($dvds as $key=>$dvd): ?>
					<?php
					// calculate if this dvd is the last on the shelf
					// if dvd number can be divided by 8 with no remainders
					$last_dvd = ( (($count) % 8 == 0)? 'dvd-last' : '' );
					?>

					<div class="dvd <?php echo $last_dvd; ?>">
<?php
                        $movie_image = $html->image($dvd['Dvd']['image'], array(
                            'alt' => 'Dvd Image: '.$dvd['Dvd']['name'],
                            'width' => 100,
                            'height' => 150
                        ));
                        echo $html->link($movie_image, array(
                                'controller' => 'dvds',
                                'action' => 'view',
                                $dvd['Dvd']['slug']
                            ),
                            array(),
                            false,
                            false
                        );
?>
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