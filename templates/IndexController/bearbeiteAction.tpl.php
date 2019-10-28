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
                <div class="box left">
                    <label for="username" class="item">Benutzername</label>
                    <input class="item" type="text" name="username" id="username" placeholder="Benutzername" value="<?= bereinige($user->getUsername()) ?>" />
                </div>
            </div>

            <div class="eintrag">
                <div class="box left">
                    <label for="password" class="item">Passwort</label>
                    <input class="item" type="password" name="password" id="password" placeholder="Passwort" value="" />
                </div>
            </div>

            <div class="eintrag info">
                <div class="box left">
                    <label for="password2" class="item">Passwort</label>
                    <input class="item" type="password" name="password2" id="password2" placeholder="Passwort wiederholen" value="" />
                </div>
            </div>

            <div class="box right">
                <input class="item left" type="submit" value="speichern">
            </div>

            <a id="my_popup_mismatch" href="#" class="popup"></a>
            <div class="popup">
                <p>Die eingegebenen Passwörter stimmen nicht überein!</p>
                <a class="button close" href="#">Ok</a>
            </div>

            <a id="my_popup_empty" href="#" class="popup"></a>
            <div class="popup">
                <p>Mindestens eines der Passwortfelder ist leer.</p>
                <a class="button close" href="#">Ok</a>
            </div>

            <a id="my_popup_emptyName" href="#" class="popup"></a>
            <div class="popup">
                <p>Nutzername darf nicht leer sein.</p>
                <a class="button close" href="#">Ok</a>
            </div>
        </div>
    </div>
</form>