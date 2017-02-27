<?php
// Data access
$bdd = new PDO('mysql:host=localhost;dbname=moncms;charset=utf8', 'root', '');
$billets = $bdd->query('select * from billets order by date_creation desc');

// Data display

require 'model.php';

require 'view.php';