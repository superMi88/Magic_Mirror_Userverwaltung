<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buchverwaltung</title>
</head>


<?php

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

?>

<body class=<?=$action?> >


<!--Kopfbereich-->

<?php
if(isset($_SESSION['userid'])) {
    require 'navigation.tpl.php';
}

?>

<!--Inhalt-->
<div id="main-container">
    <?php require $template; ?>
</div>

<!--Fussbereich-->

</body>


</html>