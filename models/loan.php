<?php

    class Loan extends AppModel
    {
        var $name = 'Loan';

        var $belongsTo = array('Dvd');
    }

?>