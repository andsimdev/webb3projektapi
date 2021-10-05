<?php

class Website
{
    // Properties
    private $db;
    private $sitetitle;
    private $siteurl;
    private $sitedesc;
    private $siteimage;

    // Konstruerare
    public function __construct()
    {
        // Ny MySQLi-anslutning
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        // Kontrollera om fel uppstår
        if ($this->db->connect_error) {
            die("Anslutning misslyckades: " . $this->db->connect_error);
        }
    }

    // HUVUDMETODER
    /**
     * Hämta alla webbside-poster
     * @return array
     */
    public function getSites(): array
    {
        // Skapa SQL-fråga för att hämta alla webbside-poster från databasen
        $sql = "SELECT * FROM websites";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Hämta enskild webbside-post
     * @param int $siteID
     * @return array
     */
    public function getSinglesite(int $siteID): array
    {
        // Säkerställ att siteID är ett numeriskt värde
        $siteID = intval($siteID);

        // Skapa SQL-fråga för att hämta enskild post
        $sql = "SELECT * FROM websites WHERE siteID = '$siteID'";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Skapa ny webbside-post
     * @param string $sitetitle
     * @param string $siteurl
     * @param string $sitedesc
     * @param string $siteimage
     * @return boolean
     */
    public function createSite(string $sitetitle, string $siteurl, string $sitedesc, string $siteimage): bool
    {
        // Anropa setSitetitle, om negativt svar, returnera false
        if (!$this->setSitetitle($sitetitle)) {
            return false;
        }

        // Anropa setSiteurl, om negativt svar, returnera false
        if (!$this->setSiteurl($siteurl)) {
            return false;
        }

        // Anropa setSitedesc, om negativt svar, returnera false
        if (!$this->setSitedesc($sitedesc)) {
            return false;
        }

        // Anropa setSiteimage, om negativt svar, returnera false
        if (!$this->setSiteimage($siteimage)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "INSERT INTO websites(
            sitetitle,
            siteurl,
            sitedesc,
            siteimage
        )VALUES(
            '$this->sitetitle',
            '$this->siteurl',
            '$this->sitedesc',
            '$this->siteimage'
        );";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Ändra webbside-post
     * @param int $siteID
     * @param string $sitetitle
     * @param string $siteurl
     * @param string $sitedesc
     * @param string $siteimage
     * @return boolean
     */
    public function changeSite(int $siteID, string $sitetitle, string $siteurl, string $sitedesc, string $siteimage): bool
    {
        // Säkerställ att siteID är ett numeriskt värde
        $siteID = intval($siteID);

        // Anropa setSitetitle, om negativt svar, returnera false
        if (!$this->setSitetitle($sitetitle)) {
            return false;
        }

        // Anropa setSiteurl, om negativt svar, returnera false
        if (!$this->setSiteurl($siteurl)) {
            return false;
        }

        // Anropa setSitedesc, om negativt svar, returnera false
        if (!$this->setSitedesc($sitedesc)) {
            return false;
        }

        // Anropa setSiteimage, om negativt svar, returnera false
        if (!$this->setSiteimage($siteimage)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "UPDATE websites SET
                sitetitle = '$this->sitetitle',
                siteurl = '$this->siteurl',
                sitedesc = '$this->sitedesc',
                siteimage = '$this->siteimage'
                WHERE siteID = '$siteID';
            ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Radera webbside-post
     * @param int $siteID
     * @return boolean
     */
    public function deleteSite(int $siteID): bool
    {
        // Säkerställ att siteID är ett numeriskt värde
        $siteID = intval($siteID);

        // Skapa SQL-fråga för att radera post ur databasen
        $sql = "DELETE FROM websites WHERE siteID = '$siteID';
        ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }


    // SET/GET-METODER
    /**
     * Sätt sitetitle
     * @param string $sitetitle
     * @return bool
     */
    public function setSitetitle(string $sitetitle): bool
    {
        // Ta bort eventuella specialtecken
        $sitetitle = $this->db->real_escape_string($sitetitle);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($sitetitle) > 3) {
            $this->sitetitle = $sitetitle;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt siteurl
     * @param string $siteurl
     * @return bool
     */
    public function setSiteurl(string $siteurl): bool
    {
        // Ta bort eventuella specialtecken
        $siteurl = $this->db->real_escape_string($siteurl);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($siteurl) > 3) {
            $this->siteurl = $siteurl;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt sitedesc
     * @param string $sitedesc
     * @return bool
     */
    public function setSitedesc(string $sitedesc): bool
    {
        // Ta bort eventuella specialtecken
        $sitedesc = $this->db->real_escape_string($sitedesc);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($sitedesc) > 3) {
            $this->sitedesc = $sitedesc;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt siteimage
     * @param string $siteimage
     * @return bool
     */
    public function setSiteimage(string $siteimage): bool
    {
        // Ta bort eventuella specialtecken
        $siteimage = $this->db->real_escape_string($siteimage);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($siteimage) > 3) {
            $this->siteimage = $siteimage;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Hämta sitetitle
     * @return string
     */
    public function getSitetitle(): string
    {
        return $this->sitetitle;
    }

    /**
     * Hämta siteurl
     * @return string
     */
    public function getSiteurl(): string
    {
        return $this->siteurl;
    }

    /**
     * Hämta sitedesc
     * @return string
     */
    public function getSitedesc(): string
    {
        return $this->sitedesc;
    }

    /**
     * Hämta siteimage
     * @return string
     */
    public function getSiteimage(): string
    {
        return $this->siteimage;
    }

    // Destruerare
    public function __destruct()
    {
        // Lägg till kod för att stänga databasanslutning
    }
}
