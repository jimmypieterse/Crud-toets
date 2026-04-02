<?php
// auteur: Jimmy
// functie: CRUD fiets in database

include_once 'config.php';
include_once 'functions.php';

// Haal alle fietsen op uit de tabel 'fietsen'
$rows = getData("reizen");

// Test output
var_dump($rows);
?>
