<?php

// file: /app/views/locations/admin_edit.ctp

?>
<div class="locations form">
<?php echo $form->create('Location');?>
	<fieldset>
 		<legend>Edit Location</legend>
		<?php
		// a hidden form input field, required in a edit form
		echo $form->input('id', array('type'=>'hidden'));
		// create the form inputs
		echo $form->input('name', array('label'=>'Name: *'));
		echo $form->input('desc', array('label'=>'Description:', 'type'=>'textarea'));
		?>
	</fieldset>
<?php echo $form->end('Edit');?>
</div>

<?php if(!empty($this->data['Dvd'])): ?>

<div class="related">
	<h3>DVDs with this Location</h3>
	<table>
    	<thead>
        	<tr>
            	<th>Id</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($this->data['Dvd'] as $dvd): ?>
        	<tr>
            	<td><?php echo $dvd['id']; ?></td>
                <td><?php echo $dvd['name']; ?></td>
                <td><?php echo $html->link('Edit', '/admin/dvds/edit/'.$dvd['id']);?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>

<ul class="actions">
    <li><?php echo $html->link('List Locations', array('action'=>'index'));?></li>
</ul>