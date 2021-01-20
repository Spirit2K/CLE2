<?php
// lees het config-bestand
require_once 'config.inc.php';

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Prototype</title>
</head>

<h4>Lijst van alle reserveringen</h4>


<table class='topBefore' border="1">


<tr>
    <th>Naam:</th>
    <th>E-Mail:</th>
    <th>Aantal Personen:</th>
    <th>Datum:</th>
    <th>Tijd:</th>
    <th>Telefoonnummer:</th>
    <th>Opmerking:</th>
</tr>
<?php

    $result = mysqli_query($mysqli, "SELECT * FROM reservering");
    // loop door alle rijen data heen
    while ($row = mysqli_fetch_array($result)) {
        // start een tabelrij 
        echo "<tr>";

        // maak de cellen voor de gegevens
        echo "<td>" . $row['naam'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['aantalpersonen'] . "</td>";
        echo "<td>" . $row['datum'] . "</td>";
        echo "<td>" . $row['tijd'] . "</td>";
        echo "<td>" . $row['telefoon'] . "</td>";
        echo "<td>" . $row['opmerking'] . "</td>";
        //echo "<td><a href='reserveringbewerken.php?id=" . $row['id'] . "'>Bewerk</a></td>";

        // sluit de tabelrij
        echo "</tr>";
    }

?>

</table>

</body>
</html>
