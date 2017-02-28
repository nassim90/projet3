<?php

// Return all articles
function getBillets() {
    $bdd = new PDO('mysql:host=localhost;dbname=moncms;charset=utf8', 'root', '');
    $billets = $bdd->query('select * from billets order by date_creation desc');
    return $billets;
}