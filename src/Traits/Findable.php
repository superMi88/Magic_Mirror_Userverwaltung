<?php

trait Findable
{

    public static function findeAlle($sortiere, $sucheWort="")
    {

        echo "wird aufgerufen";
        $name = preg_split('/-/', $sortiere);

        if(!empty($sortiere)){
            $sortiere = $name[0]." ".$name[1];
        }else{
            $sortiere = 'id';
        }

        //pruefe nach was sortiert wird wenn es keines in der liste ist sortiere nach titel
        $sortiere = 'ORDER BY '.$sortiere;

        //falls nicht nach titel sortiert wird dann wird zuerst nach dem sortierten sortiert
        //und danach nach dem titel
        if($sortiere != 'id'){
            $sortiere = $sortiere.', id ASC';
        }

        $suche = "";
        if($sucheWort != ""){
            $suche = "WHERE ".$sucheWort." LIKE ? ";
        }

        $sql = vsprintf(
            'SELECT * FROM %s '.$suche . $sortiere,
            [self::ermittleTable()]
        );

        $abfrage = self::$db->prepare($sql);

        if($sucheWort != "") {
            $abfrage->execute(['%' . $_GET['suche'] . '%']);
        }
        $abfrage->setFetchMode(PDO::FETCH_CLASS,get_class());

        return $abfrage->fetchAll();

    }

    public static function finde($key, $value)
    {
        $sql = vsprintf(
            'SELECT * FROM %s WHERE ' . $key . ' = ?',
            [self::ermittleTable()]
        );

        $abfrage = self::$db->prepare($sql);
        $abfrage->execute([$value]);
        $abfrage->setFetchMode(PDO::FETCH_CLASS, get_class());

        return $abfrage->fetch();
    }

    public static function findeName($username)
    {
        $sql = vsprintf(
            'SELECT * FROM %s WHERE username = ?',
            [self::ermittleTable()]
        );
        $abfrage = self::$db->prepare($sql);
        $abfrage->execute([$username]);

        $abfrage->setFetchMode(PDO::FETCH_CLASS, get_class());

        return $abfrage->fetch();
    }

    public static function findXfromObject($X, $Xid, $return)
    {
        //get_class($this) nach get_called_class() mit static funktion geändert
        $objectName = get_called_class();

        //ermittle table name XZuY X ist im alphabet weiter vorne
        $names = array($X, $objectName);
        sort($names);

        //RENAME TABLE user_verwaltung.klienten TO user_verwaltung.Klien
        $nameTabelle = $names[0]."Zu".$names[1];

        $sql = vsprintf(
            'SELECT * FROM %s WHERE '.$X.'ID = ?',
            [$nameTabelle]
        );

        $abfrage = self::$db->prepare($sql);

        $abfrage->execute([$Xid]);
        $abfrage->setFetchMode(PDO::FETCH_ASSOC);

        //baue anfrage zusammen
        $condition = "";
        $count = 0;
        foreach ($abfrage as $Xid) {

            if ($count == 0) {
                $condition .= "id='" . $Xid[$objectName."ID"] . "'";
            } else {
                $condition .= " OR id='" . $Xid[$objectName."ID"] . "'";
            }
            $count++;
        }

        if ($count > 0){
            //bekomme alle Nachrichten von den NachrichtenIDs

            $ergebnis = self::$db->query("SELECT $return FROM ".$objectName." WHERE " . $condition)->fetchAll(PDO::FETCH_CLASS, get_class());

        }else{
            $ergebnis = NULL;
        }

        return $ergebnis;
    }
}
