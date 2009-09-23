<?php
// get most active dvds
$most_active = $this->requestAction('dvds/footer/sort:views/direction:desc/limit:5');
// loop through dvds
$dvds = array();
foreach($most_active as $dvd) {
    array_push($dvds, $html->link($dvd['Dvd']['name'], array(
            'controller' => 'dvds',
            'action' => 'view',
            $dvd['Dvd']['slug']
        )
    ));
}

echo $html->nestedList($dvds, array(), array(), 'ol');
?>