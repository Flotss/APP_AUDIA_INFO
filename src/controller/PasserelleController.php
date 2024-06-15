<?php

namespace App\Controller;

class Trame
{
    private $type;
    private $origine;
    private $recepteur;
    private $controle;
    private $numero;
    private $valeur;
    private $ack;
    private $checksum;
    private $year;
    private $month;
    private $day;
    private $hour;
    private $min;
    private $sec;

    public function __construct($type, $origine, $recepteur, $controle, $numero, $valeur, $ack, $checksum, $year, $month, $day, $hour, $min, $sec)
    {
        $this->type = $type;
        $this->origine = $origine;
        $this->recepteur = $recepteur;
        $this->controle = $controle;
        $this->numero = $numero;
        $this->valeur = $valeur;
        $this->ack = $ack;
        $this->checksum = $checksum;
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->min = $min;
        $this->sec = $sec;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getOrigine()
    {
        return $this->origine;
    }

    public function getRecepteur()
    {
        return $this->recepteur;
    }

    public function getControle()
    {
        return $this->controle;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getValeur()
    {
        return $this->valeur;
    }

    public function getAck()
    {
        return $this->ack;
    }

    public function getChecksum()
    {
        return $this->checksum;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getSec()
    {
        return $this->sec;
    }

    public function __toString()
    {
        return $this->type . "," . $this->origine . "," . $this->recepteur . "," . $this->controle . "," . $this->numero . "," . $this->valeur . "," . $this->ack . "," . $this->checksum . "," . $this->year . "," . $this->month . "," . $this->day . "," . $this->hour . "," . $this->min . "," . $this->sec;
    }

    public function setDate($year, $month, $day, $hour = 0, $min = 0, $sec = 0)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->min = $min;
        $this->sec = $sec;
    }
}

/**
 * The IndexController class is responsible for handling requests related to the index page.
 */
class PasserelleController extends AbstractController
{

    /**
     * Constructs a new instance of the IndexController class.
     */
    public function __construct()
    {
        parent::__construct("passerelle");

        // URI
        if (!$_SERVER['REQUEST_URI'] === '/passerelle') {
            return;
        }


        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=1G08"
        );
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data[0] != '1') {
            echo $data;
        }

        $data_tab = str_split($data, 33);

        $data = [];
        for ($i = 0, $size = count($data_tab); $i < $size &&  $i < 300; $i++) {
            $trame = ""; // Declare the variable $trame
            $trame = $data_tab[$i]; // Assign a value to $trame
            // décodage avec des substring
            $t = substr($trame, 0, 1);
            $o = substr($trame, 1, 4);
            // …
            // décodage avec sscanf
            list($t, $o, $r, $c, $n, $v, $a, $x, $year, $month, $day, $hour, $min, $sec) =
                sscanf($trame, "%1s%4s%1s%1s%2s%4s%4s%2s%4s%2s%2s%2s%2s%2s");

            $trame = new Trame($t, $o, $r, $c, $n, $v, $a, $x, $year, $month, $day, $hour, $min, $sec);

            $data[] = $trame;
        }

        $this->addData('trames', $data);
    }
}
