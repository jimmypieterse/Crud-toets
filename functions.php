<?php
// Auteur: Jimmy
// Functie: eigen gemaakte functies voor CRUD (reizen -> bestemming)

/* -------------------------
   Hulpfuncties
--------------------------*/

function nl() {
    echo "<br>";
}

function nls($aantal_regels) {
    for ($i = 0; $i < $aantal_regels; $i++) {
        echo "<br>";
    }
}

function printMijnNaam() {
    echo "Mijn naam is: Jimmy";
    nl();
}

/* -------------------------
   Database connectie
--------------------------*/

function connectDb() {
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "reizen";   // <<< BELANGRIJK: database 'reizen'

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        die("Database fout: " . $e->getMessage());
    }
}

/* =========================================================
   BESTEMMING – CRUD FUNCTIES
   Tabelstructuur (zoals opdracht):
   idbestemming VARCHAR(5) PRIMARY KEY
   plaats       VARCHAR(25)
   land         VARCHAR(25)
   werelddeel   VARCHAR(20)
========================================================= */

/* -------------------------
   Bestemming: alle records ophalen
--------------------------*/
function getBestemmingen() {
    $conn = connectDb();
    $stmt = $conn->prepare("SELECT * FROM bestemming");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* -------------------------
   Bestemming: één record ophalen
--------------------------*/
function getBestemmingById($id) {
    $conn = connectDb();
    $stmt = $conn->prepare("SELECT * FROM bestemming WHERE idbestemming = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* -------------------------
   Bestemming: toevoegen
--------------------------*/
function insertBestemming($post) {
    $conn = connectDb();

    $sql = "INSERT INTO bestemming (idbestemming, plaats, land, werelddeel)
            VALUES (:idbestemming, :plaats, :land, :werelddeel)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        ':idbestemming' => $post['idbestemming'],
        ':plaats'       => $post['plaats'],
        ':land'         => $post['land'],
        ':werelddeel'   => $post['werelddeel']
    ]);
}

/* -------------------------
   Bestemming: wijzigen
--------------------------*/
function updateBestemming($post) {
    $conn = connectDb();

    $sql = "UPDATE bestemming
            SET plaats = :plaats, land = :land, werelddeel = :werelddeel
            WHERE idbestemming = :idbestemming";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        ':plaats'       => $post['plaats'],
        ':land'         => $post['land'],
        ':werelddeel'   => $post['werelddeel'],
        ':idbestemming' => $post['idbestemming']
    ]);
}

/* -------------------------
   Bestemming: verwijderen
--------------------------*/
function deleteBestemming($id) {
    $conn = connectDb();
    $stmt = $conn->prepare("DELETE FROM bestemming WHERE idbestemming = :id");
    return $stmt->execute([':id' => $id]);
}

/* -------------------------
   Bestemming: CRUD tabel printen
--------------------------*/
function printBestemmingTabel($data) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Plaats</th>
            <th>Land</th>
            <th>Werelddeel</th>
            <th>Wijzig</th>
            <th>Verwijder</th>
          </tr>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>{$row['idbestemming']}</td>";
        echo "<td>{$row['plaats']}</td>";
        echo "<td>{$row['land']}</td>";
        echo "<td>{$row['werelddeel']}</td>";

        echo "<td>
                <form method='post' action='update.php' style='display:inline;'>
                    <input type='hidden' name='idbestemming' value='{$row['idbestemming']}'>
                    <button type='submit'>WZG</button>
                </form>
              </td>";

        echo "<td>
                <form method='post' action='delete.php' style='display:inline;'>
                    <input type='hidden' name='idbestemming' value='{$row['idbestemming']}'>
                    <button type='submit'>DEL</button>
                </form>
              </td>";

        echo "</tr>";
    }

    echo "</table>";
}

/* -------------------------
   Bestemming: hoofdmenu
--------------------------*/
function bestemmingMain() {
    echo "<h1>CRUD Bestemmingen</h1>";
    echo "<a href='insert.php'>Nieuwe bestemming toevoegen</a><br><br>";

    $result = getBestemmingen();
    printBestemmingTabel($result);
}

?>

