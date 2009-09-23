<?php
    echo $javascript->link('prototype');
// page: /app/views/dvds/view.ctp

?>

<div class="dvds view">
	<h2><?php echo $dvd['Dvd']['name']; ?></h2>
<?php
    echo $html->image($dvd['Dvd']['image'], array(
        'alt' => 'DVD Image'
    ));
?>
    <dl>
    	<dt>Name:</dt>
        <dd><?php echo $html->link($dvd['Dvd']['name'], $dvd['Dvd']['imdb']); ?></dd>

        <dt>Format:</dt>
        <dd><?php echo $dvd['Format']['name']; ?></dd>

        <dt>Type:</dt>
        <dd><?php echo $dvd['Type']['name']; ?></dd>

        <dt>Location:</dt>
        <dd><?php echo $dvd['Location']['name']; ?></dd>

		<dt>Rating:</dt>
        <dd><?php echo $dvd['Dvd']['rating']; ?></dd>

		<dt>Genres:</dt>
		<dd><?php echo $dvd['Dvd']['genres']; ?></dd>

        <dt>Emprestado:</dt>
        <dd>
<?php
            if (empty($dvd['Loan']))
            {
                echo $ajax->form(
                    array(
                        'type' => 'post',
                        'options' => array(
                            'model' => 'Loan',
                            'update' => 'operation_status',
                            'url' => array(
                                'controller' => 'loans',
                                'action' => 'loan_dvd'
                            )
                        )
                    )
                );
                echo $form->input('Loan.name');
                echo $form->input('Loan.dvd_id', array('type' => 'hidden', 'value' => $dvd['Dvd']['id']));
                echo $form->end('Emprestar');

            }
            else
            {
                echo $ajax->form(
                    array(
                        'type' => 'post',
                        'options' => array(
                            'model' => 'Loan',
                            'update' => 'operation_status',
                            'url' => array(
                                'controller' => 'loans',
                                'action' => 'return_dvd'
                            )
                        )
                    )
                );
                echo $dvd['Loan'][0]['name'];
                echo $form->input('Loan.id', array('type' => 'hidden', 'value' => $dvd['Loan'][0]['id']));
                echo $form->end('Devolver');
            }

            echo $html->div(null, null, array('id' => 'operation_status'));
?>
        </dd>
    </dl>


    <ul class="actions">
    	<li><?php echo $html->link('List DVDs', array('action'=>'index'));?></li>
	</ul>
</div>