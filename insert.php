<?php
require_once 'functions.php';

if (isset($_POST['btn_ins'])) {
    if (insertBestemming($_POST)) {
        header("Location: index.php?msg=toegevoegd");
        exit;
    }
}
?>
<h1>Nieuwe bestemming toevoegen</h1>

<form method="post">
    ID (bijv. B001): <input type="text" name="idbestemming" required><br><br>
    Plaats: <input type="text" name="plaats" required><br><br>
    Land: <input type="text" name="land" required><br><br>
    Werelddeel: <input type="text" name="werelddeel" required><br><br>

    <button type="submit" name="btn_ins">Opslaan</button>
</form>

<a href="index.php">Terug</a>
