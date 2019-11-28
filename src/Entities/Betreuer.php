<?php

class Betreuer
{
    protected $id = 0;
    protected $username = '';
    protected $password = '';

    protected static $table = 'Betreuer';

    use ActiveRecordable, Findable, Persistable;

    use Deletable{
        loesche as traitLoesche;
    }

    protected static $db;

    public function __construct(array $daten = [])
    {
        $this->setDaten($daten);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password, $password2)
    {
        if(strlen($password) == 0){
            echo "Passwort Feld darf nicht leer sein";
        }
        else if($password != $password2){
            echo "Passwörter stimmen nicht überein";
        }
        else{
            echo "Passwort gespeichert";

            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }

    }

    public function loesche(){
        //Delete Connections
        $this->deleteConnection("BetreuerZuKlient", "BetreuerID", "", "");
        //Delete Betreuer
        $this->traitLoesche();
    }

}
