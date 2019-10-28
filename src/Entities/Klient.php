<?php

class Klient
{
    protected $id = '';
    protected $name = '';
    protected $vorname = '';
    protected $nfcToken = '';

    protected static $table = 'Klient';

    use ActiveRecordable, Findable, Persistable, Deletable;

    protected static $db;


    /**
     * @return string
     */
    public function getVorname(): string
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     */
    public function setVorname(string $vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * @return string
     */
    public function getNfcToken(): string
    {
        return $this->nfcToken;
    }

    /**
     * @param string $nfcToken
     */
    public function setNfcToken(string $nfcToken)
    {
        $this->nfcToken = $nfcToken;
    }

    public function __construct(array $daten = [])
    {
        $this->setDaten($daten);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}
