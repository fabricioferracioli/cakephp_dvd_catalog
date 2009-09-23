
<?php
// get top rated dvds
// i'm using the paginator so i can specifiy sql statements here
$top_rated = $this->requestAction('dvds/footer/sort:rating/direction:desc/limit:5');
// loop through dvds
$dvds = array();
foreach($top_rated as $dvd) {
        array_push($dvds, $html->link($dvd['Dvd']['name'], array(
            'controller' => 'dvds',
            'action' => 'view',
            $dvd['Dvd']['slug']
        )
    ));
}
echo $html->nestedList($dvds, array(), array(), 'ol');
?>