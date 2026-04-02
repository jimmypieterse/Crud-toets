<?php
require_once 'functions.php';

$id = $_POST['idbestemming'] ?? $_GET['idbestemming'] ?? null;

if (!$id) {
    die("Geen ID ontvangen.");
}

$bestemming = getBestemmingById($id);

if (!$bestemming) {
    die("Bestemming niet gevonden.");
}

if (isset($_POST['update'])) {
    updateBestemming($_POST);
    header("Location: index.php?msg=gewijzigd");
    exit;
}
?>
<h1>Bestemming wijzigen</h1>

<form method="post">
    <input type="hidden" name="idbestemming" value="<?= $bestemming['idbestemming'] ?>">

    Plaats: <input type="text" name="plaats" value="<?= $bestemming['plaats'] ?>" required><br><br>
    Land: <input type="text" name="land" value="<?= $bestemming['land'] ?>" required><br><br>
    Werelddeel: <input type="text" name="werelddeel" value="<?= $bestemming['werelddeel'] ?>" required><br><br>

    <button type="submit" name="update">Wijzig</button>
</form>

<a href="index.php">Terug</a>


