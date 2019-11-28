<?php

class Nachricht
{
    protected $id = 0;
    protected $text = '';
    protected $wichtigkeit = 0;
    protected $datetime = '';
    protected $datestart = '';
    protected $dateend = '';
    protected $wiederholungsart = 1;
    protected $wiederholungsrate = 1;
    protected $monday = false;
    protected $tuesday = false;
    protected $wednesday = false;
    protected $thursday = false;
    protected $friday = false;
    protected $saturday = false;
    protected $sunday = false;
    protected $zeitpunkt = 1;

    protected static $table = 'Nachricht';

    use ActiveRecordable, Findable, Persistable;

    use Deletable{
        loesche as traitLoesche;
    }

    protected static $db;

    public function __construct(array $daten = [])
    {

        $this->setDaten($daten);
    }


    /**
     * @return string
     */
    public function getNextAppointment(): string
    {
        return $this->nextAppointment;
    }

    /**
     * @param string $nextAppointment
     */
    public function setNextAppointment(string $nextAppointment)
    {
        $this->nextAppointment = $nextAppointment;
    }

    /**
     * @return int
     */
    public function getZeitpunkt(): int
    {
        return $this->zeitpunkt;
    }

    /**
     * @param int $zeitpunkt
     */
    public function setZeitpunkt(int $zeitpunkt)
    {
        $this->zeitpunkt = $zeitpunkt;
    }

    /**
     * @return string
     */
    public function getWiederholungsart(): string
    {
        return $this->wiederholungsart;
    }

    /**
     * @param string $wiederholungsart
     */
    public function setWiederholungsart(string $wiederholungsart)
    {
        switch ($wiederholungsart){
            case "daily":
                $wiederholungsart = 1;
                break;
            case "weekly":
                $wiederholungsart = 2;
                break;
            case "monthly":
                $wiederholungsart = 3;
                break;
            default:
                $wiederholungsart = 1;
                break;
        }


        $this->wiederholungsart = $wiederholungsart;
    }

    /**
     * @return string
     */
    public function getWiederholungsrate(): string
    {
        return $this->wiederholungsrate;
    }

    /**
     * @param string $wiederholungsrate
     */
    public function setWiederholungsrate(string $wiederholungsrate)
    {
        $this->wiederholungsrate = $wiederholungsrate;
    }

    /**
     * @return bool
     */
    public function isMonday(): bool
    {
        return $this->monday;
    }

    /**
     * @param bool $monday
     */
    public function setMonday(bool $monday)
    {
        $this->monday = $monday;
    }

    /**
     * @return bool
     */
    public function isTuesday(): bool
    {
        return $this->tuesday;
    }

    /**
     * @param bool $tuesday
     */
    public function setTuesday(bool $tuesday)
    {
        $this->tuesday = $tuesday;
    }

    /**
     * @return bool
     */
    public function isWednesday(): bool
    {
        return $this->wednesday;
    }

    /**
     * @param bool $wednesday
     */
    public function setWednesday(bool $wednesday)
    {
        $this->wednesday = (boolean)$wednesday;
    }

    /**
     * @return bool
     */
    public function isThursday(): bool
    {
        return $this->thursday;
    }

    /**
     * @param bool $thursday
     */
    public function setThursday(bool $thursday)
    {
        $this->thursday = $thursday;
    }

    /**
     * @return bool
     */
    public function isFriday(): bool
    {
        return $this->friday;
    }

    /**
     * @param bool $friday
     */
    public function setFriday(bool $friday)
    {
        $this->friday = $friday;
    }

    /**
     * @return bool
     */
    public function isSaturday(): bool
    {
        return $this->saturday;
    }

    /**
     * @param bool $saturday
     */
    public function setSaturday(bool $saturday)
    {
        $this->saturday = $saturday;
    }

    /**
     * @return bool
     */
    public function isSunday(): bool
    {
        return $this->sunday;
    }

    /**
     * @param bool $sunday
     */
    public function setSunday(bool $sunday)
    {
        $this->sunday = $sunday;
    }



    /**
     * @return string
     */
    public function getDatestart(): string
    {
        return $this->datestart;
    }

    /**
     * @param string $datestart
     */
    public function setDatestart(string $datestart)
    {
        $this->datestart = $datestart;
    }

    /**
     * @return string
     */
    public function getDateend(): string
    {
        return $this->dateend;
    }

    /**
     * @param string $dateend
     */
    public function setDateend(string $dateend)
    {
        $this->dateend = $dateend;
    }


    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * @param string $datetime
     */
    public function setDatetime(string $datetime)
    {
        $this->datetime = $datetime;
    }



    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getWichtigkeit(): string
    {
        return $this->wichtigkeit;
    }

    /**
     * @param string $wichtigkeit
     */
    public function setWichtigkeit(string $wichtigkeit)
    {
        $this->wichtigkeit = $wichtigkeit;
    }

    public function getNextDate() {
        switch($this->getWiederholungsart()){
            case 1: // Täglich
                if (date('Y-m-d') < $this->getDatestart()) {
                    return date('d.m.Y', strtotime($this->getDatestart()));
                } else if ($this->getDateend() < date('Y-m-d')) {
                    return date('d.m.Y', strtotime($this->getDateend()));
                } else {
                    return date('d.m.Y');
                }
                break;
            case 2: // Wöchentlich
                if ($this->getDateend() <= date('Y-m-d')) {
                    return date('d.m.Y', strtotime($this->getDateend()));
                } else {
                    $firstDate = "";
                    if (date('Y-m-d') < $this->getDatestart()) {
                        $firstDate = date('d.m.Y', strtotime($this->getDatestart()));
                    } else {
                        $firstDate = date('d.m.Y');
                    }
                    $days = [
                        "Mon" => "isMonday",
                        "Tue" => "isTuesday",
                        "Wed" => "isWednesday",
                        "Thu" => "isThursday",
                        "Fri" => "isFriday",
                        "Sat" => "isSaturday",
                        "Sun" => "isSunday"
                    ];
                    $day = $days[date("D")];
                    if ((boolean)$this->$day()) {
                        // Heute
                        return date("d.m.Y");
                    } else {
                        $validDay = false;
                        $numericArray = array_values($days);
                        $positionArray = array_keys($days);
                        $position = array_search(date("D"), $positionArray);
                        for ($i = $position; $i < count($numericArray); $i++) {
                            $funcName = $numericArray[$i];
                            // Ist der Termin noch in der selben Woche?
                            if ((boolean)$this->$funcName()) {
                                $validDay = true;
                                $diff = $i - $position;
                                $newDate = strtotime("+" . $diff . " day", strtotime($firstDate));
                                return date('d.m.Y', $newDate);
                                break;
                            }
                        }
                        if (!$validDay) {
                            for ($i = 0; $i < $position; $i++) {
                                $funcName = $numericArray[$i];
                                // Ist der Termin erst in der darauffolgenden Woche?
                                if ((boolean)$this->$funcName()) {
                                    $validDay = true;
                                    $diff = $position + $i;
                                    $newDate = strtotime("+" . $diff . " day", strtotime($firstDate));
                                    return date('d.m.Y', $newDate);
                                    break;
                                }
                            }
                        }
                        // Wenn kein Wochentag gesetzt wurde, gib 'null' zurück
                        return null;
                    }
                }
                break;
            case 3: // Monatlich

                break;
        }
        return date("d.m.Y");
    }

    public function loesche(){
        //Delete Connections
        $this->deleteConnection("KlientZuNachricht", "NachrichtID", "", "");
        //Delete User
        $this->traitLoesche();
    }

}
