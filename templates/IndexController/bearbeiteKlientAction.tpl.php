
<form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">
    <div id="std-container">
        <div class="content" id="main">

            <div class="eintrag info">
                <div class="box left">
                    <h3><?= $ueberschrift ?></h3>
                </div>
            </div>


            <input type="hidden" name="id" value="<?= (int)$user->getId() ?>" />

            <div class="eintrag">
                <label for="betreuerwahl" class="item">Zuweisen an:</label>

                <select class="item" name="betreuerwahl[]" id="betreuerwahl" multiple>

                    <?php foreach ($userliste as $listedUser) { ?>

                        <option value="<?= $listedUser->getId() ?>" <?php
                            $betreuer = Betreuer::findXfromObject("Klient", $user->getId(), "*");
                            $unique = true;
                            foreach ($betreuer as $betreuerEinzel) {
                                if ((int)$betreuerEinzel->getId() == (int)$listedUser->getId()) {
                                    $unique = false;
                                }
                            }
                            if (!$unique) {
                                ?> selected <?php
                            }
                            ?> > <?=
                                $listedUser->getUsername();
                                ?> </option>
                    <?php } ?>
                </select>
            </div>


            <div class="eintrag">
                <div class="box left">
                    <label for="vorname" class="item">Vorname</label>
                    <input class="item" type="text" name="vorname" id="vorname" placeholder="Vorname" value="<?= bereinige($user->getVorname()) ?>" />
                </div>
            </div>

            <div class="eintrag">
                <div class="box left">
                    <label for="name" class="item">Name</label>
                    <input class="item" type="text" name="name" id="name" placeholder="Name" value="<?= bereinige($user->getName()) ?>" />
                </div>
            </div>

            <div class="eintrag info">
                <div class="box left">
                    <label for="nfcToken" class="item">NFC-Token</label>
                    <input class="item" type="text" name="nfcToken" id="nfcToken" placeholder="nfcToken" value="<?= bereinige($user->getNfcToken()) ?>" />
                </div>
            </div>

            <div class="box right">
                <input class="item left" type="submit" value="speichern">
            </div>

            <a id="my_popup_names" href="#" class="popup"></a>
            <div class="popup">
                <p>Mindestens eines der Namensfelder ist leer!</p>
                <a class="button close" href="#">Ok</a>
            </div>

            <a id="my_popup_nfc" href="#" class="popup"></a>
            <div class="popup">
                <p>Der NFC-Token darf nicht leer sein!</p>
                <a class="button close" href="#">Ok</a>
            </div>
        </div>
    </div>
</form>