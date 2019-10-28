<form class="searchding" autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="get">

    <div id="search-box" class="content">

        <input type="hidden" name="action" value="userliste" />

        <div class="btn2">
            <input class="select-wrapper" type="text" name="suche" id="suche" placeholder="Suche" value="<?= bereinige($_GET['suche']) ?>" />
            <button class="iconOben" type="submit"><i class="fas fa-search"></i></button>
        </div>



        <a href="index.php?action=neu" class="btn2 fest smallAt600">
            <div class="alignItem">
                <p class="hiddenAt600">Neuen Betreuer anlegen</p>
            </div>
            <i class="icon fas fa-user-plus iconOben""></i>
        </a>

    </div>
</form>

<div class="content">

    <?php
    foreach ($userliste as $id => $user): ?>
        <div class="eintrag buch"
            <?php if($ersterEintrag == true) {?>
                id="ersterEintrag"
                <?php
                $ersterEintrag = false;
            } ?>
        >

            <a class="item left" href="index.php?action=zeige&id=<?= (int)$user->getId() ?>">
                <?= bereinige($user->getUsername()) ?>
            </a>

            <a class="item right" href="#my_popup<?= $user->getId() ?>">
                <i class="fas fa-trash"></i>
            </a>

            <a class="item right" href="index.php?action=bearbeite&id=<?= (int)$user->getId() ?>">
                <i class="fa fa-fw fa-edit"></i>
            </a>

            <a id="my_popup<?= $user->getId() ?>" href="#" class="popup"></a>
            <div class="popup">
                <h3>Warnung!</h3>
                <p>Bist du dir sicher dass du den Betreuer '<?= $user->getUsername() ?>' löschen möchtest?</p>
                <a class="button" href="index.php?action=userliste&loesche=<?= (int)$user->getId() ?>">Löschen</a>
                <a class="button close" href="#">Abbrechen</a>
            </div>

        </div>
    <?php endforeach;

    //wenn dieser eintrag der erste Eintrag wird kein Buch angezeigt
    if($ersterEintrag){
        ?>
        <div class="eintrag buch" id="ersterEintrag">
            <?php
            //Wenn die Suche Leer ist wird gesagt das in der Datenbank keine Buecher exestieren
            if($suche == ''){
                ?>
                <h3 class="item left">Es exestieren keine Benutzer in der Datenbank</h3>
                <?php
            }
            //Wenn die Suche nicht leer ist wird angezeigt das es keine Ergebnisse fuer die Suche gab
            else{
                ?>
                <h3 class="item left">Es wurde kein Benutzer mit dem Namen "<?= $suche ?>" gefunden</h3>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>

</div>



