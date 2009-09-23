<?php

// page: /app/views/locations/view.ctp

?>

<div class="locations view">
	<h2>Viewing Location: <?php echo $location['Location']['name']; ?></h2>
    
    <dl>
    	<dt>Name:</dt>
        <dd><?php echo $location['Location']['name']; ?></dd>
        
        <dt>Description:</dt>
        <dd><?php echo $location['Location']['desc']; ?></dd>
        
        <dt>Created</dt>
        <dd><?php echo $location['Location']['created']; ?></dd>
    </dl>
    
    <?php if(!empty($type['Dvd'])): ?>
    
    <div class="related">
        <h3>DVDs with this Location</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($location['Dvd'] as $dvd): ?>
                <tr>
                    <td><?php echo $dvd['name']; ?></td>
                    <td><?php echo $html->link('View', '/dvds/view/'.$dvd['slug']);?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php endif; ?>
    
    <ul class="actions">
    	<li><?php echo $html->link('List Locations', array('action'=>'index'));?></li>
	</ul>
</div>