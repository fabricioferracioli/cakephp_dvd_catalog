<?php

// file: /app/views/dvds/admin_edit.ctp

?>

<div class="dvds form">

<?php
// if there was an error uploading the file then display errors here
if(isset($errors)) {
	echo $misc->display_errors($errors);
}
?>

<?php echo $form->create('Dvd', array('type'=>'file'));?>
	<fieldset>
 		<legend>Edit a Dvd</legend>
		<?php
		// create the form inputs

		// include the id of the DVD as a form input
		// CakePHP will automatically create this as a hidden element
		echo $form->input('id');
		echo $form->input('name', array('label'=>'Name: *'));
        echo $form->input('name_pt_br', array('label' => __('Titulo em português', true).': '));
		echo $form->input('format_id', array('label'=>'Format: *', 'type'=>'select', 'options'=>$formats));
		echo $form->input('type_id', array('label'=>'Type: *', 'class'=>'type_select'));
		echo $form->input('location_id', array('label'=>'Location: *'));

		// display image if it exists
		if(!empty($this->data['Dvd']['image'])): ?>
		<div class="input">
			<label>Current Image:</label>
			<img src="/<?php echo $this->data['Dvd']['image']; ?>" alt="Dvd Image" width="100" />
		</div>
		<?php endif;

		echo $form->input('File.image', array('label'=>'Image:', 'type'=>'file'));
		echo $form->input('rating', array('label'=>'Rating:'));
		echo $form->input('website', array('label'=>'Website URL:'));
		echo $form->input('imdb', array('label'=>'Imdb URL:'));
		echo $form->input('discs', array('label'=>'Number of Discs:', 'class'=>'tv_hide'));
		echo $form->input('episodes', array('label'=>'Number of Episodes:', 'class'=>'tv_hide'));
		echo $form->input('genres', array('label'=>'Genres:', 'type'=>'text', 'value'=>$genres_str));
		?>
	</fieldset>
<?php echo $form->end('Save');?>
</div>

<ul class="actions">
    <li><?php echo $html->link('List DVDs', array('action'=>'index'));?></li>
	<li><?php echo $html->link('Add a DVD', array('action'=>'add'));?></li>
</ul>