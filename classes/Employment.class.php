<?php

class Employment
{
    // Properties
    private $db;
    private $emptitle;
    private $empplace;
    private $empstartdate;
    private $empenddate;

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
     * Hämta alla jobb-poster
     * @return array
     */
    public function getEmp(): array
    {
        // Skapa SQL-fråga för att hämta alla studie-poster från databasen
        $sql = "SELECT * FROM employments";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Hämta enskild jobb-post
     * @param int $empID
     * @return array
     */
    public function getSingleemp(int $empID): array
    {
        // Säkerställ att empID är ett numeriskt värde
        $empID = intval($empID);

        // Skapa SQL-fråga för att hämta enskild post
        $sql = "SELECT * FROM employments WHERE empID = '$empID'";

        // Skicka SQL-frågan och lagra svaret
        $result = mysqli_query($this->db, $sql);

        // Returnera resultatet som associativ array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Skapa ny jobb-post
     * @param string $emptitle
     * @param string $empplace
     * @param string $empstartdate
     * @param string $empenddate
     * @return boolean
     */
    public function createEmp(string $emptitle, string $empplace, string $empstartdate, string $empenddate): bool
    {
        // Anropa setEmptitle, om negativt svar, returnera false
        if (!$this->setEmptitle($emptitle)) {
            return false;
        }

        // Anropa setEmpplace, om negativt svar, returnera false
        if (!$this->setEmpplace($empplace)) {
            return false;
        }

        // Anropa setEmpstartdate, om negativt svar, returnera false
        if (!$this->setEmpstartdate($empstartdate)) {
            return false;
        }

        // Anropa setEmpenddate, om negativt svar, returnera false
        if (!$this->setEmpenddate($empenddate)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "INSERT INTO employments(
            emptitle,
            empplace,
            empstartdate,
            empenddate
        )VALUES(
            '$this->emptitle',
            '$this->empplace',
            '$this->empstartdate',
            '$this->empenddate'
        );";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Ändra jobb-post
     * @param int $empID
     * @param string $emptitle
     * @param string $empplace
     * @param string $empstartdate
     * @param string $empenddate
     * @return boolean
     */
    public function changeEmp(int $empID, string $emptitle, string $empplace, string $empstartdate, string $empenddate): bool
    {
        // Säkerställ att empID är ett numeriskt värde
        $empID = intval($empID);

        // Anropa setEmptitle, om negativt svar, returnera false
        if (!$this->setEmptitle($emptitle)) {
            return false;
        }

        // Anropa setEmpplace, om negativt svar, returnera false
        if (!$this->setEmpplace($empplace)) {
            return false;
        }

        // Anropa setEmpstartdate, om negativt svar, returnera false
        if (!$this->setEmpstartdate($empstartdate)) {
            return false;
        }

        // Anropa setEmpenddate, om negativt svar, returnera false
        if (!$this->setEmpenddate($empenddate)) {
            return false;
        }

        // Skapa SQL-fråga för att lagra värdena i databasen
        $sql = "UPDATE employments SET
                emptitle = '$this->emptitle',
                empplace = '$this->empplace',
                empstartdate = '$this->empstartdate',
                empenddate = '$this->empenddate'
                WHERE empID = '$empID';
            ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }

    /**
     * Radera jobb-post
     * @param int $empID
     * @return boolean
     */
    public function deleteEmp(int $empID): bool
    {
        // Säkerställ att empID är ett numeriskt värde
        $empID = intval($empID);

        // Skapa SQL-fråga för att radera post ur databasen
        $sql = "DELETE FROM employments WHERE empID = '$empID';
        ";

        // Skicka SQL-fråga, returnera resultatet
        return mysqli_query($this->db, $sql);
    }


    // SET/GET-METODER

    /**
     * Sätt emptitle
     * @param string $emptitle
     * @return boolean
     */
    public function setEmptitle(string $emptitle): bool
    {
        // Ta bort eventuella specialtecken
        $emptitle = $this->db->real_escape_string($emptitle);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($emptitle) > 3) {
            $this->emptitle = $emptitle;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt empplace
     * @param string $empplace
     * @return boolean
     */
    public function setEmpplace(string $empplace): bool
    {
        // Ta bort eventuella specialtecken
        $empplace = $this->db->real_escape_string($empplace);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($empplace) > 3) {
            $this->empplace = $empplace;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt empstartdate
     * @param string $empstartdate
     * @return boolean
     */
    public function setEmpstartdate(string $empstartdate): bool
    {
        // Ta bort eventuella specialtecken
        $empstartdate = $this->db->real_escape_string($empstartdate);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($empstartdate) > 3) {
            $this->empstartdate = $empstartdate;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sätt empenddate
     * @param string $empenddate
     * @return boolean
     */
    public function setEmpenddate(string $empenddate): bool
    {
        // Ta bort eventuella specialtecken
        $empenddate = $this->db->real_escape_string($empenddate);

        // Kontrollera längden, om över 3 tecken, sätt property och returnera true, annars returnera false
        if (strlen($empenddate) > 3) {
            $this->empenddate = $empenddate;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Hämta emptitle
     * @return string
     */
    public function getEmptitle(): string
    {
        return $this->emptitle;
    }

    /**
     * Hämta empplace
     * @return string
     */
    public function getEmpplace(): string
    {
        return $this->empplace;
    }

    /**
     * Hämta empstartdate
     * @return string
     */
    public function getEmpstartdate(): string
    {
        return $this->empstartdate;
    }

    /**
     * Hämta empenddate
     * @return string
     */
    public function getEmpenddate(): string
    {
        return $this->empenddate;
    }

    // Destruerare
    public function __destruct()
    {
        // Lägg till kod för att stänga databasanslutning
    }
}
