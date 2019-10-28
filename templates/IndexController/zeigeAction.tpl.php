<div id="std-container">
    <div class="content" id="main">
        <div class="eintrag info">
            <h3 class="item">Username</h3>
            <div class="item"><?= bereinige($user->getUsername()) ?></div>
        </div>



        <?php

    foreach ($klientliste as $id => $klient): ?>
        <div class="eintrag buch"
            <?php if($ersterEintrag == true) {?>
                id="ersterEintrag"
                <?php
                $ersterEintrag = false;
            } ?>
        >

            <a class="item left" href="index.php?action=zeigeKlient&id=<?= (int)$klient->getId() ?>">
                <?= bereinige($klient->getName()) ?>
            </a>
            <a class="item left" href="index.php?action=zeigeKlient&id=<?= (int)$klient->getId() ?>">
                <?= bereinige($klient->getVorname()) ?>
            </a>

            <a class="item right" href="index.php?action=klientliste&loesche=<?= (int)$klient->getId() ?>">
                <i class="fas fa-trash"></i>
            </a>

            <a class="item right" href="index.php?action=bearbeiteKlient&id=<?= (int)$klient->getId() ?>">
                <i class="fa fa-fw fa-edit"></i>
            </a>

        </div>
    <?php endforeach; ?>

    </div>
</div>