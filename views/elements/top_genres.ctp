<?php
// get top genres
$top_genres = $this->requestAction('dvds/top_genres');
// loop through dvds
$dvds = array();
foreach($top_genres as $genre=>$number) {
    array_push($dvds, $html->link(ucfirst($genre), array(
            'controller' => 'dvds',
            'action' => 'view',
            $genre
        )
    ));
}
echo $html->nestedList($dvds, array(), array(), 'ol');
?>