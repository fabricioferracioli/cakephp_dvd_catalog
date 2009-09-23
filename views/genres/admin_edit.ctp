<?php

// file: /app/views/genres/admin_edit.ctp

?>

<div class="genres form">

<?php echo $form->create('Genre');?>
	<fieldset>
 		<legend>Edit a Genre</legend>
		<?php
		// create the form inputs
		echo $form->input('id');
		echo $form->input('name', array('label'=>'Name: *'));
		?>
	</fieldset>
<?php echo $form->end('Save');?>
</div>

<div class="related">
	<h3>Related DVDs</h3>
	<table class="stripe">
		<thead>
			<tr>
				<th>Name</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($this->data['Dvd'])): ?>
				<?php foreach($this->data['Dvd'] as $dvd): ?>
				<tr>
					<td><?php echo $dvd['name']; ?></td>
					<td><?php echo $html->link('Edit', array('action'=>'admin_edit','controller'=>'dvds', $dvd['id']) );?></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="2">There are currently no DVDs to display</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<ul class="actions">
    <li><?php echo $html->link('List Genres', array('action'=>'index'));?></li>
	<li><?php echo $html->link('Add a Genre', array('action'=>'add'));?></li>
</ul>