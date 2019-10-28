<?php

trait Deletable
{
    public function loesche()
    {
        $sql = vsprintf(
            'DELETE FROM %s WHERE id = ?',
            [self::ermittleTable()]
        );
        $abfrage = self::$db->prepare($sql);
        $abfrage->execute([$this->getId()]);

        $this->id = 0;
    }

    public function deleteConnection($table, $key1, $key2, $value1) {
        $sql = vsprintf(
            'DELETE FROM %s WHERE ' . $key1 . ' = ?' .  (empty($key2) ? "" : (" AND " . $key2 . " = " . $value1)),
            [$table]
        );
        $abfrage = self::$db->prepare($sql);
        $abfrage->execute([$this->getId()]);
    }
}