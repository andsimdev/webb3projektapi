<?php
// Inkludera config-fil för att autoinkludera klasser
include("config.php");

/*Headers med inställningar*/
// Gör att webbtjänsten går att komma åt från alla domäner
header('Access-Control-Allow-Origin: *');

// Talar om att webbtjänsten skickar data i JSON-format
//header('Content-Type: application/json');

// Vilka metoder som webbtjänsten accepterar
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

// Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
//header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

// Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Skapa instans av klassen Website
$web = new Website;

// Kör olika case beroende på vilken anropsmetod som använts
switch ($method) {
    case 'GET':
        // Kontrollera om id skickats med för att hämta specifik post
        if (isset($id)) {
            // Säkerställ att medskickat id är numeriskt värde
            $id = intval($id);
            // Anropa metoden för att hämta enskild post. Skicka med responskod.
            $response = $web->getSinglesite($id);
            http_response_code(200); // Lyckad request
        } else {
            // Anropa metoden för att hämta alla poster. Skicka med responskod.
            $response = $web->getSites();
            http_response_code(200); // Lyckad request
        }

        break;
    case 'POST':
        // Läser in medskickad data, lagras som array
        $data = $_POST;

        // Kontrollera att bild är medskickad
        if (isset($_FILES['siteimage'])) {

            // Generera unikt namn för bilden
            $imagename = uniqid() . ".png";

            // Läs in medskickad bild
            $image = $_FILES['siteimage'];

            // Flytta medskickad bild till katalogen bilder
            move_uploaded_file($_FILES['siteimage']["tmp_name"], "uploads/" . $imagename);

            // Lagra relativ url till bilden
            $imageurl = "uploads/" . $imagename;
        }

        
        // Kontrollera att $data ej är tom, annars skicka felmeddelande
        if ($data != "") {
            // Bryt ut de olika delarna från medskickad data och lagra som sträng-variabler
            $sitetitle = strval($data['sitetitle']);
            $siteurl = strval($data['siteurl']);
            $sitedesc = strval($data['sitedesc']);
            $siteimage = strval($imageurl);

            // Anropa metoden för att lagra medskickad data i databasen, kontrollera om anropet lyckas
            if ($web->createSite($sitetitle, $siteurl, $sitedesc, $siteimage)) {
                // Returnera responskod
                http_response_code(201); //Created
                $response = array("message" => "Ny webbsidepost skapad");
            } else { // Vid misslyckat anrop
                // Returnera responskod
                http_response_code(500); // Fel på serversidan
                $response = array("message" => "Fel vid anrop. webbsidepost kunde inte skapas. Kontrollera medskickad data och försök igen.");
            }
        } else {
            // Returnera responskod
            http_response_code(400); // Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "Fel vid anrop. Webbsidepost kunde inte skickas. Kontrollera medskickad data och försök igen.");
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
                $siteID = intval($id);
                $sitetitle = strval($data->{'sitetitle'});
                $siteurl = strval($data->{'siteurl'});
                $sitedesc = strval($data->{'sitedesc'});
                $siteimage = strval($data->{'siteimage'});

                // Anropa metoden för att uppdatera medskickad data i databasen, kontrollera om anropet lyckas
                if ($web->changeSite($siteID, $sitetitle, $siteurl, $sitedesc, $siteimage)) {
                    // Returnera responskod
                    http_response_code(200); // Lyckad förfrågan
                    $response = array("message" => "Webbsideposten är uppdaterad");
                } else { // Vid misslyckat anrop
                    // Returnera responskod
                    http_response_code(500); // Fel på serversidan
                    $response = array("message" => "Fel vid anrop. Webbsidepost kunde inte uppdateras i databasen. Kontrollera medskickad data och försök igen.");
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
            if ($web->deleteSite($id)) {
                // Ange lyckad status om anrop lyckades
                http_response_code(200);
                $response = array("message" => "Webbsideposten med id $id raderades");
            } else {
                // Ange felmeddelande och statuskod om misslyckat anrop
                http_response_code(500);
                $response = array("message" => "Webbsideposten kunde inte raderas från databasen");
            }
        }
        break;
}

if(isset($response)) {
//Skickar svar tillbaka till avsändaren
echo json_encode($response);
}