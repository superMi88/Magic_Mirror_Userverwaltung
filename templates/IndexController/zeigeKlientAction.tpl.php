<div id="std-container">
    <div class="content" id="main">
        <div class="eintrag info">
            <h3 class="item">Vorname</h3>
            <div class="item"><?= bereinige($user->getVorname()) ?></div>
        </div>

        <div class="eintrag info">
            <h3 class="item">Name</h3>
            <div class="item"><?= bereinige($user->getName()) ?></div>
        </div>

        <div class="eintrag info">
            <h3 class="item">NfcToken</h3>
            <div class="item"><?= bereinige($user->getNfcToken()) ?></div>
        </div>

    </div>
</div>