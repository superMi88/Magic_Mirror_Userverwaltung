
<div id="std-container">
    <div class="content" id="main">

        <div class="simpleBox">
        <div class="eintrag info">
            <form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">


                <div class="eintrag info">
                    <h3>Passwort</h3>
                    <div class="box left">
                        <input class="item" type="text" name="password" id="password" placeholder="Passwort" value="" />
                    </div>
                </div>

                <div class="eintrag info">
                    <h3>Passwort wiederholen</h3>
                    <div class="box left">
                        <input class="item" type="text" name="password2" id="password2" placeholder="Passwort wiederholen" value="" />
                    </div>
                </div>

                <input class="btn" type="submit" value="speichern">

            </form>
        </div>


        <div class="eintrag info">

            <form action="index.php?action=<?=bereinige($action) ?>" method="post" enctype="multipart/form-data">
                <div class="eintrag info">
                    <div class="box left">
                        <img class="profileImg" src='<?php echo $user->getImage(); ?>'>
                    </div>
                </div>
                <div class="eintrag info">
                    <div class="box left">
                        <input class="item left" type="file" name="file"/>
                    </div>
                </div>
                <div class="eintrag info">
                    <div class="box left">
                        <input class="btn" type="submit" name="image" value="speichern von Bild"/>
                    </div>
                </div>
            </form>
        </div>
        </div>
        <div class="simpleBox">
        <div class="eintrag info">

            <form autocomplete="off" action="index.php?action=<?=bereinige($action) ?>" method="post">

                <div class="eintrag info">
                    <h3 class="item">Benutzername</h3>
                    <div class="box left">
                        <input class="item" type="text" name="username" id="username" placeholder="Benutzername" value="<?= bereinige($user->getUsername()) ?>" />
                    </div>
                </div>

                <div class="eintrag info">
                    <h3 class="item">Name</h3>
                    <div class="box left">
                        <input class="item" type="text" name="name" id="name" placeholder="Name" value="<?= bereinige($user->getName()) ?>" />
                    </div>
                </div>

                <div class="eintrag info">
                    <h3 class="item">E-Mail</h3>
                    <div class="box left">
                        <input class="item" type="text" name="eMail" id="eMail" placeholder="E-Mail" value="<?= bereinige($user->getEMail()) ?>" />
                    </div>
                </div>

                <div class="eintrag info">
                    <h3 class="item">Geburtsdatum</h3>
                    <div class="box left">
                        <input class="item" type="text" name="dateOfBirth" id="dateOfBirth" placeholder="Geburtsdatum" value="<?= $user->getDateOfBirth() ?>" />
                    </div>
                </div>

                <div class="eintrag info">
                    <h3 class="item">Berechtigung</h3>
                    <div class="box left">
                        <input class="item" type="text" name="authorization" id="authorization" placeholder="Berechtigung" value="<?= bereinige($user->getAuthorization()) ?>" />
                    </div>
                </div>

                <input class="btn" type="submit" value="speichern">


            </form>
        </div>
        </div>
    </div>
</div>