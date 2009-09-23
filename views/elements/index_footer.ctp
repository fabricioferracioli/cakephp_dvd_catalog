<div id="wrapper-footer">
	<div id="footer">
		<div class="box top-rated">
			<h2>Top Rated</h2>
			<?php echo $this->element('top_rated', array('cache'=>'+1 hour'));?>
		</div>

		<div class="box recently-added">
			<h2>Recently Added</h2>
			<?php echo $this->element('recently_added', array('cache'=>'+1 hour'));?> 
		</div>

		<div class="box top-genres">
			<h2>Top Genres</h2>
			<?php echo $this->element('top_genres', array('cache'=>'+1 hour'));?> 
		</div>

		<div class="box most-active box-last">
			<h2>Most Active</h2>
			<?php echo $this->element('most_active', array('cache'=>'+1 hour'));?> 
		</div>
		<div class="clear"></div>

		<div class="copyright">

			<p>built using <a href="http://www.cakephp.org" target="_blank">CakePHP</a> by 
			<a href="http://www.jamesfairhurst.co.uk" target="_blank">James Fairhurst</a></p>
		</div>
	</div>
</div>