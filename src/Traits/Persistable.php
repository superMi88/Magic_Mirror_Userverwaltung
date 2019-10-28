<?php

trait Persistable
{
    public function speichere()
    {
        if($this->getId() > 0) {
            //bereits vorhanden
            $this->update();
        } else {
            //neu
            $this->insert();
        }
    }

    public function insertVerbindung($attribute, $table){

        $schluessel = array_keys($attribute);

        //anonyme Funktion inline
        $platzhalter = array_map(function($wert){
            return ':' . $wert;
        }, $schluessel);

        $daten = [
            $table,
            //titel, preis
            implode('ID, ', $schluessel) . "ID",
            // _titel, :preis
            implode(', ', $platzhalter)
        ];

        $sql = vsprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $daten
        );

        $abfrage = self::$db->prepare($sql);

        $abfrage->execute($attribute);
        //setze die DID auf den von der DB generierten Wert
        $this->id = self::$db->lastInsertId();
    }

    public function insert()
    {
        $attribute = $this->toArray(false); //ohne ID
        $schluessel = array_keys($attribute);

        //anonyme Funktion inline
        $platzhalter = array_map(function($wert){
            return ':' . $wert;
        }, $schluessel);

        $daten = [
            self::ermittleTable(),
            //titel, preis
            implode(', ', $schluessel),
            // _titel, :preis
            implode(', ', $platzhalter)
        ];

        $sql = vsprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $daten
        );

        $abfrage = self::$db->prepare($sql);
        $abfrage->execute($attribute);
        //setze die DID auf den von der DB generierten Wert
        $this->id = self::$db->lastInsertId();
    }

    protected function update()
    {
        $attribute = $this->toArray(false); // ohne ID
        $schluessel = array_keys($attribute);

        //anonyme Funktion inline
        $platzhalter = array_map(function ($wert){
            return $wert . ' = :' . $wert;}, $schluessel);

        $daten = [
            self::ermittleTable(),
            //titel = :titel, preis = :preis
            implode(', ',$platzhalter)
        ];

        $sql = vsprintf(
            'UPDATE %s SET %s WHERE id = :id',
            $daten
        );
        $abfrage = self::$db->prepare($sql);
        $abfrage->execute($this->toArray());
    }

}