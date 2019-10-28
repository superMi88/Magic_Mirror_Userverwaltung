<div id="std-container">
    <div class="content" id="main">
        <div class="eintrag info">
            <h3 class="item">Nachricht</h3>
            <div class="item"><?= bereinige($nachricht->getText()) ?></div>
        </div>

        <div class="eintrag info">
            <h3 class="item">Wichtigkeit</h3>
            <div class="item"><?= bereinige($nachricht->getWichtigkeit()) ?></div>
        </div>

        <div class="eintrag info">
            <h3 class="item">Anfangsdatum</h3>
            <div class="item"><?= date("d.m.Y", strtotime(bereinige($nachricht->getDatestart()))) ?></div>
            <h3 class="item">Enddatum</h3>
            <div class="item"><?= date("d.m.Y", strtotime(bereinige($nachricht->getDateend()))) ?></div>
        </div>

        <div class="eintrag info">
            <h3 class="item">Nächster Termin</h3>
            <div class="item"><?= $nachricht->getNextDate() ?></div>
        </div>

    </div>
</div>