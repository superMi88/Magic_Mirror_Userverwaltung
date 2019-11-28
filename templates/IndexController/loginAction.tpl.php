<form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">


    <div id="std-container">
        <div class="login" id="main">

            <h3 class="item">Anmelden</h3>

            <div class="inputs">

                <?php if ($WrongUsername == true) { ?>

                    <p id="wrongInputUser">
                        Nutzername ist falsch oder Nutzer existiert nicht!
                    </p>
                <?php } ?>

                <div class="inputContainer inputContainerUser">
                    <input type="text" name="username" id="username" placeholder="Benutzername" value="<?php echo $_POST['username'];?>" />
                </div>
            </div>

            <div class="inputs">
                <?php if ($WrongPassword == true) { ?>
                    <p id="wrongInputPass">
                        Passwort ist falsch!
                    </p>
                <?php } ?>

                <div class="inputContainer inputContainerPassword">
                    <input type="password" name="password" id="password" placeholder="Passwort" value="" />
                </div>
            </div>

            <input class="btn" type="submit" value="anmelden">

            <a id="my_popup_nouser" href="#" class="popup"></a>
            <div class="popup">
                <p>Dieser Nutzer existiert nicht.</p>
                <a class="button close" href="#">Ok</a>
            </div>

            <a id="my_popup_incorrectpw" href="#" class="popup"></a>
            <div class="popup">
                <p>Inkorrektes Passwort für diesen Nutzer.</p>
                <a class="button close" href="#">Ok</a>
            </div>

        </div>
    </div>

</form>