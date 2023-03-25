<?php

    require_once('./Router.php');
    require_once('./Application.php');

    header('Content-Type: application/json');

    $app = new Application();
    $app->execute();

?>