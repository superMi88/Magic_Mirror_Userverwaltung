<?php

abstract class AbstractBase
{
    //speichert ein Befehl ab
    protected $context = [];
    protected $template = '';
    protected $signedInUser;

    public function run($action)
    {
        $this->addContext('action', $action);

        if(isset($_SESSION['userid'])) {

            //Abfrage der Nutzer ID vom Login
            $signedInUser = Betreuer::finde('id', $_SESSION['userid']);

            $this->signedInUser = $signedInUser;
            //damit ich auf den zurzeit eingeloggten user zugreifen kann
            $this->addContext('signedInUser', $signedInUser);

        }else{

            $signedInUser = new Betreuer();
            $signedInUser->setUsername("Gast");

            if($_GET["action"] != "login"){
                redirect("index.php?action=login");
            }

            $this->signedInUser = $signedInUser;
            //damit ich auf den zurzeit eingeloggten user zugreifen kann
            $this->addContext('signedInUser', $signedInUser);

        }

        $methodName = $action . 'Action';
        $this->setTemplate($methodName);

        if(method_exists($this, $methodName)) {

            $this->$methodName();
        }
        $this->render();
    }

    protected function setTemplate($template, $controller = null)
    {
        if(empty($controller)) {
            $controller = get_class($this);
        }

        $this->template = $controller . '/' . $template . '.tpl.php';
    }

    protected function getTemplate()
    {
        return $this->template;
    }

    protected function addContext($key, $value)
    {
        $this->context[$key] = $value;
    }

    protected function render()
    {
        //macht aus dem assoziativ Array aus dem key und dem value, eine varialbe mit dem einem Wert
        extract($this->context);

        //legt das template in einer variable $template ab die in layout.tpl.php gebraucht wird um ihn zu laden
        $template =  $this->getTemplate();

        require_once 'templates/layout.tpl.php';
    }
}