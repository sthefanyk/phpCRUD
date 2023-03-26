<?php

    include_once '../backend/html_build.php';
    include_once '../backend/file_manager.php';

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    if (remove($_REQUEST["cpf"])) {
        header('Location: read.php');
    }

?>