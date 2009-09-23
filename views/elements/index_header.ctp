<div id="wrapper-header">
	<div id="header">
		<div class="logo">
			<h1>CakeCatalog</h1>
			<h2>an online application to track and catalog your collection of dvds built using cakephp</h2>
		</div>

		<div class="filters">
<?php
            echo $form->create(null, array(
                'type' => 'post',
                'action' => 'index'
            ));
?>
				<fieldset>
					<div class="input">
						<?php echo $form->input('format', array(
							'label'		=> '',
							'type'		=> 'select',
							'options'	=> $formats,
							'selected'	=> $this->data['format']
							)); ?>
					</div>
					<div class="input">
						<?php echo $form->input('type', array(
							'label'		=> '',
							'type'		=> 'select',
							'options'	=> $types,
							'selected'	=> $this->data['type']
							)); ?>
					</div>
					<div class="input">
						<?php echo $form->input('location', array(
							'label'		=>'',
							'type'		=>'select',
							'options'	=>$locations,
							'selected'	=> $this->data['location']
						)); ?>
					</div>
					<div class="input">
						<?php echo $form->input('genre', array(
							'label'		=> '',
							'type'		=> 'select',
							'options'	=> $genres,
							'selected'	=> $this->data['genre']
							)); ?>
					</div>
					<div class="clear"></div>
					<div class="input">
						<?php echo $form->input('search', array(
							'label'		=> '',
							'type'		=> 'text',
							'value'		=> $this->data['search']
							)); ?>
					</div>
					<div class="input buttons">
						<button type="submit" name="data[filter]" value="filter">Filter</button>
						<button type="submit" name="data[reset]" value="reset">Reset</button>
					</div>
				</fieldset>
<?php
            echo $form->end();
?>
		</div>
	</div>
</div>