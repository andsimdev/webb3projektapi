<?php

class Study
{
    // Properties
    private $db;
    private $studtitle;
    private $university;
    private $studstartdate;
    private $studenddate;

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
     * Hämta alla studie-poster
     * @return array
     */
    public function getStud(): array
    {
        // Skapa SQL-fråga för att hämta alla studie-poster från databasen
        $sql = "SELECT * FROM studies";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Hämta enskild studie-post
     * @param int $studID
     * @return array
     */
    public function getSinglestud(int $studID): array
    {
        // Säkerställ att studID är ett numeriskt värde
        $studID = intval($studID);

        // Skapa SQL-fråga för att hämta enskild post
        $sql = "SELECT * FROM studies WHERE studID = '$studID'";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Skapa ny studie-post
     * @param string $studtitle
     * @param string $university
     * @param string $studstartdate
     * @param string $studenddate
     * @return boolean
     */
    public function createStud(string $studtitle, string $university, string $studstartdate, string $studenddate): bool
    {
        // Anropa setStudtitle, om negativt svar, returnera false
        if (!$this->setStudtitle($studtitle)) {
            return false;
        }

        // Anropa setUniversity, om negativt svar, returnera false
        if (!$this->setUniversity($university)) {
            return false;
        }

        // Anropa setStudstartdate, om negativt svar, returnera false
        if (!$this->setStudstartdate($studstartdate)) {
            return false;
        }

        // Anropa setStudenddate, om negativt svar, returnera false
        if (!$this->setStudenddate($studenddate)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "INSERT INTO studies(
            studtitle,
            university,
            studstartdate,
            studenddate
        )VALUES(
            '$this->studtitle',
            '$this->university',
            '$this->studstartdate',
            '$this->studenddate'
        );";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Ändra studie-post
     * @param int $studID
     * @param string $studtitle
     * @param string $university
     * @param string $studstartdate
     * @param string $studenddate
     * @return boolean
     */
    public function changeStud(int $studID, string $studtitle, string $university, string $studstartdate, string $studenddate): bool
    {
        // Säkerställ att studID är ett numeriskt värde
        $studID = intval($studID);

        // Anropa setStudtitle, om negativt svar, returnera false
        if (!$this->setStudtitle($studtitle)) {
            return false;
        }

        // Anropa setUniversity, om negativt svar, returnera false
        if (!$this->setUniversity($university)) {
            return false;
        }

        // Anropa setStudstartdate, om negativt svar, returnera false
        if (!$this->setStudstartdate($studstartdate)) {
            return false;
        }

        // Anropa setStudenddate, om negativt svar, returnera false
        if (!$this->setStudenddate($studenddate)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "UPDATE studies SET
            studtitle = '$this->studtitle',
            university = '$this->university',
            studstartdate = '$this->studstartdate',
            studenddate = '$this->studenddate'
            WHERE studID = '$studID';
        ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Radera studie-post
     * @param int $studID
     * @return boolean
     */
    public function deleteStud(int $studID): bool
    {
        // Säkerställ att studID är ett numeriskt värde
        $studID = intval($studID);

        // Skapa SQL-fråga för att radera post ur databasen
        $sql = "DELETE FROM studies WHERE studID = '$studID';
        ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }


    // SET/GET-METODER

    /**
     * Sätt studtitle
     * @param string $studtitle
     * @return boolean
     */
    public function setStudtitle(string $studtitle): bool
    {
        // Ta bort eventuella specialtecken
        $studtitle = $this->db->real_escape_string($studtitle);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($studtitle) > 3) {
            $this->studtitle = $studtitle;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt university
     * @param string $university
     * @return boolean
     */
    public function setUniversity(string $university): bool
    {
        // Ta bort eventuella specialtecken
        $university = $this->db->real_escape_string($university);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($university) > 3) {
            $this->university = $university;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt studstartdate
     * @param string $studstartdate
     * @return boolean
     */
    public function setStudstartdate(string $studstartdate): bool
    {
        // Ta bort eventuella specialtecken
        $studstartdate = $this->db->real_escape_string($studstartdate);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($studstartdate) > 3) {
            $this->studstartdate = $studstartdate;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt studenddate
     * @param string $studenddate
     * @return boolean
     */
    public function setStudenddate(string $studenddate): bool
    {
        // Ta bort eventuella specialtecken
        $studenddate = $this->db->real_escape_string($studenddate);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($studenddate) > 3) {
            $this->studenddate = $studenddate;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Hämta studtitle
     * @return string
     */
    public function getStudtitle(): string
    {
        return $this->studtitle;
    }

    /**
     * Hämta university
     * @return string
     */
    public function getUniversity(): string
    {
        return $this->university;
    }

    /**
     * Hämta studstartdate
     * @return string
     */
    public function getStudstartdate(): string
    {
        return $this->studstartdate;
    }

    /**
     * Hämta studenddate
     * @return string
     */
    public function getStudenddate(): string
    {
        return $this->studenddate;
    }

    // Destruerare
    public function __destruct()
    {
        // Lägg till kod för att stänga databasanslutning
    }
}
