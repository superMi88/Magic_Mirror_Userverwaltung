<?php

//gibt die Nachrichten als Json zurueck wenn ein nfcToken uebergeben wird
if (isset($_GET['nfc'])){

    require_once 'inc/funktionen.inc.php';

    spl_autoload_register('autoloadEntities');
    spl_autoload_register('autoloadTraits');

    //Datenbankverbindung
    require_once 'inc/datenbank.inc.php';
    Nachricht::verbindeZuDb($db);

    $nfc = $_GET['nfc'];

    //Bekomme BenutzerID, name und vorname vom user dem der nfcToken zugewiesen ist
    $idArray = $db->query("SELECT id, vorname, name FROM Klient WHERE nfcToken=" . $nfc)->fetchAll(PDO::FETCH_ASSOC);

    if(empty($idArray)){
        $db->query("INSERT INTO Klient (nfcToken, vorname) VALUES ($nfc, 'Neuer Nutzer')");
        $idArray = $db->query("SELECT id, vorname, name FROM Klient WHERE nfcToken=" . $nfc)->fetchAll(PDO::FETCH_ASSOC);
    }

    $id = $idArray[0]["id"];
    $fullName = $idArray[0]["vorname"] . " " . $idArray[0]["name"];
    //Bekomme alle NachrichetenIDs für die BenutzerIDs
    $nachrichten = Nachricht::findXfromObject("Klient", $id, "*");

    if (!empty($nachrichten)) {
        $nachrichtenlisteSortiert = [];
        foreach ($nachrichten as $NachrichtenID => $nachricht) {
            $nachrichtenlisteSortiert[$NachrichtenID] = $nachricht->getNextDate();
        }

        usort($nachrichtenlisteSortiert, function ($date1, $date2) {
            $a = strtotime($date1);
            $b = strtotime($date2);
            return $b - $a;
        });

        $nachrichtenlisteSortiert2 = [];
        $setIds = [];
        foreach ($nachrichtenlisteSortiert as $pos => $datum) {
            foreach ($nachrichten as $NachrichtenID => $nachricht) {
                if ($datum == $nachricht->getNextDate() && !in_array($nachricht->getId(), $setIds)) {
                    array_push($setIds, $nachricht->getId());
                    $nachrichtenlisteSortiert2[$NachrichtenID] = $nachricht;
                    break;
                }
            }
        }
    } else {
        $nachrichtenlisteSortiert2 = [];
    }

    $nachrichtenlisteSortiert3 = [];
    array_push($nachrichtenlisteSortiert3, $fullName);
    foreach ($nachrichtenlisteSortiert2 as $object) {
        if ($object->getNextDate() == date('d.m.Y')) {
            $arr = $object->toArray();
            array_push($nachrichtenlisteSortiert3, $arr);
        }
    }

    echo json_encode($nachrichtenlisteSortiert3);

}