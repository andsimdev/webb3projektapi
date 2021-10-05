<?php
include_once("config.php");

// TEST STUDY
//$study = new Study;

// Skapa
//var_dump($study->createStud("Testtitel", "universitetet i mitten", "2020-08-31", "2022-06-01"));

// Ändra
//var_dump($study->changeStud(3, "Ändrad titel", "Uppsala universitet", "Augusti 2020", "Juni 2021"));

// Radera
//var_dump($study->deleteStud(4));

// Hämta alla
//var_dump($study->getStud());


// TEST EMPLOYMENT
//$employment = new Employment;

// Skapa
//var_dump($employment->createEmp("Lärare", "Stockholms Universitet", "Januari 2019", "Juni 2020"));

// Ändra
//var_dump($employment->changeEmp(5, "Lärareeee", "södertälje Universitet", "Juni 2001", "Mars 2008"));

// Radera
//var_dump($employment->deleteEmp(2));

// Hämta alla
//var_dump($employment->getEmp());


// TEST WEBSITE
$website = new Website;

// Skapa
var_dump($website->createSite("Första webbsidan", "www.aftonbladet.se", "En nyhetswebbplats", "media/images/sol.png"));

// Ändra
var_dump($website->changeSite(1, "Första webbsidan fast ändrad", "www.aftonbladet.se", "En ännu bättre nyhetswebbplats", "media/images/mane.png"));

// Radera
var_dump($website->deleteSite(2));

// Hämta alla
var_dump($website->getSites());