<?php
// Välj om utvecklingsläge är på eller av
$devMode = true;

// Visa felmeddelanden om utvecklingsläge är på
if($devMode) {
    error_reporting(-1);
    ini_set("display_errors", 1);
}

// Autoinkludera klasser
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

// Ange databasinställningar för utvecklingsläge eller publiceringsläge
if($devMode) {
    // Lokala databasinställningar
    define("DBHOST", "localhost");
    define("DBUSER", "webbutveckling3projekt");
    define("DBPASS", "password");
    define("DBDATABASE", "webbutveckling3projekt");

} else {
    // Publika databasinställningar
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "sian2001");
    define("DBPASS", "HrGrG7cmuC");
    define("DBDATABASE", "sian2001");
}