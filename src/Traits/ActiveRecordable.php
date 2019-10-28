<?php

trait ActiveRecordable
{
    protected static $db;

    public static function verbindeZuDb(PDO $db)
    {
        self::$db = $db;
    }

    protected static function ermittleTable()
    {
        if (empty(self::$db)) {
            throw new Exception('Kein DB-Objekt!');
        }

        $table = strtolower(get_class());
        if (!empty(self::$table)) {
            $table = self::$table;
        }

        return $table;
    }

    public function setDaten(array $daten)
    {

        if ($daten) {

            foreach ($daten as $k => $v){

                $setterName = 'set' . ucfirst($k);

                //pruefe ob ein passender Setter exestiert
                if(method_exists($this, $setterName)) {

                    //bei setPasswort müssen 2 Daten übergeben werden
                    if($setterName == "setPassword"){
                        $this->$setterName($v, $daten['password2']);

                    }else {
                        $this->$setterName($v); //Setteraufruf
                    }
                }else{
                    echo "Methode '" . $setterName . "'' exestiert nicht";
                }
            }
        }
    }

    public function toArray($mitId = true){
        $attribute = get_object_vars($this); //ohne statische Attribute!

        if($mitId === false) {
            unset($attribute['id']);
        }

        return $attribute;
    }
}