<form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">


    <div id="std-container">
        <div class="login" id="main">

            <h3 class="item">Anmelden</h3>

            <div class="inputContainer">
                <input type="text" name="username" id="username" placeholder="Benutzername" value="" />
            </div>


            <div class="inputContainer">
                <input type="password" name="password" id="password" placeholder="Passwort" value="" />
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