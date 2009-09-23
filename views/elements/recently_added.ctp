<?php
// get recently added dvds
$recently_added = $this->requestAction('dvds/footer/sort:created/direction:desc/limit:5');
// loop through dvds
$dvds = array();
foreach($recently_added as $dvd) {
        array_push($dvds, $html->link($dvd['Dvd']['name'], array(
            'controller' => 'dvds',
            'action' => 'view',
            $dvd['Dvd']['slug']
        )
    ));
}
echo $html->nestedList($dvds, array(), array(), 'ol');
?>