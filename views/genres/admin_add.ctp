<?php

// file: /app/views/genres/admin_add.ctp

?>

<div class="genres form">

<?php echo $form->create('Genre');?>
	<fieldset>
 		<legend>Add a Genre</legend>
		<?php
		// create the form inputs
		echo $form->input('name', array('label'=>'Name: *'));
		?>
	</fieldset>
<?php echo $form->end('Add');?>
</div>

<ul class="actions">
    <li><?php echo $html->link('List Genres', array('action'=>'index'));?></li>
</ul>