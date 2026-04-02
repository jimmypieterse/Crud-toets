<?php
require_once 'functions.php';

$id = $_POST['idbestemming'] ?? $_GET['idbestemming'] ?? null;

if (!$id) {
    die("Geen ID ontvangen.");
}

deleteBestemming($id);

header("Location: index.php?msg=verwijderd");
exit;


