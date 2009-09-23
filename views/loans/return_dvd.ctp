<?php
    if ($session->check('Message.flash'))
    {
        echo $session->flash();
    }
?>