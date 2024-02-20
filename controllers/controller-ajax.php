<?php

require_once '../config.php';
require_once '../models/Enterprisejson.php';


// utiliser l'ajax pour valider ou invalider l'utilisateur

if (isset($_GET['validate'])) {
    Enterprise::getvalidateUser($_GET['validate']);
}

if (isset($_GET['invalidate'])) {
    Enterprise::getinvalidateUser($_GET['invalidate']);
}