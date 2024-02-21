<?php
session_start();

require_once '../config.php';
require_once '../models/Enterprisejson.php';


// utiliser l'ajax pour valider ou invalider l'utilisateur
// le $_SESSION sert à empêcher l'utilisateur de revalider son compte lui-même car cela se passe côté serveur
if (isset($_GET['validate'] ) && isset($_SESSION['enterprise']))  {
    var_dump(Enterprise::getInfosUsers($_GET['validate']));

    if(Enterprise::getInfosUsers($_GET['validate'])['enterprise_id'] == $_SESSION['enterprise']['enterprise_id']) {
    Enterprise::getvalidateUser($_GET['validate']);
}}

// le $_SESSION sert à empêcher l'utilisateur d'invalider un compte
if (isset($_GET['invalidate']) && isset($_SESSION['enterprise'])) {
    Enterprise::getinvalidateUser($_GET['invalidate']);


if(Enterprise::getInfosUsers($_GET['invalidate'])['enterprise_id'] == $_SESSION['enterprise']['enterprise_id']) {
    Enterprise::getinvalidateUser($_GET['invalidate']);
}}
