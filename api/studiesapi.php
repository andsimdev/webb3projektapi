<?php
// Inkludera config-fil för att autoinkludera klasser
include("$_SERVER[DOCUMENT_ROOT]/webbutveckling3/projekt/php/config.php");

/*Headers med inställningar*/
// Gör att webbtjänsten går att komma åt från alla domäner
header('Access-Control-Allow-Origin: *');

// Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

// Vilka metoder som webbtjänsten accepterar
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

// Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

// Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Skapa instans av klassen Study
$study = new Study;

// Kör olika case beroende på vilken anropsmetod som använts
switch ($method) {
    case 'GET':
        // Kontrollera om id skickats med för att hämta specifik post
        if (isset($id)) {
            // Säkerställ att medskickat id är numeriskt värde
            $id = intval($id);            
            // Anropa metoden för att hämta enskild post. Skicka med responskod.
            $response = $study->getSinglestud($id);
            http_response_code(200); // Lyckad request
        } else {
            // Anropa metoden för att hämta alla studie-poster. Skicka med responskod.
            $response = $study->getStud();
            http_response_code(200); // Lyckad request
        }

        break;
    case 'POST':
        // Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        // Kontrollera att $data ej är tom, annars skicka felmeddelande
        if ($data != "") {
            // Bryt ut de olika delarna från medskickad data och lagra som sträng-variabler
            $studtitle = strval($data->{'studtitle'});
            $university = strval($data->{'university'});
            $studstartdate = strval($data->{'studstartdate'});
            $studenddate = strval($data->{'studenddate'});

            // Anropa metoden för att lagra medskickad data i databasen, kontrollera om anropet lyckas
            if ($study->createStud($studtitle, $university, $studstartdate, $studenddate)) {
                // Returnera responskod
                http_response_code(201); //Created
                $response = array("message" => "Ny studiepost skapad");
            } else { // Vid misslyckat anrop
                // Returnera responskod
                http_response_code(500); // Fel på serversidan
                $response = array("message" => "Fel vid anrop. Studiepost kunde inte skapas. Kontrollera medskickad data och försök igen.");
            }
        } else {
            // Returnera responskod
            http_response_code(400); // Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "Fel vid anrop. Studiepost kunde inte skickas. Kontrollera medskickad data och försök igen.");
        }

        break;
    case 'PUT':

        //Om inget id är med skickat, skicka felmeddelande
        if (!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");

            //Om id är skickad   
        } else {
            // Lagra medskickad data i $data
            $data = json_decode(file_get_contents("php://input"));

            // Kontrollera att data ej är tom
            if ($data != "") {

                // Bryt ut de olika delarna från medskickad data och lagra som variabler med rätt typ
                $studID = intval($id);
                $studtitle = strval($data->{'studtitle'});
                $university = strval($data->{'university'});
                $studstartdate = strval($data->{'studstartdate'});
                $studenddate = strval($data->{'studenddate'});

                // Anropa metoden för att uppdatera medskickad data i databasen, kontrollera om anropet lyckas
                if ($study->changeStud($studID, $studtitle, $university, $studstartdate, $studenddate)) {
                    // Returnera responskod
                    http_response_code(200); // Lyckad förfrågan
                    $response = array("message" => "Studieposten är uppdaterad");
                } else { // Vid misslyckat anrop
                    // Returnera responskod
                    http_response_code(500); // Fel på serversidan
                    $response = array("message" => "Fel vid anrop. Studiepost kunde inte uppdateras i databasen. Kontrollera medskickad data och försök igen.");
                }

            } else {
                // Skicka felmeddelande och statuskod att data saknas
                http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
                $response = array("message" => "No data is sent");
            }
        }

        break;
    case 'DELETE':
        // Kontrollera att id är medskickat
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } else {
            // Säkerställ att medskickat id är numeriskt värde
            $id = intval($id);

            // Anropa metoden för att radera post från databasen
            if($study->deleteStud($id)) {
                // Ange lyckad status om anrop lyckades
                http_response_code(200);
                $response = array("message" => "Studieposten med id $id raderades");
            } else {
                // Ange felmeddelande och statuskod om misslyckat anrop
                http_response_code(500);
                $response = array("message" => "Studieposten kunde inte raderas från databasen");                
            }
        }
        break;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);