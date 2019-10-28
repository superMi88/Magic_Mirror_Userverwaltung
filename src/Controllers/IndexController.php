<?php

class IndexController extends AbstractBase
{

    protected function indexAction()
    {
        //der erste Eintrag ist
        $this->addContext('ersterEintrag', true);
        $klientliste = Klient::findXfromObject("Betreuer", $_SESSION['userid'],"id,vorname,name");
        $this->addContext('klientliste', $klientliste);
        //gehe alle klienten durch
        foreach ($klientliste as $id => $klient) {
            //nachrichtenliste des users
            $nachrichtenliste2 = Nachricht::findXfromObject("Klient", $klient->getId(), "*");

            if (!empty($nachrichtenliste2)) {
                $nachrichtenlisteSortiert = [];
                foreach ($nachrichtenliste2 as $NachrichtenID => $nachricht) {
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
                    foreach ($nachrichtenliste2 as $NachrichtenID => $nachricht) {
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
            //nachrichtenliste von nachrichtenlisten
            $nachrichtenliste[$klient->getId()] = $nachrichtenlisteSortiert2;
        }
        $this->addContext('nachrichtenliste', $nachrichtenliste);

    }

    protected function userlisteAction()
    {

        //wenn es ein Betreuer zu löschen gibt löschen
        if(isset($_GET['loesche'])){

            //suche das user mit der id von loesche
            $user = Betreuer::finde('id', $_GET['loesche']);

            //teste ob user instanceof Betreuer falls die id in der Datenbank nicht exestiert
            if($user instanceof Betreuer){
                $user->deleteConnection("BetreuerZuKlient", "BetreuerID", "", "");
                $user->loesche();
            }
        }

        $this->addContext('sortiere', isset($_GET['sortiere']) ? $_GET['sortiere'] : 'titel');
        $this->addContext('suche', isset($_GET['suche']) ? $_GET['suche'] : '');

        //setze den ersten Eintrag auf true, der erste Eintrag bekommt im template eine zusätzliche id wenn es der
        //der erste Eintrag ist
        $this->addContext('ersterEintrag', true);

        $this->addContext('userliste', Betreuer::findeAlle("username", "username" ));

    }

    protected function nachrichtenlisteAction()
    {
        //wenn es ein Betreuer zu löschen gibt löschen
        if(isset($_GET['loesche'])){

            //suche das user mit der id von loesche
            $nachricht = Nachricht::finde('id', $_GET['loesche']);

            //teste ob user instanceof Betreuer falls die id in der Datenbank nicht exestiert
            if($nachricht instanceof Nachricht){
                $nachricht->deleteConnection("KlientZuNachricht", "NachrichtID", "", "");
                $nachricht->loesche();
            }
        }

        $this->addContext('sortiere', isset($_GET['sortiere']) ? $_GET['sortiere'] : 'titel');

        $this->addContext('suche', isset($_GET['suche']) ? $_GET['suche'] : '');

        //setze den ersten Eintrag auf true, der erste Eintrag bekommt im template eine zusätzliche id wenn es der
        //der erste Eintrag ist
        $this->addContext('ersterEintrag', true);
        $this->addContext('nachrichtenliste', Nachricht::findeAlle($_GET['sortiere'], "text"));
    }

    protected function zeigeAction()
    {
        //der erste Eintrag ist
        $this->addContext('ersterEintrag', true);
        $this->addContext('klientliste', Klient::findXfromObject("Betreuer", $_GET['id'],"id,name,vorname"));

        $this->addContext('user', Betreuer::finde('id', $_GET['id']));
    }

    protected function zeigeKlientAction()
    {
        $this->addContext('user', Klient::finde('id', $_GET['id']));
    }

    protected function zeigeNachrichtAction()
    {
        $this->addContext('nachricht', Nachricht::finde('id', $_GET['id']));
    }

    protected function neuAction()
    {
        $user = new Betreuer();

        if($_POST)
        {
            if (!empty($_POST["username"])) {
                if (!empty($_POST["password"]) && !empty($_POST["password2"])) {
                    if (strcmp($_POST["password"], $_POST["password2"]) == 0) {
                        $user->setDaten($_POST);
                        $user->speichere();
                        redirect('index.php?action=userliste');
                    } else {
                        redirect('#my_popup_mismatch');
                    }
                } else {
                    redirect('#my_popup_empty');
                }
            } else {
                redirect('#my_popup_emptyName');
            }
        }

        $this->addContext('user', $user);
        $this->addContext('ueberschrift', "Neuer Betreuer");
        $this->setTemplate('bearbeiteAction');
    }

    protected function neuKlientAction()
    {
        $user = new Klient();
        $userliste = Betreuer::findeAlle("username", "username");

        if($_POST)
        {
            if (!empty($_POST["vorname"]) && !empty($_POST["name"])) {
                if (!empty($_POST["nfcToken"])) {
                    $user->setDaten($_POST);
                    $user->speichere();
                    $this->verbindeKlient($_POST, $user->getId());

                    redirect('index.php?action=klientliste');
                } else {
                    redirect('#my_popup_nfc');
                }
            } else {
                redirect('#my_popup_names');
            }
        }
        $this->addContext('user', $user);
        $this->addContext('userliste', $userliste);
        $this->addContext('ueberschrift', "Neuer Klient");
        $this->setTemplate('bearbeiteKlientAction');
    }

    protected function neuNachrichtAction()
    {
        $nachricht = new Nachricht();
        $nutzerliste = Klient::findeAlle("vorname","vorname");

        if($_POST)
        {
            if (!empty($_POST["datestart"]) && !empty($_POST["dateend"])) {
                if (!empty($_POST["text"])) {
                    $daten = $this->datenabfrage($_POST);

                    $nachricht->setDaten($daten);

                    $timestamp = time();
                    $datetime = date("Y-m-d H:i:s", $timestamp);

                    $nachricht->setDatetime($datetime);
                    $nachricht->speichere();

                    $this->verbinde($daten, $nachricht->getId(), false);
                    redirect('index.php?action=nachrichtenliste');
                } else {
                    redirect('#my_popup_text');
                }
            } else {
                redirect('#my_popup_date');
            }
        }

        $this->addContext('nachricht', $nachricht);
        $this->addContext('nutzerliste', $nutzerliste);
        $this->addContext('ueberschrift', "Neue Nachricht");
        $this->setTemplate('bearbeiteNachrichtAction');
    }

    protected function klientlisteAction()
    {

        //wenn es ein Betreuer zu löschen gibt löschen
        if(isset($_GET['loesche'])){
            //suche das user mit der id von loesche
            $user = Klient::finde('id', $_GET['loesche']);
            //teste ob user instanceof Betreuer falls die id in der Datenbank nicht exestiert
            if($user instanceof Klient){
                $user->deleteConnection("BetreuerZuKlient", "KlientID", "", "");
                $user->deleteConnection("KlientZuNachricht", "KlientID", "", "");
                $user->loesche();
            }
        }

        if(isset($_GET['showAll'])){
            $this->addContext('userliste', Klient::findeAlle("vorname", "vorname"));

        }else{

            //todo an findXfrom Objekt eine übergabe mache zum sortieren
            $liste = Klient::findXfromObject("Betreuer", $_SESSION['userid'],"*");
            $this->addContext('userliste', $liste);
        }

        $this->addContext('sortiere', isset($_GET['sortiere']) ? $_GET['sortiere'] : 'titel');
        $this->addContext('suche', isset($_GET['suche']) ? $_GET['suche'] : '');

        //setze den ersten Eintrag auf true, der erste Eintrag bekommt im template eine zusätzliche id wenn es der
        //der erste Eintrag ist
        $this->addContext('ersterEintrag', true);
    }

    //bearbeite irgendein Klient
    protected function bearbeiteKlientAction()
    {
        $user = Klient::finde('id', $_REQUEST['id']);
        $userliste = Betreuer::findeAlle("username", "username");

        if($_POST)
        {
            if (!empty($_POST["vorname"]) && !empty($_POST["name"])) {
                if (!empty($_POST["nfcToken"])) {
                    $user->setDaten($_POST);
                    $user->speichere();

                    $this->verbindeKlient($_POST, $user->getId());

                    redirect('index.php?action=klientliste');
                } else {
                    redirect('index.php?action=bearbeiteKlient&id=' . $_POST["id"] . '#my_popup_nfc');
                }
            } else {
                redirect('index.php?action=bearbeiteKlient&id=' . $_POST["id"] . '#my_popup_names');
            }
        }

        $this->addContext('userliste', $userliste);
        $this->addContext('ueberschrift', "Bearbeite Klient");
        $this->addContext('user', $user);
    }

    protected function bearbeiteNachrichtAction()
    {
        $nachricht = Nachricht::finde('id', $_REQUEST['id']);
        $nutzerliste = Klient::findeAlle("vorname","vorname");

        if($_POST)
        {
            if (!empty($_POST["datestart"]) && !empty($_POST["dateend"])) {
                if (!empty($_POST["text"])) {

                    $daten = $this->datenabfrage($_POST);

                    $nachricht->setDaten($daten);
                    $nachricht->speichere();

                    $this->verbinde($daten, $nachricht->getId(), true);
                    redirect('index.php?action=nachrichtenliste');
                } else {
                    redirect('index.php?action=bearbeiteNachricht&id=' . $_POST["id"] . '#my_popup_text');
                }
            } else {
                redirect('index.php?action=bearbeiteNachricht&id=' . $_POST["id"] . '#my_popup_date');
            }
        }

        $this->addContext('nachricht', $nachricht);
        $this->addContext('ueberschrift', "Bearbeite Nachricht");
        $this->addContext('nutzerliste', $nutzerliste);
    }

    //bearbeite irgendein Betreuer
    protected function bearbeiteAction()
    {
        $user = Betreuer::finde('id', $_REQUEST['id']);

        if($_POST)
        {
            if (!empty($_POST["username"])) {
                if (!empty($_POST["password"]) && !empty($_POST["password2"])) {
                    if (strcmp($_POST["password"], $_POST["password2"]) == 0) {
                        $user->setDaten($_POST);
                        $user->speichere();
                        redirect('index.php?action=userliste');
                    } else {
                        redirect('index.php?action=bearbeite&id=' . $_POST['id'] . '#my_popup_mismatch');
                    }
                } else {
                    redirect('index.php?action=bearbeite&id=' . $_POST['id'] . '#my_popup_empty');
                }
            } else {
                redirect('index.php?action=bearbeite&id=' . $_POST['id'] . '#my_popup_emptyName');
            }
        }

        $this->addContext('user', $user);
        $this->addContext('ueberschrift', "Bearbeite Klient");
    }

    //bearbeite eigenen Betreuer
    protected function editAction()
    {

        $user = Betreuer::finde('id', $_SESSION['userid']);

        if($_POST)
        {

            $user->setDaten($_POST);
            $user->speichere();
            redirect('index.php?action=profile');
        }

        $this->setTemplate('edit'.ucwords($_GET['toEdit']).'Action');
        $this->addContext('user', $user);
    }


    protected function profileAction()
    {
        $user = Betreuer::finde('id', $_SESSION['userid']);
        $this->addContext('user', $user);
    }

    protected function loginAction()
    {

        if($_POST)
        {
            //suche den user mit dem entsprechenden username raus
            $user = Betreuer::findeName($_REQUEST['username']);

            if($user == null){
                redirect('#my_popup_nouser');
            }else{

                if(password_verify($_REQUEST['password'] , $user->getPassword())){
                    $_SESSION['userid'] = $user->getId();
                    redirect('index.php');
                }else{
                    redirect('#my_popup_incorrectpw');
                }
            }
        }

        $this->setTemplate('loginAction');
    }

    protected function logoutAction()
    {
        session_destroy();
        redirect("index.php?action=login");
        //$this->setTemplate('loginAction');
    }

    protected function datenabfrage($daten) {
        $daten['monday'] = (isset($daten['monday']) ? $daten['monday'] : false);
        $daten['tuesday'] = (isset($daten['tuesday']) ? $daten['tuesday'] : false);
        $daten['wednesday'] = (isset($daten['wednesday']) ? $daten['wednesday'] : false);
        $daten['thursday'] = (isset($daten['thursday']) ? $daten['thursday'] : false);
        $daten['friday'] = (isset($daten['friday']) ? $daten['friday'] : false);
        $daten['saturday'] = (isset($daten['saturday']) ? $daten['saturday'] : false);
        $daten['sunday'] = (isset($daten['sunday']) ? $daten['sunday'] : false);

        return $daten;
    }

    protected function verbinde($daten, $nachrichtID, $bearbeite) {
        $klienten = $daten['klientenwahl'];

        $savedKlient = Klient::findXfromObject("Nachricht", $nachrichtID, "id");

        if ($bearbeite) {

            //alle schon gespeicherten klienten durchgehen
            foreach ($savedKlient as $be) {
                $found = false;

                //alle ausgewählen klienten durchgehen
                foreach ($klienten as $pe) {

                    if ($pe == $be->getId()) {
                        $found = true;
                    }

                }
                //war der ausgewählte klienten
                if (!$found) {
                    Klient::finde('id', $be->getId())->deleteConnection("KlientZuNachricht", "KlientID", "NachrichtID", $nachrichtID);
                }
            }

        }
        $found = false;
        //alle ausgewählen klienten durchgehen
        foreach ($klienten as $pe) {
            $found = false;
            //alle schon gespeicherten klienten durchgehen
            foreach ($savedKlient as $be) {
                if($pe == $be->getId()){
                    $found = true;
                }
            }
            //war der ausgewählte klienten
            if (!$found) {

                $attribute["Klient"] = $pe;
                $attribute["Nachricht"] = $nachrichtID;
                //todo entfernen von klient objekt
                $test = new Klient;
                $test->insertVerbindung($attribute, "KlientZuNachricht");
            }
        }

    }

    protected function verbindeKlient($daten, $klientID) {
        $betreuer = $daten['betreuerwahl'];

        $savedBetreuer = Betreuer::findXfromObject("Klient", $klientID, "id");

        //alle schon gespeicherten betreuer durchgehen
        foreach ($savedBetreuer as $be) {
            $found = false;
            //alle ausgewählen betreuer durchgehen
            foreach ($betreuer as $pe) {

                if($pe == $be->getId()){
                    $found = true;
                }
            }
            //war der ausgewählte betreuer
            if (!$found) {
                Betreuer::finde('id', $be->getId())->deleteConnection("BetreuerZuKlient", "BetreuerID", "KlientID", $klientID);
            }
        }

        $found = false;
        //alle ausgewählen betreuer durchgehen
        foreach ($betreuer as $pe) {
            $found = false;
            //alle schon gespeicherten betreuer durchgehen
            foreach ($savedBetreuer as $be) {
                if($pe == $be->getId()){
                    $found = true;
                }
            }
            //war der ausgewählte betreuer
            if (!$found) {

                $attribute["Betreuer"] = $pe;
                $attribute["Klient"] = $klientID;
                //todo entfernen von klient objekt
                $test = new Klient;
                $test->insertVerbindung($attribute, "BetreuerZuKlient");
            }
        }
    }
}