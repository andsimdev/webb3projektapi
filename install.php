<?php
// INSTALLATIONSFIL, RADERA DENNA EFTER PUBLICERING

// Inkludera config-fil för att få med databasinställningar
include("config.php");

// Anslut till databasen
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
// Kontrollera om fel finns vid anslutningen
if ($db->connect_errno > 0) {
    die('Fel vid anslutning [' . $db->connect_error . ']');
}

// Skapa SQL-fråga för att skapa tabeller
$sql =
    "
DROP TABLE IF EXISTS studies;
CREATE TABLE studies(
    studID INT(9) PRIMARY KEY AUTO_INCREMENT,
    studtitle VARCHAR(255) NOT NULL,
    university VARCHAR(255) NOT NULL,
    studstartdate VARCHAR(64) NOT NULL,
    studenddate VARCHAR(64) NOT NULL
);
DROP TABLE IF EXISTS employments;
CREATE TABLE employments(
    empID INT(9) PRIMARY KEY AUTO_INCREMENT,
    emptitle VARCHAR(255) NOT NULL,
    empplace VARCHAR(255) NOT NULL,
    empstartdate VARCHAR(64) NOT NULL,
    empenddate VARCHAR(64) NOT NULL
);
DROP TABLE IF EXISTS websites;
CREATE TABLE websites(
    siteID INT(9) PRIMARY KEY AUTO_INCREMENT,
    sitetitle VARCHAR(255) NOT NULL,
    siteurl VARCHAR(255) NOT NULL,
    sitedesc TEXT NOT NULL,
    siteimage VARCHAR(255) NOT NULL
);
";

// Skriv ut vilken SQL-fråga som skickas till databasen
echo "<h1>Följande SQL-fråga skickades till databsen:</h1>
<pre>" . $sql . "</pre>";

// Skicka SQL-frågan till databasen
if ($db->multi_query($sql)) {
    // Skriv ut meddelande vid lyckad SQL-fråga
    echo "<br><h2 style='color:green;'>Tabeller installerade. Kom ihåg att radera install-filen.</h2>";
} else {
    echo "<br><h2 style='color:red;'>Tabeller kunde ej installeras, fel vid anrop till databasen</h2>";
}